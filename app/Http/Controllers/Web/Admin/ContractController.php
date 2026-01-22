<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\ContractTemplate;
use App\Services\ContractGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Str;

class ContractController extends Controller
{
    protected $contractGenerator;

    public function __construct(ContractGeneratorService $contractGenerator)
    {
        $this->contractGenerator = $contractGenerator;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::with('template')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $templates = ContractTemplate::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        if ($templates->isEmpty()) {
            return redirect()->route('admin.contract-templates.create')
                ->with('warning', 'You need to create a contract template before generating a contract.');
        }
        
        return view('admin.contracts.create', compact('templates'));
    }

    /**
     * Show form for filling contract data based on selected template.
     */
    public function createFromTemplate(Request $request)
    {
        // Verificar se está chegando via POST ou GET
        $templateId = null;
        
        if ($request->isMethod('post')) {
            $templateId = $request->input('template_id');
        } else if ($request->isMethod('get')) {
            $templateId = $request->query('template_id');
        }
        
        if (empty($templateId)) {
            return redirect()->route('admin.contracts.create')
                ->with('error', 'You must select a contract template.');
        }
        
        try {
            $template = ContractTemplate::findOrFail($templateId);
            
            // Verificar e sincronizar o arquivo de template
            $localPath = storage_path('app/' . $template->file_path);
            $dockerPath = '/var/www/storage/app/' . $template->file_path;
            
            $storageExists = Storage::exists($template->file_path) && Storage::size($template->file_path) > 0;
            $localExists = file_exists($localPath) && filesize($localPath) > 0;
            $dockerExists = file_exists($dockerPath) && filesize($dockerPath) > 0;
            
            Log::info("Template verification #{$template->id}: Storage: " . ($storageExists ? "YES" : "NO") . 
                     ", Local: " . ($localExists ? "YES" : "NO") . 
                     ", Docker: " . ($dockerExists ? "YES" : "NO"));
            
            // Se não existe no Storage mas existe no Docker ou localmente
            if (!$storageExists && ($localExists || $dockerExists)) {
                try {
                    // Copiar para o Storage
                    $sourcePath = $localExists ? $localPath : $dockerPath;
                    $content = file_get_contents($sourcePath);
                    Storage::put($template->file_path, $content);
                    
                    // Atualizar status
                    $storageExists = true;
                    Log::info("Template synchronized with Storage: {$template->file_path}");
                } catch (\Exception $e) {
                    Log::error("Failed to synchronize template: " . $e->getMessage());
                }
            }
            
            // Se ainda não existe, tentar encontrar outro arquivo
            if (!$storageExists && !$localExists && !$dockerExists) {
                Log::error("Template file not found: {$template->file_path}");
                
                // Tentar encontrar qualquer modelo válido
                $templateDir = 'contracts/templates';
                $files = Storage::files($templateDir);
                $found = false;
                
                foreach ($files as $file) {
                    if (Storage::size($file) > 0) {
                        // Atualizar o caminho do template
                        $template->update(['file_path' => $file]);
                        Log::info("Template updated to use: {$file}");
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    // Se não encontrou nenhum arquivo, redirecionar para criação
                    return redirect()->route('admin.contract-templates.create')
                        ->with('error', 'Could not find a valid template file. Please upload a new template.');
                }
            }
            
            return view('admin.contracts.create_from_template', compact('template'));
        } catch (Exception $e) {
            // Log do erro
            Log::error('Error fetching contract template: ' . $e->getMessage());
            
            return redirect()->route('admin.contracts.create')
                ->with('error', 'Contract template not found.');
        }
    }

    /**
     * Generate contract from template and form data.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:contract_templates,id',
            'name' => 'required|string|max:255',
            'ClientName' => 'required|string|max:255',
            'ClientAddress' => 'required|string|max:255',
            'ServiceType' => 'required|string|max:255',
            'ProjectDescription' => 'required|string',
            'StartDate' => 'required|date',
            'DeliveryDate' => 'required|date|after:StartDate',
            'TotalValue' => 'required|numeric|min:0',
            'PaymentMethod' => 'required|string|max:255',
            'PaymentTerms' => 'required|string',
            'Warranty' => 'required|string|max:255',
            'SalesRepName' => 'required|string|max:255',
            'format' => 'required|in:docx,pdf',
        ]);

        try {
            $template = ContractTemplate::findOrFail($request->template_id);
            
            // IMPORTANTE: Registrar o template antes de qualquer processamento
            Log::info("Generating contract from template #{$template->id}, file: {$template->file_path}");
            
            // Primeiro verificar se o arquivo existe e está acessível
            $localPath = storage_path('app/' . $template->file_path);
            $dockerPath = '/var/www/storage/app/' . $template->file_path;
            
            $storageExists = Storage::exists($template->file_path) && Storage::size($template->file_path) > 0;
            $localExists = file_exists($localPath) && filesize($localPath) > 0;
            $dockerExists = file_exists($dockerPath) && filesize($dockerPath) > 0;
            
            Log::info("Template verification for generation: Storage: " . ($storageExists ? "YES" : "NO") . 
                     ", Local: " . ($localExists ? "YES" : "NO") . 
                     ", Docker: " . ($dockerExists ? "YES" : "NO"));
            
            // Sincronizar os arquivos para garantir que estejam disponíveis em todos os locais
            if ($storageExists && !$localExists) {
                try {
                    // Copiar do Storage para o local
                    $content = Storage::get($template->file_path);
                    file_put_contents($localPath, $content);
                    chmod($localPath, 0777);
                    Log::info("File copied from Storage to local: {$localPath}");
                } catch (\Exception $e) {
                    Log::warning("Could not copy to local path: " . $e->getMessage());
                }
            }
            
            if ($storageExists && !$dockerExists) {
                try {
                    // Copiar do Storage para o Docker
                    $content = Storage::get($template->file_path);
                    file_put_contents($dockerPath, $content);
                    chmod($dockerPath, 0777);
                    Log::info("File copied from Storage to Docker: {$dockerPath}");
                } catch (\Exception $e) {
                    Log::warning("Could not copy to Docker: " . $e->getMessage());
                }
            }
            
            // Se não existe no Storage mas existe em outro lugar
            if (!$storageExists && ($localExists || $dockerExists)) {
                try {
                    // Escolher o caminho que existe
                    $sourcePath = $localExists ? $localPath : $dockerPath;
                    $content = file_get_contents($sourcePath);
                    
                    // Armazenar no Storage
                    Storage::put($template->file_path, $content);
                    Log::info("File synchronized with Storage: {$template->file_path}");
                    
                    // Agora existe no Storage
                    $storageExists = true;
                } catch (\Exception $e) {
                    Log::error("Failed to synchronize with Storage: " . $e->getMessage());
                }
            }
            
            // Se ainda não existe, tentar buscar qualquer modelo disponível
            if (!$storageExists && !$localExists && !$dockerExists) {
                Log::error("Template file not accessible in any location. Template ID: {$template->id}, path: {$template->file_path}");
                
                $templateDir = 'contracts/templates';
                $found = false;
                
                if (Storage::exists($templateDir)) {
                    $files = Storage::files($templateDir);
                    
                    foreach ($files as $file) {
                        if (pathinfo($file, PATHINFO_EXTENSION) === 'docx' && Storage::size($file) > 0) {
                            Log::info("Found alternative template: {$file}");
                            $template->update(['file_path' => $file]);
                            
                            // Verificar novamente após atualização
                            $localPath = storage_path('app/' . $file);
                            $dockerPath = '/var/www/storage/app/' . $file;
                            
                            // Agora deve existir no Storage
                            $storageExists = Storage::exists($file);
                            $localExists = file_exists($localPath);
                            $dockerExists = file_exists($dockerPath);
                            
                            $found = true;
                            break;
                        }
                    }
                }
                
                if (!$found) {
                    return redirect()->route('admin.contract-templates.edit', $template)
                        ->with('error', "Could not find a valid template file. Please upload a new file for this contract template.");
                }
            }
            
            // Verificar a extensão ZipArchive
            if (!class_exists('ZipArchive')) {
                Log::error('ZipArchive extension not installed in PHP');
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'The ZipArchive extension is not installed in PHP. Contact your system administrator.');
            }
            
            // Gerar o contrato
            $data = $request->except(['_token', 'template_id', 'format']);
            
            $contract = $this->contractGenerator->generateContract(
                $template,
                $data,
                $request->format
            );
            
            // Verificar se o contrato foi gerado corretamente com um arquivo
            if (empty($contract->file_path)) {
                Log::error("Contract #{$contract->id} generated without a defined file path");
                return redirect()->route('admin.contracts.show', $contract)
                    ->with('warning', 'The contract was created, but the file may not have been generated correctly. Check if you can download it.');
            }
            
            // Verificar se o arquivo existe fisicamente, mesmo que o Storage::exists retorne falso
            $fullPath = storage_path('app/' . $contract->file_path);
            $dockerPath = '/var/www/storage/app/' . $contract->file_path;
            
            // Se o arquivo existe fisicamente mas não no Storage, tentar sincronizar
            if (!Storage::exists($contract->file_path) && (file_exists($fullPath) || file_exists($dockerPath))) {
                $sourcePath = file_exists($fullPath) ? $fullPath : $dockerPath;
                $content = file_get_contents($sourcePath);
                Storage::put($contract->file_path, $content);
                Log::info("Contract #{$contract->id}: File synchronized with Storage: {$contract->file_path}");
            }
            
            // Logging detalhado para diagnóstico
            Log::info("Contract #{$contract->id}: File path verification");
            Log::info("Path registered in DB: {$contract->file_path}");
            Log::info("Complete physical path: {$fullPath}");
            Log::info("Complete Docker path: {$dockerPath}");
            Log::info("File exists in Storage: " . (Storage::exists($contract->file_path) ? "YES" : "NO"));
            Log::info("File exists physically: " . (file_exists($fullPath) ? "YES" : "NO"));
            Log::info("File exists in Docker: " . (file_exists($dockerPath) ? "YES" : "NO"));
            
            // Fix: Não mostrar alerta de erro se o arquivo existe fisicamente, mesmo que o Storage não o reconheça
            $fileExists = Storage::exists($contract->file_path) || file_exists($fullPath) || file_exists($dockerPath);
            
            if (!$fileExists) {
                Log::error("Contract #{$contract->id} generated, but the file does not exist in any verified path: {$contract->file_path}");
                return redirect()->route('admin.contracts.show', $contract)
                    ->with('warning', 'The contract was created, but the file may not have been generated correctly. Check if you can download it.');
            }
            
            // Certificar-se de que estamos regenerando a sessão para evitar loops de redirecionamento
            $request->session()->regenerate();
            
            return redirect()->route('admin.contracts.show', $contract)
                ->with('success', 'Contract generated successfully.');
        } catch (Exception $e) {
            // Log do erro para diagnóstico
            Log::error('Error generating contract: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error generating contract: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        return view('admin.contracts.show', compact('contract'));
    }

    /**
     * Download the contract file.
     */
    public function download(Contract $contract)
    {
        // Validar que o contrato tem um caminho de arquivo definido
        if (empty($contract->file_path)) {
            Log::error("Contract #{$contract->id} has no defined file path");
            return redirect()->route('admin.contracts.show', $contract)
                ->with('error', 'This contract does not have an associated file. You may need to generate it again.');
        }
        
        // Registrar a tentativa de download
        Log::info("Download attempt for contract #{$contract->id}, path: {$contract->file_path}");
        
        // Verificar o caminho no storage e caminhos físicos diretos
        $fullPath = storage_path('app/' . $contract->file_path);
        $dockerPath = '/var/www/storage/app/' . $contract->file_path;
        
        // Verificar se o arquivo existe fisicamente em algum lugar
        $storageExists = Storage::exists($contract->file_path) && Storage::size($contract->file_path) > 0;
        $localExists = file_exists($fullPath) && filesize($fullPath) > 0;
        $dockerExists = file_exists($dockerPath) && filesize($dockerPath) > 0;
        
        Log::info("Contract #{$contract->id}: File verification: Storage: " . 
                 ($storageExists ? "YES" : "NO") . 
                 ", Local: " . ($localExists ? "YES" : "NO") .
                 ", Docker: " . ($dockerExists ? "YES" : "NO"));
        
        // 1. Verificar o Storage primeiro
        if ($storageExists) {
            // Verificar se não é o arquivo sample.docx vazio
            if (basename($contract->file_path) === 'sample.docx') {
                Log::error("Contract #{$contract->id}: Attempt to download empty sample.docx file");
                return redirect()->route('admin.contracts.show', $contract)
                    ->with('error', 'The contract file is corrupted. Please regenerate the contract.');
            }
            
            Log::info("Contract #{$contract->id}: File found in storage, downloading");
            $filename = 'contract_' . Str::slug($contract->client_name) . '_' . date('dmY') . '.' . $contract->getFileExtension();
            return Storage::download($contract->file_path, $filename);
        }
        
        // 2. Se não está no Storage mas existe fisicamente, sincronizar e fazer download
        if ($localExists || $dockerExists) {
            $sourcePath = $localExists ? $fullPath : $dockerPath;
            
            // Verificar se não é o arquivo sample.docx vazio
            if (basename($sourcePath) === 'sample.docx') {
                Log::error("Contract #{$contract->id}: Attempt to download empty sample.docx file");
                return redirect()->route('admin.contracts.show', $contract)
                    ->with('error', 'The contract file is corrupted. Please regenerate the contract.');
            }
            
            // Sincronizar com o Storage
            try {
                $content = file_get_contents($sourcePath);
                Storage::put($contract->file_path, $content);
                Log::info("Contract #{$contract->id}: File synchronized with Storage from: {$sourcePath}");
                
                // Fazer download
                $filename = 'contract_' . Str::slug($contract->client_name) . '_' . date('dmY') . '.' . $contract->getFileExtension();
                return Storage::download($contract->file_path, $filename);
            } catch (\Exception $e) {
                // Se falhar ao sincronizar, fazer download direto
                Log::warning("Contract #{$contract->id}: Failed to synchronize with Storage: " . $e->getMessage());
                Log::info("Contract #{$contract->id}: Using direct download from file system: {$sourcePath}");
                
                $filename = 'contract_' . Str::slug($contract->client_name) . '_' . date('dmY') . '.' . $contract->getFileExtension();
                return response()->download($sourcePath, $filename);
            }
        }
        
        // 3. Tentar encontrar o arquivo por outros meios
        Log::warning("Contract #{$contract->id}: File not found directly, looking for alternatives");
        $filePath = $contract->findFile();
        
        if ($filePath) {
            // Verificar se não é o arquivo sample.docx vazio
            if (basename($filePath) === 'sample.docx') {
                Log::error("Contract #{$contract->id}: Attempt to download empty sample.docx file");
                return redirect()->route('admin.contracts.show', $contract)
                    ->with('error', 'The contract file is corrupted. Please regenerate the contract.');
            }
            
            Log::info("Contract #{$contract->id}: Alternative file found: {$filePath}");
            
            // Definir nome do arquivo para download
            $filename = 'contract_' . Str::slug($contract->client_name) . '_' . date('dmY') . '.' . $contract->getFileExtension();
            
            return Storage::download($filePath, $filename);
        }
        
        // Vamos verificar se o template original existe, se sim, podemos sugerir regenerar o contrato
        $templateExists = false;
        $templatePath = '';
        
        if ($contract->template && !empty($contract->template->file_path)) {
            $templatePath = $contract->template->file_path;
            $templateExists = Storage::exists($templatePath) && Storage::size($templatePath) > 0;
            
            // Verificar também caminhos físicos
            if (!$templateExists) {
                $templateFullPath = storage_path('app/' . $templatePath);
                $templateDockerPath = '/var/www/storage/app/' . $templatePath;
                $templateExists = (file_exists($templateFullPath) && filesize($templateFullPath) > 0) || 
                                 (file_exists($templateDockerPath) && filesize($templateDockerPath) > 0);
            }
        }
        
        // Nenhum arquivo encontrado
        Log::error("Contract #{$contract->id}: No file found for download. Template exists: " . 
            ($templateExists ? "Yes ({$templatePath})" : "No"));
            
        if ($templateExists) {
            return redirect()->route('admin.contracts.show', $contract)
                ->with('error', 'The contract file was not found. Try generating the contract again from the original template.');
        } else {
            return redirect()->route('admin.contracts.show', $contract)
                ->with('error', 'Contract file not found and the original template is also not available. Please contact the administrator.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        // Remover o arquivo
        if (Storage::exists($contract->file_path)) {
            Storage::delete($contract->file_path);
        }

        // Excluir o registro
        $contract->delete();

        return redirect()->route('admin.contracts.index')
            ->with('success', 'Contract deleted successfully.');
    }
}
