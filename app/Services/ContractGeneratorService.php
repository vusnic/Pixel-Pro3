<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\ContractTemplate;
use Exception;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Log;

class ContractGeneratorService
{
    /**
     * Gera um contrato baseado no modelo e dados fornecidos
     *
     * @param ContractTemplate $template
     * @param array $data
     * @param string $format
     * @return Contract
     */
    public function generateContract(ContractTemplate $template, array $data, string $format = 'docx')
    {
        // Atualizar o logger com informações iniciais
        Log::info("Iniciando geração de contrato com template #{$template->id}, caminho: {$template->file_path}");
        
        // Verificar se é o arquivo sample.docx
        if (basename($template->file_path) === 'sample.docx') {
            Log::error("Tentativa de usar arquivo sample.docx como template. Template ID: {$template->id}");
            throw new Exception("Não é possível usar o arquivo de amostra como modelo. Por favor, carregue um arquivo de modelo válido.");
        }
        
        // Verificar no storage do Laravel primeiro
        $storageExists = Storage::exists($template->file_path) && Storage::size($template->file_path) > 0;
        
        // Verificar caminhos absolutos (local e Docker)
        $localPath = storage_path('app/' . $template->file_path);
        $dockerPath = '/var/www/storage/app/' . $template->file_path;
        
        $localExists = file_exists($localPath) && filesize($localPath) > 0;
        $dockerExists = file_exists($dockerPath) && filesize($dockerPath) > 0;
        
        Log::info("Verificação de arquivo: Storage: " . ($storageExists ? "SIM" : "NÃO") . 
                 ", Local: " . ($localExists ? "SIM" : "NÃO") . 
                 ", Docker: " . ($dockerExists ? "SIM" : "NÃO"));
        
        // Se não existe no Storage, mas existe no Docker, copiar para o Storage
        if (!$storageExists && $dockerExists) {
            try {
                Log::info("Copiando arquivo do Docker para o Storage: {$dockerPath} -> {$template->file_path}");
                $content = file_get_contents($dockerPath);
                Storage::put($template->file_path, $content);
                
                // Definir permissões adequadas
                chmod($dockerPath, 0777);
                
                $storageExists = true; // Agora deve existir
                
                Log::info("Arquivo copiado com sucesso do Docker para o Storage");
            } catch (\Exception $e) {
                Log::error("Falha ao copiar arquivo do Docker para o Storage: " . $e->getMessage());
                // Continuar tentando outros métodos
            }
        }
        
        // Se não existe no Storage, mas existe localmente, copiar para o Storage
        if (!$storageExists && $localExists) {
            try {
                Log::info("Copiando arquivo local para o Storage: {$localPath} -> {$template->file_path}");
                $content = file_get_contents($localPath);
                Storage::put($template->file_path, $content);
                
                // Definir permissões adequadas
                chmod($localPath, 0777);
                
                $storageExists = true; // Agora deve existir
                
                Log::info("Arquivo copiado com sucesso do local para o Storage");
            } catch (\Exception $e) {
                Log::error("Falha ao copiar arquivo local para o Storage: " . $e->getMessage());
                // Continuar tentando outros métodos
            }
        }
        
        // Se o arquivo ainda não foi encontrado, procurar outros templates
        if (!$storageExists && !$localExists && !$dockerExists) {
            Log::error("Arquivo de template não encontrado em nenhum local disponível: {$template->file_path}");
            
            // Tentar encontrar um template alternativo
            $templateDir = 'contracts/templates';
            $found = false;
            
            if (Storage::exists($templateDir)) {
                $files = Storage::files($templateDir);
                
                foreach ($files as $file) {
                    if (pathinfo($file, PATHINFO_EXTENSION) === 'docx' && Storage::size($file) > 0) {
                        // Atualizar o template com o novo caminho
                        $template->update(['file_path' => $file]);
                        $storageExists = true;
                        $localPath = storage_path('app/' . $file);
                        $dockerPath = '/var/www/storage/app/' . $file;
                        
                        Log::info("Usando template alternativo: {$file}");
                        $found = true;
                        break;
                    }
                }
            }
            
            if (!$found) {
                throw new Exception("Arquivo de modelo não encontrado no sistema. Por favor, faça upload de um novo arquivo de template.");
            }
        }
        
        // Garantir permissões de leitura
        if ($localExists) {
            chmod($localPath, 0777);
            Log::info("Permissões atualizadas para o arquivo: {$localPath}");
        }
        
        if ($dockerExists) {
            chmod($dockerPath, 0777);
            Log::info("Permissões atualizadas para o arquivo: {$dockerPath}");
        }
        
        // Continuar com a validação de dados e criação do registro
        $this->validateData($data);
        $contract = $this->createContractRecord($template, $data, $format);
        
        // Verificar e criar diretório para contratos gerados se necessário
        $generatedDir = storage_path('app/contracts/generated');
        $dockerGeneratedDir = '/var/www/storage/app/contracts/generated';
        
        if (!file_exists($generatedDir)) {
            Log::info("Criando diretório para contratos gerados: {$generatedDir}");
            mkdir($generatedDir, 0777, true);
        }
        
        // Criar diretório Docker para contratos gerados
        try {
            if (!file_exists($dockerGeneratedDir)) {
                Log::info("Criando diretório Docker para contratos gerados: {$dockerGeneratedDir}");
                mkdir($dockerGeneratedDir, 0777, true);
            }
        } catch (\Exception $e) {
            Log::warning("Não foi possível criar diretório Docker para contratos gerados: {$dockerGeneratedDir}. Erro: " . $e->getMessage());
        }
        
        // Garantir permissões para os diretórios de destino
        chmod($generatedDir, 0777);
        
        try {
            chmod($dockerGeneratedDir, 0777);
        } catch (\Exception $e) {
            Log::warning("Erro ao definir permissões para diretório Docker: " . $e->getMessage());
        }

        try {
            // Processar o documento
            Log::info("Iniciando processamento do template: {$localPath}");
            
            // Determinar qual caminho usar para o processamento
            $pathToUse = null;
            
            // Primeiro, tentar usar o caminho do Storage
            if ($storageExists) {
                $fileContent = Storage::get($template->file_path);
                if (!empty($fileContent)) {
                    // Criar arquivo temporário do conteúdo do Storage
                    $tempFile = tempnam('/tmp', 'docx_');
                    file_put_contents($tempFile, $fileContent);
                    $pathToUse = $tempFile;
                    
                    Log::info("Usando conteúdo do Storage para processamento");
                }
            }
            
            // Se não funcionou pelo Storage, tentar caminho local
            if (!$pathToUse && $localExists) {
                $pathToUse = $localPath;
                Log::info("Usando caminho local para processamento: {$pathToUse}");
            }
            
            // Se não funcionou pelo caminho local, tentar caminho do Docker
            if (!$pathToUse && $dockerExists) {
                $pathToUse = $dockerPath;
                Log::info("Usando caminho do Docker para processamento: {$pathToUse}");
            }
            
            if (!$pathToUse) {
                Log::error("Não foi possível determinar um caminho válido para o arquivo de template");
                throw new Exception("Não foi possível acessar o arquivo de template em nenhum local.");
            }
            
            Log::info("Usando caminho para processamento: {$pathToUse}");
            
            // Verificar se temos permissão para ler o arquivo
            if (!is_readable($pathToUse)) {
                Log::error("Arquivo não tem permissão de leitura: {$pathToUse}");
                // Tenta corrigir permissões
                @chmod($pathToUse, 0777);
                if (!is_readable($pathToUse)) {
                    throw new Exception("Não foi possível ler o arquivo de template. Verifique as permissões.");
                }
                Log::info("Permissões corrigidas para o arquivo: {$pathToUse}");
            }
            
            // Verificar o tamanho do arquivo
            $fileSize = filesize($pathToUse);
            Log::info("Tamanho do arquivo: {$fileSize} bytes");
            
            if ($fileSize <= 0) {
                Log::error("Arquivo vazio: {$pathToUse}");
                throw new Exception("O arquivo de template está vazio.");
            }
            
            // Usar arquivo temporário no /tmp, que geralmente tem permissões no Docker
            $tempFile = tempnam('/tmp', 'docx_');
            $copySuccess = false;
            
            // Tenta diferentes métodos para copiar o arquivo
            if (copy($pathToUse, $tempFile)) {
                $copySuccess = true;
                Log::info("Arquivo copiado com sucesso usando copy(): {$tempFile}");
            } elseif (file_exists($pathToUse)) {
                $content = file_get_contents($pathToUse);
                if ($content !== false) {
                    file_put_contents($tempFile, $content);
                    $copySuccess = true;
                    Log::info("Arquivo copiado com sucesso usando file_get_contents/file_put_contents: {$tempFile}");
                }
            }
            
            if (!$copySuccess) {
                Log::error("Falha ao copiar para arquivo temporário: {$tempFile}");
                throw new Exception("Não foi possível criar uma cópia temporária do template.");
            }
            
            // Verificar se a cópia temporária tem o mesmo tamanho do original
            $tempFileSize = filesize($tempFile);
            if ($tempFileSize !== $fileSize) {
                Log::error("Tamanho do arquivo temporário ({$tempFileSize}) é diferente do original ({$fileSize})");
                // Continuar mesmo assim, pode ser um problema de cálculo de tamanho em diferentes sistemas de arquivos
                Log::warning("Continuando mesmo com diferença de tamanho");
            }
            
            Log::info("Arquivo temporário criado com sucesso: {$tempFile}, tamanho: {$tempFileSize} bytes");
            
            // Usar o arquivo temporário
            try {
                $processor = new TemplateProcessor($tempFile);
                
                // Analisar o arquivo para verificar os placeholders disponíveis
                try {
                    // Criar diretório de debug temporário no Docker também se não existir
                    $debugDir = '/var/www/tmp/docx_debug';
                    if (!file_exists($debugDir)) {
                        Log::info("Criando diretório de debug: {$debugDir}");
                        try {
                            mkdir($debugDir, 0777, true);
                        } catch (\Exception $e) {
                            Log::warning("Não foi possível criar diretório de debug: " . $e->getMessage());
                        }
                    }
                    
                    // Verificar se o diretório existe antes de tentar copiar
                    if (file_exists($debugDir)) {
                        $debugFile = $debugDir . '/template_' . time() . '.docx';
                        try {
                            if (copy($tempFile, $debugFile)) {
                                chmod($debugFile, 0777);
                                Log::info("Cópia do template salva para debug em: {$debugFile}");
                                
                                // Tentar detectar os placeholders no arquivo
                                try {
                                    $debugProcessor = new TemplateProcessor($debugFile);
                                    $variables = $debugProcessor->getVariables();
                                    
                                    Log::info("Placeholders encontrados no template: " . json_encode($variables));
                                    
                                    // Verificar se os placeholders esperados existem no template
                                    $missingPlaceholders = [];
                                    foreach ($data as $key => $value) {
                                        if (!in_array($key, $variables) && !in_array('{'.$key.'}', $variables)) {
                                            $missingPlaceholders[] = $key;
                                        }
                                    }
                                    
                                    if (!empty($missingPlaceholders)) {
                                        Log::warning("Placeholders esperados mas não encontrados no template: " . json_encode($missingPlaceholders));
                                    }
                                } catch (\Exception $e) {
                                    Log::warning("Não foi possível analisar os placeholders do template: " . $e->getMessage());
                                }
                            } else {
                                Log::warning("Falha ao copiar arquivo para debug: de {$tempFile} para {$debugFile}");
                            }
                        } catch (\Exception $e) {
                            Log::warning("Exceção ao copiar arquivo para debug: " . $e->getMessage());
                        }
                    } else {
                        Log::warning("Diretório de debug não existe: {$debugDir}");
                    }
                } catch (\Exception $e) {
                    Log::warning("Erro no processo de debug: " . $e->getMessage());
                }
                
                // Substituir todos os placeholders pelos valores
                foreach ($data as $key => $value) {
                    try {
                        // Verificar se o placeholder existe
                        if (is_string($value)) {
                            Log::info("Substituindo placeholder '{$key}' pelo valor: {$value}");
                            
                            // Testar diferentes formatos de placeholders
                            $formats = [
                                $key,            // Formato normal: ClientName
                                '{'.$key.'}',    // Formato com chaves: {ClientName}
                                '$'.$key,        // Formato com cifrão: $ClientName
                                '${'.$key.'}',   // Formato com cifrão e chaves: ${ClientName}
                            ];
                            
                            $substituted = false;
                            foreach ($formats as $format) {
                                try {
                                    $processor->setValue($format, $value);
                                    $substituted = true;
                                    Log::info("Substituído placeholder no formato: {$format}");
                                } catch (\Exception $e) {
                                    // Ignorar erros se o formato não existir
                                }
                            }
                            
                            if (!$substituted) {
                                Log::warning("Nenhum formato de placeholder funcionou para '{$key}'");
                            }
                        } else {
                            Log::info("Substituindo placeholder '{$key}' por valor não-string convertido");
                            try {
                                $processor->setValue($key, (string)$value);
                            } catch (\Exception $e) {
                                try {
                                    $processor->setValue('{'.$key.'}', (string)$value);
                                } catch (\Exception $e2) {
                                    // Ignorar se ambos os formatos não existirem
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        Log::warning("Falha ao substituir placeholder '{$key}': " . $e->getMessage());
                        // Continuar com os outros placeholders
                    }
                }
                
                // Verificar se existem placeholders específicos comuns e tenta formatos mais complexos
                $commonPlaceholders = [
                    'ClientName', 'ClientAddress', 'ServiceType', 'ProjectDescription', 
                    'StartDate', 'DeliveryDate', 'TotalValue', 'PaymentMethod', 
                    'PaymentTerms', 'Warranty', 'SalesRepName'
                ];
                
                foreach ($commonPlaceholders as $placeholder) {
                    if (isset($data[$placeholder]) && !empty($data[$placeholder])) {
                        try {
                            // Tentar diferentes formatos de placeholder que podem existir no documento
                            $formats = [
                                $placeholder,         // Normal: ClientName
                                '{'.$placeholder.'}', // Com chaves: {ClientName}
                                '$'.$placeholder,     // Com cifrão: $ClientName
                                '${'.$placeholder.'}' // Com cifrão e chaves: ${ClientName}
                            ];
                            
                            foreach ($formats as $format) {
                                try {
                                    Log::info("Tentando substituir placeholder comum '{$format}' pelo valor: {$data[$placeholder]}");
                                    $processor->setValue($format, $data[$placeholder]);
                                } catch (\Exception $e) {
                                    // Ignorar erro se o placeholder não existir neste formato
                                }
                            }
                        } catch (\Exception $e) {
                            Log::warning("Falha ao substituir placeholder comum '{$placeholder}': " . $e->getMessage());
                        }
                    }
                }
                
                // Salvar o arquivo DOCX
                $docxFilename = "contract_{$contract->id}_" . Str::slug($contract->name) . '.docx';
                $docxPath = "contracts/generated/{$docxFilename}";
                $saveFullPath = storage_path("app/{$docxPath}");
                
                // Garantir que o diretório de destino existe
                $saveDir = dirname($saveFullPath);
                if (!file_exists($saveDir)) {
                    mkdir($saveDir, 0777, true);
                    Log::info("Diretório para salvar contrato criado: {$saveDir}");
                }
                
                // Verificar permissões do diretório de destino
                $isDirWritable = is_writable($saveDir);
                Log::info("Diretório de destino {$saveDir} é gravável: " . ($isDirWritable ? "SIM" : "NÃO"));
                
                if (!$isDirWritable) {
                    // Tentar corrigir permissões
                    @chmod($saveDir, 0777);
                    $isDirWritable = is_writable($saveDir);
                    Log::info("Diretório de destino após correção é gravável: " . ($isDirWritable ? "SIM" : "NÃO"));
                }
                
                Log::info("Tentando salvar arquivo gerado em: {$saveFullPath}");
                
                try {
                    $processor->saveAs($saveFullPath);
                    
                    // Verificar se o arquivo foi salvo
                    if (file_exists($saveFullPath) && filesize($saveFullPath) > 0) {
                        Log::info("Arquivo salvo com sucesso: {$saveFullPath}, tamanho: " . filesize($saveFullPath) . " bytes");
                        // Garantir que o arquivo é legível/gravável
                        @chmod($saveFullPath, 0666);
                    } else {
                        Log::error("Falha ao salvar o arquivo: {$saveFullPath} - Arquivo não existe ou está vazio");
                    }
                } catch (\Exception $e) {
                    Log::error("Exceção ao salvar arquivo: " . $e->getMessage());
                    
                    // Tentar método alternativo de salvamento
                    try {
                        $tempFile = tempnam('/tmp', 'contract_');
                        Log::info("Tentando salvar em arquivo temporário: {$tempFile}");
                        $processor->saveAs($tempFile);
                        
                        if (file_exists($tempFile) && filesize($tempFile) > 0) {
                            Log::info("Arquivo temporário criado com sucesso: {$tempFile}");
                            
                            // Copiar para o destino final
                            if (copy($tempFile, $saveFullPath)) {
                                Log::info("Arquivo copiado com sucesso para: {$saveFullPath}");
                                @chmod($saveFullPath, 0666);
                            } else {
                                Log::error("Falha ao copiar de {$tempFile} para {$saveFullPath}");
                                
                                // Tentar salvar diretamente usando o Storage do Laravel
                                $content = file_get_contents($tempFile);
                                if (Storage::put($docxPath, $content)) {
                                    Log::info("Arquivo salvo via Storage::put: {$docxPath}");
                                } else {
                                    Log::error("Falha ao salvar via Storage::put: {$docxPath}");
                                }
                            }
                            
                            @unlink($tempFile);
                        } else {
                            Log::error("Falha ao criar arquivo temporário: {$tempFile}");
                        }
                    } catch (\Exception $e2) {
                        Log::error("Exceção no método alternativo: " . $e2->getMessage());
                        throw $e; // Re-lançar exceção original
                    }
                }
                
                // Verificar se o arquivo foi salvo corretamente
                if (!file_exists($saveFullPath) || filesize($saveFullPath) <= 0) {
                    // Tenta salvar no caminho do Docker
                    $dockerSavePath = str_replace(base_path(), '/var/www', $saveFullPath);
                    Log::info("Tentando salvar no caminho do Docker: {$dockerSavePath}");
                    
                    try {
                        $processor->saveAs($dockerSavePath);
                        if (file_exists($dockerSavePath) && filesize($dockerSavePath) > 0) {
                            $saveFullPath = $dockerSavePath;
                            Log::info("Arquivo salvo com sucesso no caminho Docker: {$dockerSavePath}");
                        } else {
                            Log::error("Falha ao salvar arquivo gerado no caminho Docker: {$dockerSavePath}");
                            throw new Exception("Falha ao salvar o arquivo gerado.");
                        }
                    } catch (\Exception $e) {
                        Log::error("Exceção ao salvar no caminho Docker: " . $e->getMessage());
                        throw new Exception("Falha ao salvar o arquivo gerado: " . $e->getMessage());
                    }
                }
                
                Log::info("Contrato salvo em: {$saveFullPath}, tamanho: " . filesize($saveFullPath) . " bytes");
                
                // Certificar que o arquivo gerado é acessível
                chmod($saveFullPath, 0666);
                
                // Remover o arquivo temporário
                @unlink($tempFile);
                
                // Se o formato solicitado for PDF, converter para PDF
                if ($format === 'pdf') {
                    $pdfFilename = "contract_{$contract->id}_" . Str::slug($contract->name) . '.pdf';
                    $pdfPath = "contracts/generated/{$pdfFilename}";
                    $this->convertToPdf($docxPath, $pdfPath);
                    
                    // Verificar se o arquivo PDF foi gerado com sucesso
                    if (!Storage::exists($pdfPath) || Storage::size($pdfPath) <= 0) {
                        Log::error("Arquivo PDF não gerado ou vazio: {$pdfPath}");
                        throw new Exception("Falha ao gerar arquivo PDF.");
                    }
                    
                    // Atualizar o registro com o caminho do arquivo PDF
                    $contract->update([
                        'file_path' => $pdfPath,
                        'file_type' => 'pdf'
                    ]);
                    
                    // Excluir o arquivo DOCX temporário
                    Storage::delete($docxPath);
                    
                    Log::info("PDF gerado com sucesso: {$pdfPath}, tamanho: " . Storage::size($pdfPath) . " bytes");
                } else {
                    // Apenas atualizar o registro com o caminho do DOCX
                    $contract->update([
                        'file_path' => $docxPath,
                        'file_type' => 'docx'
                    ]);
                    
                    Log::info("DOCX mantido como formato final: {$docxPath}");
                }
            } catch (\Exception $e) {
                Log::error("Erro ao processar template: " . $e->getMessage());
                throw $e;
            }
            
            return $contract;
        } catch (Exception $e) {
            // Em caso de erro, registrar detalhes no log
            Log::error("Erro ao processar template para contrato: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            
            // Excluir o registro do contrato criado
            if ($contract && $contract->exists) {
                $contract->delete();
            }
            throw $e;
        }
    }

    /**
     * Cria o registro do contrato no banco de dados
     *
     * @param ContractTemplate $template
     * @param array $data
     * @param string $format
     * @return Contract
     */
    protected function createContractRecord(ContractTemplate $template, array $data, string $format)
    {
        $userId = 1; // ID padrão para testes via CLI
        
        // Verificar se estamos em ambiente com autenticação
        if (app('auth')->check()) {
            $userId = app('auth')->id();
        }
        
        return Contract::create([
            'template_id' => $template->id,
            'name' => $data['name'] ?? 'Contrato ' . date('d/m/Y'),
            'client_name' => $data['ClientName'],
            'client_address' => $data['ClientAddress'],
            'service_type' => $data['ServiceType'],
            'project_description' => $data['ProjectDescription'],
            'start_date' => $data['StartDate'],
            'delivery_date' => $data['DeliveryDate'],
            'total_value' => $data['TotalValue'],
            'payment_method' => $data['PaymentMethod'],
            'payment_terms' => $data['PaymentTerms'],
            'warranty' => $data['Warranty'],
            'sales_rep_name' => $data['SalesRepName'],
            'form_data' => $data,
            'file_type' => $format,
            'created_by' => $userId,
        ]);
    }

    /**
     * Valida se todos os campos obrigatórios estão presentes
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    protected function validateData(array $data)
    {
        $requiredFields = [
            'ClientName',
            'ClientAddress',
            'ServiceType',
            'ProjectDescription',
            'StartDate',
            'DeliveryDate',
            'TotalValue',
            'PaymentMethod',
            'PaymentTerms',
            'Warranty',
            'SalesRepName'
        ];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new Exception("Campo obrigatório não preenchido: {$field}");
            }
        }

        return true;
    }

    /**
     * Converte o arquivo DOCX para PDF usando Dompdf
     *
     * @param string $docxPath
     * @param string $pdfPath
     * @return bool
     */
    protected function convertToPdf($docxPath, $pdfPath)
    {
        // Ler o conteúdo do DOCX
        $phpWord = IOFactory::load(storage_path("app/{$docxPath}"));
        
        // Converter para HTML (formato intermediário)
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
        $htmlContent = '';
        
        // Capturar o conteúdo HTML com output buffer
        ob_start();
        $htmlWriter->save('php://output');
        $htmlContent = ob_get_clean();
        
        // Configurar o Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlContent);
        $dompdf->setPaper('A4');
        
        // Renderizar o PDF
        $dompdf->render();
        
        // Salvar o arquivo PDF
        Storage::put($pdfPath, $dompdf->output());
        
        return true;
    }
} 