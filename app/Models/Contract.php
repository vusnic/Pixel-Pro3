<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'name',
        'client_name',
        'client_address',
        'service_type',
        'project_description',
        'start_date',
        'delivery_date',
        'total_value',
        'payment_method',
        'payment_terms',
        'warranty',
        'sales_rep_name',
        'form_data',
        'file_path',
        'file_type',
        'created_by',
    ];

    protected $casts = [
        'form_data' => 'array',
        'start_date' => 'date',
        'delivery_date' => 'date',
        'total_value' => 'decimal:2',
    ];

    public function template()
    {
        return $this->belongsTo(ContractTemplate::class, 'template_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStoragePath()
    {
        return 'contracts/generated/' . basename($this->file_path);
    }

    public function getFullPath()
    {
        return storage_path('app/' . $this->file_path);
    }

    public function getFileExtension()
    {
        return $this->file_type === 'pdf' ? 'pdf' : 'docx';
    }
    
    /**
     * Tenta encontrar o arquivo do contrato mesmo se o caminho estiver incorreto
     * 
     * @return string|null Caminho para o arquivo, ou null se não encontrado
     */
    public function findFile()
    {
        // Verificar o caminho original no storage
        $storageExists = Storage::exists($this->file_path) && Storage::size($this->file_path) > 0;
        
        // Verificar caminho original nos sistemas de arquivos diretos
        $fullPath = storage_path('app/' . $this->file_path);
        $dockerPath = '/var/www/storage/app/' . $this->file_path;
        
        $localExists = file_exists($fullPath) && filesize($fullPath) > 0;
        $dockerExists = file_exists($dockerPath) && filesize($dockerPath) > 0;
        
        Log::info("Contrato #{$this->id}: Verificação de arquivo: Storage: " . ($storageExists ? "SIM" : "NÃO") . 
                 ", Local: " . ($localExists ? "SIM" : "NÃO") . 
                 ", Docker: " . ($dockerExists ? "SIM" : "NÃO"));
        
        // Se existe no storage, verificar se não é sample.docx
        if ($storageExists) {
            if (basename($this->file_path) === 'sample.docx') {
                Log::error("Contrato #{$this->id}: Caminho aponta para arquivo sample.docx");
            } else {
                Log::info("Contrato #{$this->id}: Usando arquivo original do Storage: {$this->file_path}");
                return $this->file_path;
            }
        }
        
        // Se existe fisicamente mas não no storage, sincronizar
        if (($localExists || $dockerExists) && !$storageExists) {
            $sourcePath = $localExists ? $fullPath : $dockerPath;
            
            if (basename($sourcePath) === 'sample.docx') {
                Log::error("Contrato #{$this->id}: Caminho físico aponta para arquivo sample.docx");
            } else {
                try {
                    $content = file_get_contents($sourcePath);
                    Storage::put($this->file_path, $content);
                    Log::info("Contrato #{$this->id}: Arquivo sincronizado com o Storage a partir de: {$sourcePath}");
                    return $this->file_path;
                } catch (\Exception $e) {
                    Log::warning("Contrato #{$this->id}: Não foi possível sincronizar com o Storage: " . $e->getMessage());
                }
            }
        }
        
        Log::warning("Contrato #{$this->id}: Arquivo não encontrado no caminho original: {$this->file_path}");
        
        // Tentar encontrar no diretório de contratos gerados com o ID do contrato
        $baseDir = 'contracts/generated';
        $basePattern = "contract_{$this->id}_";
        
        // Listar todos os arquivos no diretório
        if (Storage::exists($baseDir)) {
            $files = Storage::files($baseDir);
            
            foreach ($files as $file) {
                // Verificar se não é o arquivo sample.docx
                if (basename($file) === 'sample.docx') {
                    continue;
                }
                
                if (strpos(basename($file), $basePattern) !== false) {
                    if (Storage::size($file) > 0) {
                        Log::info("Contrato #{$this->id}: Arquivo encontrado pelo ID: {$file}");
                        
                        // Atualizar o registro com o caminho correto
                        $this->update(['file_path' => $file]);
                        
                        return $file;
                    }
                }
            }
            
            // Se não encontrou pelo ID, tenta pelo nome
            $nameSlug = \Illuminate\Support\Str::slug($this->name);
            
            foreach ($files as $file) {
                // Verificar se não é o arquivo sample.docx
                if (basename($file) === 'sample.docx') {
                    continue;
                }
                
                if (strpos(basename($file), $nameSlug) !== false && Storage::size($file) > 0) {
                    Log::info("Contrato #{$this->id}: Arquivo encontrado pelo nome: {$file}");
                    
                    // Atualizar o registro com o caminho correto
                    $this->update(['file_path' => $file]);
                    
                    return $file;
                }
            }
        }
        
        // Verificar também os arquivos físicos no diretório (caso o Storage não os liste)
        $physicalDir = storage_path('app/' . $baseDir);
        $dockerPhysicalDir = '/var/www/storage/app/' . $baseDir;
        
        if (file_exists($physicalDir) || file_exists($dockerPhysicalDir)) {
            $dirToCheck = file_exists($physicalDir) ? $physicalDir : $dockerPhysicalDir;
            $filesInDir = scandir($dirToCheck);
            
            foreach ($filesInDir as $filename) {
                if ($filename === '.' || $filename === '..') continue;
                
                // Verificar se não é o arquivo sample.docx
                if ($filename === 'sample.docx') {
                    continue;
                }
                
                // Verificar pelo ID do contrato
                if (strpos($filename, $basePattern) !== false) {
                    $fullFilePath = $dirToCheck . '/' . $filename;
                    
                    if (filesize($fullFilePath) > 0) {
                        $storagePath = $baseDir . '/' . $filename;
                        Log::info("Contrato #{$this->id}: Arquivo encontrado pelo ID no sistema de arquivos: {$fullFilePath}");
                        
                        // Sincronizar com o Storage
                        try {
                            $content = file_get_contents($fullFilePath);
                            Storage::put($storagePath, $content);
                            Log::info("Contrato #{$this->id}: Arquivo sincronizado com o Storage: {$storagePath}");
                            
                            // Atualizar o registro com o caminho correto
                            $this->update(['file_path' => $storagePath]);
                            
                            return $storagePath;
                        } catch (\Exception $e) {
                            Log::warning("Contrato #{$this->id}: Não foi possível sincronizar o arquivo com o Storage: " . $e->getMessage());
                        }
                    }
                }
                
                // Verificar pelo nome do contrato
                if (strpos($filename, $nameSlug) !== false) {
                    $fullFilePath = $dirToCheck . '/' . $filename;
                    
                    if (filesize($fullFilePath) > 0) {
                        $storagePath = $baseDir . '/' . $filename;
                        Log::info("Contrato #{$this->id}: Arquivo encontrado pelo nome no sistema de arquivos: {$fullFilePath}");
                        
                        // Sincronizar com o Storage
                        try {
                            $content = file_get_contents($fullFilePath);
                            Storage::put($storagePath, $content);
                            Log::info("Contrato #{$this->id}: Arquivo sincronizado com o Storage: {$storagePath}");
                            
                            // Atualizar o registro com o caminho correto
                            $this->update(['file_path' => $storagePath]);
                            
                            return $storagePath;
                        } catch (\Exception $e) {
                            Log::warning("Contrato #{$this->id}: Não foi possível sincronizar o arquivo com o Storage: " . $e->getMessage());
                        }
                    }
                }
            }
        }
        
        // Se ainda não encontrou, verificar o caminho do template original
        // para garantir que não estamos substituindo pelo template de amostra
        if ($this->template && Storage::exists($this->template->file_path) && Storage::size($this->template->file_path) > 0) {
            // Verificar se o template não é o arquivo sample.docx
            if (basename($this->template->file_path) === 'sample.docx') {
                Log::error("Contrato #{$this->id}: Template original é arquivo sample.docx");
            } else {
                Log::warning("Contrato #{$this->id}: Não foi possível encontrar o arquivo gerado. Template original disponível em: {$this->template->file_path}");
            }
        }
        
        Log::error("Contrato #{$this->id}: Arquivo não encontrado em nenhum local");
        return null;
    }
}
