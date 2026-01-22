<?php

namespace App\Console\Commands;

use App\Models\ContractTemplate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VerifyContractTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contracts:verify-templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica e repara modelos de contrato com arquivos ausentes ou vazios';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando modelos de contrato...');
        
        $templates = ContractTemplate::all();
        $fixedCount = 0;
        $errorCount = 0;
        
        foreach ($templates as $template) {
            $this->line("Verificando template: {$template->name}");
            
            if (!Storage::exists($template->file_path) || Storage::size($template->file_path) <= 0) {
                $this->warn("Arquivo ausente ou vazio: {$template->file_path}");
                
                // Se o arquivo não existe ou está vazio, tenta usar o modelo de exemplo
                $examplePath = 'contracts/templates/contrato-cliente_1746157845.docx';
                
                if (Storage::exists($examplePath) && Storage::size($examplePath) > 0) {
                    // Cria um novo arquivo para este template baseado no exemplo
                    $newFileName = 'contrato-' . Str::slug($template->name) . '_' . time() . '.docx';
                    $newPath = 'contracts/templates/' . $newFileName;
                    
                    // Copia o arquivo de exemplo
                    if (Storage::copy($examplePath, $newPath)) {
                        // Atualiza o registro do template
                        $template->update(['file_path' => $newPath]);
                        $fixedCount++;
                        $this->info("  ✓ Template reparado: {$newPath}");
                    } else {
                        $errorCount++;
                        $this->error("  ✗ Erro ao copiar o arquivo para: {$newPath}");
                    }
                } else {
                    $errorCount++;
                    $this->error("  ✗ Arquivo de exemplo não encontrado: {$examplePath}");
                }
            } else {
                $this->info("  ✓ Arquivo OK: {$template->file_path}");
            }
        }
        
        if ($fixedCount > 0) {
            $this->info("\n{$fixedCount} modelos de contrato foram reparados.");
        }
        
        if ($errorCount > 0) {
            $this->warn("\nNão foi possível reparar {$errorCount} modelos de contrato.");
        }
        
        if ($fixedCount == 0 && $errorCount == 0) {
            $this->info("\nTodos os modelos de contrato estão corretos.");
        }
        
        return 0;
    }
} 