<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceService
{
    /**
     * Obter todos os serviços com possibilidade de filtros
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllServices(array $filters = []): LengthAwarePaginator
    {
        $query = Service::query();
        
        // Aplica filtro de status (published ou draft)
        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }
        
        // Aplica filtro de destaque (featured)
        if (isset($filters['featured']) && $filters['featured'] !== '') {
            $query->where('featured', (bool) $filters['featured']);
        }
        
        // Filtro de busca por título ou descrição
        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Ordenação padrão por ordem e depois por título
        $query->orderBy('order', 'asc')->orderBy('title', 'asc');
        
        // Paginação
        $perPage = $filters['per_page'] ?? 10;
        
        return $query->paginate($perPage);
    }
    
    /**
     * Obter apenas serviços publicados
     *
     * @return Collection
     */
    public function getPublishedServices(): Collection
    {
        return Service::where('status', 'published')
            ->orderBy('order', 'asc')
            ->orderBy('title', 'asc')
            ->get();
    }
    
    /**
     * Obter serviço por ID
     *
     * @param int $id
     * @return Service
     */
    public function getServiceById(int $id): Service
    {
        return Service::findOrFail($id);
    }
    
    /**
     * Criar novo serviço
     *
     * @param array $data
     * @return Service
     */
    public function createService(array $data): Service
    {
        $serviceData = $this->prepareServiceData($data);
        
        // Processa a imagem, se existir
        if (isset($data['image'])) {
            $serviceData['image_path'] = $data['image']->store('services', 'public');
        }
        
        return Service::create($serviceData);
    }
    
    /**
     * Atualizar serviço existente
     *
     * @param int $id
     * @param array $data
     * @return Service
     */
    public function updateService(int $id, array $data): Service
    {
        $service = $this->getServiceById($id);
        $serviceData = $this->prepareServiceData($data);
        
        // Processa a imagem, se existir
        if (isset($data['image'])) {
            // Remove a imagem antiga, se existir
            if ($service->image_path) {
                Storage::disk('public')->delete($service->image_path);
            }
            
            $serviceData['image_path'] = $data['image']->store('services', 'public');
        }
        
        $service->update($serviceData);
        
        return $service;
    }
    
    /**
     * Remover serviço
     *
     * @param int $id
     * @return bool
     */
    public function deleteService(int $id): bool
    {
        $service = $this->getServiceById($id);
        
        // Remove a imagem, se existir
        if ($service->image_path) {
            Storage::disk('public')->delete($service->image_path);
        }
        
        return $service->delete();
    }
    
    /**
     * Preparar dados do serviço para criação/atualização
     *
     * @param array $data
     * @return array
     */
    private function prepareServiceData(array $data): array
    {
        // Prepara os dados básicos
        $serviceData = [
            'title' => $data['title'],
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'],
            'price' => $data['price'] ?? null,
            'price_period' => $data['price_period'] ?? null,
            'order' => $data['order'] ?? 0,
            'status' => $data['status'] ?? 'draft',
            'cta_text' => $data['cta_text'] ?? null,
            'cta_url' => $data['cta_url'] ?? null,
            'featured' => isset($data['featured']) ? (bool) $data['featured'] : false,
        ];
        
        // Codifica os highlights para JSON
        if (isset($data['highlights']) && is_array($data['highlights'])) {
            // Filtra valores vazios
            $highlights = array_filter($data['highlights'], fn($item) => !empty($item));
            $serviceData['highlights'] = json_encode($highlights);
        }
        
        return $serviceData;
    }
    
    /**
     * Obter serviços em destaque
     */
    public function getFeaturedServices()
    {
        return Service::where('featured', true)
                      ->where('status', 'published')
                      ->orderBy('order')
                      ->get();
    }
    
    /**
     * Upload de imagem
     */
    private function uploadImage(UploadedFile $image)
    {
        $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('services', $filename, 'public');
        
        return $path;
    }
} 