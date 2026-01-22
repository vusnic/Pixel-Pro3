<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContractTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ContractTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = ContractTemplate::orderBy('created_at', 'desc')->get();
        return view('admin.contract_templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contract_templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template_file' => 'required|file|mimes:docx',
            'placeholders' => 'nullable|string',
        ]);

        // Processar placeholders
        $placeholders = [];
        if ($request->placeholders) {
            $placeholdersArray = explode(',', $request->placeholders);
            foreach ($placeholdersArray as $placeholder) {
                $placeholder = trim($placeholder);
                if (!empty($placeholder)) {
                    $placeholders[] = $placeholder;
                }
            }
        }

        try {
            // Adicionar placeholders padrão se não foram especificados
            if (empty($placeholders)) {
                $placeholders = [
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
            }
            
            // Verificar o arquivo
            $file = $request->file('template_file');
            
            if (!$file->isValid()) {
                Log::error('Template upload failed: invalid file');
                return redirect()->back()->withInput()->with('error', 'File upload failed. Please try again.');
            }
            
            // Verificar o tamanho do arquivo (não deve ser vazio)
            if ($file->getSize() <= 0) {
                Log::error('Template upload failed: empty file');
                return redirect()->back()->withInput()->with('error', 'The uploaded file is empty. Please try again with a valid file.');
            }
            
            // Verificar e criar diretórios necessários
            $localTemplateDir = storage_path('app/contracts/templates');
            $dockerTemplateDir = '/var/www/storage/app/contracts/templates';
            
            if (!file_exists($localTemplateDir)) {
                try {
                    mkdir($localTemplateDir, 0777, true);
                    Log::info("Directory created: {$localTemplateDir}");
                } catch (\Exception $e) {
                    Log::warning("Could not create directory: {$localTemplateDir}. Error: " . $e->getMessage());
                }
            }
            
            try {
                if (!file_exists($dockerTemplateDir)) {
                    mkdir($dockerTemplateDir, 0777, true);
                    Log::info("Docker directory created: {$dockerTemplateDir}");
                }
            } catch (\Exception $e) {
                Log::warning("Could not create Docker directory: {$dockerTemplateDir}. Error: " . $e->getMessage());
            }
            
            // Definir permissões para os diretórios
            try {
                chmod($localTemplateDir, 0777);
                Log::info("Permissions set for: {$localTemplateDir}");
                
                if (file_exists($dockerTemplateDir)) {
                    chmod($dockerTemplateDir, 0777);
                    Log::info("Permissions set for: {$dockerTemplateDir}");
                }
            } catch (\Exception $e) {
                Log::warning("Error setting directory permissions: " . $e->getMessage());
            }
            
            // Usar uma abordagem mais segura para salvar o arquivo
            try {
                // Gerar nome do arquivo
                $filename = Str::slug($request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $fullPath = "{$localTemplateDir}/{$filename}";
                $dockerPath = "{$dockerTemplateDir}/{$filename}";
                $storagePath = "contracts/templates/{$filename}";
                
                // Método 1: Salvar com Storage
                $path = $file->storeAs('contracts/templates', $filename);
                
                // Método 2: Salvar diretamente no sistema de arquivos local
                $fileContent = file_get_contents($file->getRealPath());
                file_put_contents($fullPath, $fileContent);
                
                // Método 3: Tentar salvar no Docker também
                try {
                    file_put_contents($dockerPath, $fileContent);
                    Log::info("File saved to Docker path: {$dockerPath}");
                } catch (\Exception $e) {
                    Log::warning("Could not save to Docker: {$dockerPath}. Error: " . $e->getMessage());
                }
                
                // Verificar se o arquivo foi salvo com sucesso
                $fileExists = false;
                
                if (Storage::exists($path)) {
                    $fileExists = true;
                    Log::info("File exists in Storage: {$path}, size: " . Storage::size($path));
                }
                
                if (file_exists($fullPath)) {
                    $fileExists = true;
                    chmod($fullPath, 0777);
                    Log::info("File exists locally: {$fullPath}, size: " . filesize($fullPath));
                }
                
                if (file_exists($dockerPath)) {
                    $fileExists = true;
                    chmod($dockerPath, 0777);
                    Log::info("File exists in Docker: {$dockerPath}, size: " . filesize($dockerPath));
                }
                
                if (!$fileExists) {
                    Log::error("Failed to store file: {$filename} - Not present in any verified location");
                    return redirect()->back()->withInput()->with('error', 'Failed to store file. Check directory permissions.');
                }
                
                Log::info("Template saved successfully: {$path}, size: " . (Storage::exists($path) ? Storage::size($path) : 'unknown'));
                
                // Criar o registro no banco de dados
                $userId = Auth::check() ? Auth::id() : null;
                
                $template = ContractTemplate::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'file_path' => $path,
                    'placeholders' => $placeholders,
                    'is_active' => true,
                    'created_by' => $userId,
                ]);
                
                return redirect()->route('admin.contract-templates.index')
                    ->with('success', 'Contract template created successfully.');
                    
            } catch (\Exception $e) {
                Log::error("Error saving file: " . $e->getMessage() . "\n" . $e->getTraceAsString());
                return redirect()->back()->withInput()->with('error', 'Error saving file: ' . $e->getMessage());
            }
                
        } catch (\Exception $e) {
            Log::error('Error creating contract template: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', 'Error creating contract template: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractTemplate $contractTemplate)
    {
        return view('admin.contract_templates.show', compact('contractTemplate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContractTemplate $contractTemplate)
    {
        return view('admin.contract_templates.edit', compact('contractTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContractTemplate $contractTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template_file' => 'nullable|file|mimes:docx',
            'placeholders' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Processar placeholders
        $placeholders = [];
        if ($request->placeholders) {
            $placeholdersArray = explode(',', $request->placeholders);
            foreach ($placeholdersArray as $placeholder) {
                $placeholder = trim($placeholder);
                if (!empty($placeholder)) {
                    $placeholders[] = $placeholder;
                }
            }
        }

        // Dados para atualização
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'placeholders' => $placeholders,
            'is_active' => $request->has('is_active'),
        ];

        // Armazenar o novo arquivo se fornecido
        if ($request->hasFile('template_file')) {
            // Remover o arquivo antigo
            if (Storage::exists($contractTemplate->file_path)) {
                Storage::delete($contractTemplate->file_path);
            }
            
            // Verificar e criar diretórios necessários
            $localTemplateDir = storage_path('app/contracts/templates');
            $dockerTemplateDir = '/var/www/storage/app/contracts/templates';
            
            if (!file_exists($localTemplateDir)) {
                try {
                    mkdir($localTemplateDir, 0777, true);
                    Log::info("Directory created: {$localTemplateDir}");
                } catch (\Exception $e) {
                    Log::warning("Could not create directory: {$localTemplateDir}. Error: " . $e->getMessage());
                }
            }
            
            try {
                if (!file_exists($dockerTemplateDir)) {
                    mkdir($dockerTemplateDir, 0777, true);
                    Log::info("Docker directory created: {$dockerTemplateDir}");
                }
            } catch (\Exception $e) {
                Log::warning("Could not create Docker directory: {$dockerTemplateDir}. Error: " . $e->getMessage());
            }
            
            // Definir permissões para os diretórios
            try {
                chmod($localTemplateDir, 0777);
                if (file_exists($dockerTemplateDir)) {
                    chmod($dockerTemplateDir, 0777);
                }
            } catch (\Exception $e) {
                Log::warning("Error setting directory permissions: " . $e->getMessage());
            }
            
            // Armazenar o novo arquivo
            $file = $request->file('template_file');
            $filename = Str::slug($request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $fullPath = "{$localTemplateDir}/{$filename}";
            $dockerPath = "{$dockerTemplateDir}/{$filename}";
            $storagePath = "contracts/templates/{$filename}";
            
            try {
                // Método 1: Salvar com Storage
                $path = $file->storeAs('contracts/templates', $filename);
                
                // Método 2: Salvar diretamente no sistema de arquivos local
                $fileContent = file_get_contents($file->getRealPath());
                file_put_contents($fullPath, $fileContent);
                
                // Método 3: Tentar salvar no Docker também
                try {
                    file_put_contents($dockerPath, $fileContent);
                    Log::info("Updated file saved to Docker path: {$dockerPath}");
                } catch (\Exception $e) {
                    Log::warning("Could not save to Docker: {$dockerPath}. Error: " . $e->getMessage());
                }
                
                // Verificar se o arquivo foi salvo com sucesso
                $fileExists = false;
                
                if (Storage::exists($path)) {
                    $fileExists = true;
                    Log::info("Updated file exists in Storage: {$path}, size: " . Storage::size($path));
                }
                
                if (file_exists($fullPath)) {
                    $fileExists = true;
                    chmod($fullPath, 0777);
                    Log::info("Updated file exists locally: {$fullPath}, size: " . filesize($fullPath));
                }
                
                if (file_exists($dockerPath)) {
                    $fileExists = true;
                    chmod($dockerPath, 0777);
                    Log::info("Updated file exists in Docker: {$dockerPath}, size: " . filesize($dockerPath));
                }
                
                if (!$fileExists) {
                    Log::error("Failed to store updated file: {$filename} - Not present in any verified location");
                    return redirect()->back()->withInput()->with('error', 'Failed to store file. Check directory permissions.');
                }
                
                $data['file_path'] = $path;
                Log::info("Template updated successfully: {$path}, size: " . (Storage::exists($path) ? Storage::size($path) : 'unknown'));
            } catch (\Exception $e) {
                Log::error("Error saving update file: " . $e->getMessage() . "\n" . $e->getTraceAsString());
                return redirect()->back()->withInput()->with('error', 'Error saving file: ' . $e->getMessage());
            }
        }

        // Atualizar o registro
        $contractTemplate->update($data);

        return redirect()->route('admin.contract-templates.index')
            ->with('success', 'Contract template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractTemplate $contractTemplate)
    {
        // Verificar se existem contratos usando este modelo
        if ($contractTemplate->contracts()->count() > 0) {
            return redirect()->route('admin.contract-templates.index')
                ->with('error', 'This template cannot be deleted because there are contracts associated with it.');
        }

        // Remover o arquivo
        if (Storage::exists($contractTemplate->file_path)) {
            Storage::delete($contractTemplate->file_path);
        }

        // Excluir o registro
        $contractTemplate->delete();

        return redirect()->route('admin.contract-templates.index')
            ->with('success', 'Contract template deleted successfully.');
    }

    /**
     * Download do arquivo modelo
     */
    public function download(ContractTemplate $contractTemplate)
    {
        // Verificar e registrar informações sobre o template
        Log::info("Download attempt for template #{$contractTemplate->id}, path: {$contractTemplate->file_path}");
        
        // Verificar caminhos absolutos
        $localPath = storage_path('app/' . $contractTemplate->file_path);
        $dockerPath = '/var/www/storage/app/' . $contractTemplate->file_path;
        
        $storageExists = Storage::exists($contractTemplate->file_path) && Storage::size($contractTemplate->file_path) > 0;
        $localExists = file_exists($localPath) && filesize($localPath) > 0;
        $dockerExists = file_exists($dockerPath) && filesize($dockerPath) > 0;
        
        Log::info("File verification (download): Storage: " . ($storageExists ? "YES" : "NO") . 
                 ", Local: " . ($localExists ? "YES" : "NO") . 
                 ", Docker: " . ($dockerExists ? "YES" : "NO"));
                 
        // Se não existe no Storage mas existe localmente ou no Docker
        if (!$storageExists && ($localExists || $dockerExists)) {
            try {
                $sourcePath = $localExists ? $localPath : $dockerPath;
                $content = file_get_contents($sourcePath);
                Storage::put($contractTemplate->file_path, $content);
                $storageExists = true;
                
                Log::info("File synchronized with Storage for download: {$contractTemplate->file_path}");
            } catch (\Exception $e) {
                Log::error("Failed to synchronize file for download: " . $e->getMessage());
            }
        }

        if ($storageExists) {
            Log::info("Download via Storage::download: {$contractTemplate->file_path}");
            return Storage::download($contractTemplate->file_path);
        } elseif ($localExists) {
            Log::info("Direct download from local file: {$localPath}");
            return response()->download($localPath);
        } elseif ($dockerExists) {
            Log::info("Direct download from Docker file: {$dockerPath}");
            return response()->download($dockerPath);
        } else {
            Log::error("File not found in any location: {$contractTemplate->file_path}");
            return redirect()->route('admin.contract-templates.index')
                ->with('error', 'File not found.');
        }
    }

    /**
     * Verifica e repara templates com arquivos ausentes
     */
    public function verifyAndRepairTemplates()
    {
        $templates = ContractTemplate::all();
        $fixedCount = 0;
        $errorCount = 0;
        
        foreach ($templates as $template) {
            if (!Storage::exists($template->file_path) || Storage::size($template->file_path) <= 0) {
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
                    } else {
                        $errorCount++;
                    }
                } else {
                    $errorCount++;
                }
            }
        }
        
        if ($fixedCount > 0) {
            return redirect()->route('admin.contract-templates.index')
                ->with('success', "{$fixedCount} contract templates have been repaired.");
        } elseif ($errorCount > 0) {
            return redirect()->route('admin.contract-templates.index')
                ->with('error', "Could not repair {$errorCount} contract templates.");
        } else {
            return redirect()->route('admin.contract-templates.index')
                ->with('info', "All contract templates are valid.");
        }
    }
}
