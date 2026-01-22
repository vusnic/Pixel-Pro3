<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ContractTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'file_path',
        'placeholders',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'placeholders' => 'array',
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'template_id');
    }

    public function getStoragePath()
    {
        return 'contracts/templates/' . basename($this->file_path);
    }

    public function getFullPath()
    {
        $path = storage_path('app/' . $this->file_path);
        
        // Verifica se o arquivo existe no caminho original
        if (!file_exists($path) || filesize($path) <= 0) {
            Log::warning("Template #{$this->id}: Arquivo não encontrado ou vazio no caminho: {$path}");
            
            // Verificar se o path está correto mas com barras diferentes
            $alternativePath = str_replace('\\', '/', $path);
            $alternativePath2 = str_replace('/', '\\', $path);
            
            if (file_exists($alternativePath) && filesize($alternativePath) > 0) {
                Log::info("Template #{$this->id}: Arquivo encontrado em caminho alternativo: {$alternativePath}");
                return $alternativePath;
            }
            
            if (file_exists($alternativePath2) && filesize($alternativePath2) > 0) {
                Log::info("Template #{$this->id}: Arquivo encontrado em caminho alternativo: {$alternativePath2}");
                return $alternativePath2;
            }
            
            Log::error("Template #{$this->id}: Arquivo não encontrado em nenhum local. Providencie um novo upload do template.");
        }
        
        return $path;
    }
}
