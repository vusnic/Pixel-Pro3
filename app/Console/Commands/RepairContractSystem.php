<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\ContractTemplate;
use App\Models\Contract;

class RepairContractSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contracts:repair-system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repara o sistema de contratos, corrigindo diretórios, permissões e caminhos de arquivos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando reparo do sistema de contratos...');
        
        // 1. Verificar e criar diretórios necessários
        $this->checkAndCreateDirectories();
        
        // 2. Verificar templates e reparar caminhos
        $this->repairTemplates();
        
        // 3. Verificar contratos gerados
        $this->repairContracts();
        
        $this->info('Reparo do sistema de contratos concluído!');
        
        return Command::SUCCESS;
    }
    
    private function checkAndCreateDirectories()
    {
        $this->info('Verificando e criando diretórios necessários...');
        
        $directories = [
            'app/contracts',
            'app/contracts/templates',
            'app/contracts/generated',
        ];
        
        foreach ($directories as $dir) {
            if (!Storage::exists($dir)) {
                Storage::makeDirectory($dir);
                $this->info("Diretório criado: {$dir}");
            } else {
                $this->info("Diretório já existe: {$dir}");
            }
            
            // Verificar permissões no sistema de arquivos
            $fullPath = storage_path($dir);
            $dockerPath = str_replace(base_path(), '/var/www', $fullPath);
            
            // Verificar e corrigir permissões nos dois ambientes
            if (file_exists($fullPath)) {
                chmod($fullPath, 0777);
                $this->info("Permissões aplicadas para: {$fullPath}");
            }
            
            if (file_exists($dockerPath) && $dockerPath !== $fullPath) {
                chmod($dockerPath, 0777);
                $this->info("Permissões aplicadas para caminho Docker: {$dockerPath}");
            }
        }
        
        $this->info('Diretórios verificados e criados com sucesso!');
    }
    
    private function repairTemplates()
    {
        $this->info('Verificando e reparando templates...');
        
        $templates = ContractTemplate::all();
        $this->info("Encontrados {$templates->count()} templates");
        
        // Verificar os arquivos de template em ambos os caminhos (local e Docker)
        $templateFiles = [];
        $dockerTemplateFiles = [];
        
        // Verificar no Storage
        $storageTemplates = Storage::files('app/contracts/templates');
        foreach ($storageTemplates as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'docx' && Storage::size($file) > 0) {
                $templateFiles[] = $file;
                $this->info("Template válido encontrado no Storage: {$file}");
            }
        }
        
        // Verificar no Docker
        $dockerPath = '/var/www/storage/app/contracts/templates';
        if (file_exists($dockerPath)) {
            $files = scandir($dockerPath);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                
                $fullPath = $dockerPath . '/' . $file;
                if (pathinfo($file, PATHINFO_EXTENSION) === 'docx' && filesize($fullPath) > 0) {
                    $dockerFile = 'app/contracts/templates/' . $file;
                    $dockerTemplateFiles[] = $dockerFile;
                    $this->info("Template válido encontrado no Docker: {$fullPath}");
                    
                    // Copiar para o Storage se não existir lá
                    if (!Storage::exists($dockerFile) || Storage::size($dockerFile) <= 0) {
                        $content = file_get_contents($fullPath);
                        Storage::put($dockerFile, $content);
                        $this->info("Arquivo copiado do Docker para o Storage: {$dockerFile}");
                        $templateFiles[] = $dockerFile;
                    }
                }
            }
        }
        
        $validTemplates = array_unique(array_merge($templateFiles, $dockerTemplateFiles));
        
        if (empty($validTemplates)) {
            $this->error("Nenhum template válido encontrado!");
            return;
        }
        
        $repairCount = 0;
        
        foreach ($templates as $template) {
            $storageExists = Storage::exists($template->file_path) && Storage::size($template->file_path) > 0;
            $localPath = storage_path('app/' . $template->file_path);
            $dockerPath = '/var/www/storage/app/' . $template->file_path;
            
            $localExists = file_exists($localPath) && filesize($localPath) > 0;
            $dockerExists = file_exists($dockerPath) && filesize($dockerPath) > 0;
            
            if (!$storageExists && !$localExists && !$dockerExists) {
                // Template inválido, tentar reparar
                $template->update(['file_path' => $validTemplates[0]]);
                $this->info("Template #{$template->id} reparado. Novo caminho: {$validTemplates[0]}");
                $repairCount++;
            } else {
                // Verificar se precisa corrigir o caminho no banco de dados
                if (!$storageExists && $dockerExists) {
                    // Se existe apenas no Docker, copiar para o Storage
                    $content = file_get_contents($dockerPath);
                    Storage::put($template->file_path, $content);
                    $this->info("Arquivo copiado do Docker para o Storage para o template #{$template->id}");
                }
                
                $this->info("Template #{$template->id} está válido: {$template->file_path}");
            }
        }
        
        $this->info("Total de templates reparados: {$repairCount}");
    }
    
    private function repairContracts()
    {
        $this->info('Verificando e reparando contratos...');
        
        $contracts = Contract::all();
        $this->info("Encontrados {$contracts->count()} contratos");
        
        $repairCount = 0;
        
        foreach ($contracts as $contract) {
            if (empty($contract->file_path) || !Storage::exists($contract->file_path) || Storage::size($contract->file_path) <= 0) {
                // Verificar se existe algum arquivo para este contrato
                $basePattern = "contract_{$contract->id}_";
                $foundFile = false;
                
                foreach (Storage::files('app/contracts/generated') as $file) {
                    $filename = basename($file);
                    if (strpos($filename, $basePattern) !== false) {
                        $contract->update(['file_path' => $file]);
                        $this->info("Contrato #{$contract->id} reparado. Novo caminho: {$file}");
                        $foundFile = true;
                        $repairCount++;
                        break;
                    }
                }
                
                if (!$foundFile) {
                    $this->warn("Contrato #{$contract->id} não tem arquivo válido e não foi possível reparar automaticamente");
                }
            } else {
                $this->info("Contrato #{$contract->id} está válido: {$contract->file_path}");
            }
        }
        
        $this->info("Total de contratos reparados: {$repairCount}");
    }
} 