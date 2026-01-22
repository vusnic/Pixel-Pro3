<?php

namespace App\Services;

use App\Models\Portfolio;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioService
{
    /**
     * Obter todos os projetos de portfólio com filtros opcionais
     */
    public function getAllPortfolios(array $filters = [])
    {
        $query = Portfolio::query();
        
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }
        
        if (isset($filters['featured'])) {
            $query->where('featured', $filters['featured']);
        }
        
        // Ordenar por ordem definida manualmente ou por data
        return $query->orderBy('order', 'asc')
                     ->orderBy('created_at', 'desc')
                     ->paginate($filters['per_page'] ?? 10);
    }
    
    /**
     * Obter um projeto do portfólio pelo ID
     */
    public function getPortfolioById(int $id)
    {
        return Portfolio::findOrFail($id);
    }
    
    /**
     * Criar um novo projeto do portfólio
     */
    public function createPortfolio(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image_path'] = $this->uploadImage($data['image']);
            unset($data['image']);
        }
        
        // Se technologies for enviado como array, converte para string
        if (isset($data['technologies']) && is_array($data['technologies'])) {
            $data['technologies'] = implode(',', $data['technologies']);
        }
        
        // Se highlights for enviado como array, converte para JSON
        if (isset($data['highlights']) && is_array($data['highlights'])) {
            $data['highlights'] = json_encode($data['highlights']);
        }
        
        return Portfolio::create($data);
    }
    
    /**
     * Atualizar um projeto existente
     */
    public function updatePortfolio(int $id, array $data)
    {
        $portfolio = Portfolio::findOrFail($id);
        
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Remover a imagem antiga se houver
            if ($portfolio->image_path) {
                Storage::delete('public/' . $portfolio->image_path);
            }
            
            $data['image_path'] = $this->uploadImage($data['image']);
            unset($data['image']);
        }
        
        // Se technologies for enviado como array, converte para string
        if (isset($data['technologies']) && is_array($data['technologies'])) {
            $data['technologies'] = implode(',', $data['technologies']);
        }
        
        // Se highlights for enviado como array, converte para JSON
        if (isset($data['highlights']) && is_array($data['highlights'])) {
            $data['highlights'] = json_encode($data['highlights']);
        }
        
        $portfolio->update($data);
        
        return $portfolio;
    }
    
    /**
     * Excluir um projeto do portfólio
     */
    public function deletePortfolio(int $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        
        // Remover a imagem associada
        if ($portfolio->image_path) {
            Storage::delete('public/' . $portfolio->image_path);
        }
        
        return $portfolio->delete();
    }
    
    /**
     * Obter categorias únicas do portfólio
     */
    public function getCategories()
    {
        return Portfolio::select('category')
                        ->distinct()
                        ->pluck('category');
    }
    
    /**
     * Upload de imagem
     */
    private function uploadImage(UploadedFile $image)
    {
        $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('portfolio', $filename, 'public');
        
        return $path;
    }
} 