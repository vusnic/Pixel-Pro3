<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('debug:paths', function () {
    $this->info('Base Path: ' . base_path());
    $this->info('Storage Path: ' . storage_path());
    $this->info('Storage App Path: ' . storage_path('app'));
    $this->info('Contracts Path: ' . storage_path('app/contracts'));
    $this->info('Templates Path: ' . storage_path('app/contracts/templates'));
    $this->info('Generated Contracts Path: ' . storage_path('app/contracts/generated'));
    
    $this->info('Temporary Directory: ' . sys_get_temp_dir());
    
    $contractsFolder = storage_path('app/contracts');
    if (file_exists($contractsFolder)) {
        $this->info('Contracts folder exists');
    } else {
        $this->error('Contracts folder does not exist');
    }
    
    $generatedFolder = storage_path('app/contracts/generated');
    if (file_exists($generatedFolder)) {
        $this->info('Generated folder exists');
    } else {
        $this->error('Generated folder does not exist');
    }
})->purpose('Display storage paths for debugging');

Artisan::command('contracts:fix-permissions', function () {
    $this->info('Fixing permissions for contract directories...');
    
    $paths = [
        storage_path('app/contracts'),
        storage_path('app/contracts/templates'),
        storage_path('app/contracts/generated'),
    ];
    
    foreach ($paths as $path) {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
            $this->info("Created directory: {$path}");
        }
        
        chmod($path, 0777);
        $this->info("Set permissions for: {$path}");
        
        // Verificar se o diretório é acessível
        if (is_readable($path) && is_writable($path)) {
            $this->info("Directory {$path} is readable and writable.");
        } else {
            $this->error("Directory {$path} is NOT readable and writable!");
        }
    }
    
    // Verificar arquivos de template
    $templatesDir = storage_path('app/contracts/templates');
    $files = scandir($templatesDir);
    
    $this->info('Files in templates directory:');
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $filePath = $templatesDir . '/' . $file;
        $size = filesize($filePath);
        $readable = is_readable($filePath) ? 'Yes' : 'No';
        $writable = is_writable($filePath) ? 'Yes' : 'No';
        
        chmod($filePath, 0666); // Garante que todos possam ler/escrever
        
        $this->line("{$file} - Size: {$size}bytes, Readable: {$readable}, Writable: {$writable}");
    }
    
    $this->info('Done!');
})->purpose('Fix permissions for contract directories and files');

Artisan::command('contracts:test-generation', function () {
    $this->info('Testing contract generation...');
    
    try {
        // Buscar um template existente
        $template = \App\Models\ContractTemplate::where('is_active', true)->first();
        
        if (!$template) {
            $this->error('No active template found.');
            return;
        }
        
        $this->info("Using template: {$template->name} (ID: {$template->id})");
        
        // Verificar se o arquivo de template existe no sistema de arquivos
        $filePath = storage_path('app/' . $template->file_path);
        $dockerPath = '/var/www/storage/app/' . $template->file_path;
        
        if (file_exists($filePath) && filesize($filePath) > 0) {
            $this->info("Template file exists locally: {$filePath}, size: " . filesize($filePath) . " bytes");
        } elseif (file_exists($dockerPath) && filesize($dockerPath) > 0) {
            $this->info("Template file exists in Docker: {$dockerPath}, size: " . filesize($dockerPath) . " bytes");
            
            // Copiar o arquivo para o local esperado pelo Storage
            $dirName = dirname($filePath);
            if (!file_exists($dirName)) {
                mkdir($dirName, 0777, true);
            }
            
            if (copy($dockerPath, $filePath)) {
                $this->info("Copied file from Docker to local path");
            } else {
                $this->error("Failed to copy file from Docker to local path");
            }
        } else {
            $this->error("Template file not found in any location: {$template->file_path}");
            return;
        }
        
        // Verificar se o arquivo existe via Storage (Laravel)
        if (!\Illuminate\Support\Facades\Storage::exists($template->file_path)) {
            $this->error("Template file not found in Laravel Storage: {$template->file_path}");
            
            // Tentar corrigir (forçar reconhecimento do Storage)
            $content = file_get_contents($filePath);
            \Illuminate\Support\Facades\Storage::put($template->file_path, $content);
            
            if (\Illuminate\Support\Facades\Storage::exists($template->file_path)) {
                $this->info("Fixed Storage recognition for file: {$template->file_path}");
            } else {
                $this->error("Could not fix Storage recognition for file: {$template->file_path}");
                return;
            }
        }
        
        $this->info("Template file exists in Laravel Storage: {$template->file_path}");
        $this->info("Template file size: " . \Illuminate\Support\Facades\Storage::size($template->file_path) . " bytes");
        
        // Preparar dados de teste para o contrato
        $data = [
            'name' => 'Contrato de Teste ' . date('Y-m-d H:i:s'),
            'ClientName' => 'Cliente de Teste',
            'ClientAddress' => 'Endereço de Teste, 123',
            'ServiceType' => 'Serviço de Teste',
            'ProjectDescription' => 'Descrição de projeto para teste de geração de contrato',
            'StartDate' => date('Y-m-d'),
            'DeliveryDate' => date('Y-m-d', strtotime('+30 days')),
            'TotalValue' => '5000.00',
            'PaymentMethod' => 'Transferência Bancária',
            'PaymentTerms' => 'Pagamento em 2 parcelas',
            'Warranty' => '90 dias',
            'SalesRepName' => 'Vendedor de Teste',
        ];
        
        // Gerar o contrato
        $contractGenerator = app(\App\Services\ContractGeneratorService::class);
        $contract = $contractGenerator->generateContract($template, $data, 'docx');
        
        $this->info("Contract generated successfully!");
        $this->info("Contract ID: {$contract->id}");
        $this->info("Contract file path: {$contract->file_path}");
        
        // Verificar se o arquivo foi gerado
        if (\Illuminate\Support\Facades\Storage::exists($contract->file_path)) {
            $this->info("Contract file exists: {$contract->file_path}");
            $this->info("Contract file size: " . \Illuminate\Support\Facades\Storage::size($contract->file_path) . " bytes");
        } else {
            $this->error("Contract file was not created: {$contract->file_path}");
        }
        
    } catch (\Exception $e) {
        $this->error("Error: " . $e->getMessage());
        $this->line("Stack trace: " . $e->getTraceAsString());
    }
})->purpose('Test contract generation directly through Artisan');
