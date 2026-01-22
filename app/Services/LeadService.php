<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Validator;

class LeadService
{
    /**
     * Obter todos os leads com filtros opcionais
     */
    public function getAllLeads(array $filters = [])
    {
        $query = Lead::query();
        
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['source'])) {
            $query->where('source', $filters['source']);
        }
        
        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        } elseif (isset($filters['start_date'])) {
            $query->where('created_at', '>=', $filters['start_date']);
        } elseif (isset($filters['end_date'])) {
            $query->where('created_at', '<=', $filters['end_date']);
        }
        
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }
        
        return $query->orderBy('created_at', 'desc')
                     ->paginate($filters['per_page'] ?? 15);
    }
    
    /**
     * Obter um lead pelo ID
     */
    public function getLeadById(int $id)
    {
        return Lead::findOrFail($id);
    }
    
    /**
     * Criar um novo lead
     */
    public function createLead(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|max:5',
            'website' => 'nullable|string|url|max:255',
            'message' => 'nullable|string',
            'source' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            throw new \Exception(trans('validation.failed') . ': ' . $validator->errors()->first(), 422);
        }
        
        return Lead::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'country_code' => $data['country_code'] ?? '+1',
            'website' => $data['website'] ?? null,
            'message' => $data['message'] ?? null,
            'source' => $data['source'] ?? 'website',
            'status' => 'new'
        ]);
    }
    
    /**
     * Atualizar um lead existente
     */
    public function updateLead(int $id, array $data)
    {
        $lead = Lead::findOrFail($id);
        
        if (isset($data['status'])) {
            $validator = Validator::make($data, [
                'status' => 'required|string|in:new,contacted,qualified,converted,closed',
            ]);

            if ($validator->fails()) {
                throw new \Exception(trans('validation.failed') . ': ' . $validator->errors()->first(), 422);
            }
        }
        
        $lead->update($data);
        
        return $lead;
    }
    
    /**
     * Excluir um lead
     */
    public function deleteLead(int $id)
    {
        $lead = Lead::findOrFail($id);
        return $lead->delete();
    }
    
    /**
     * Obter estatísticas de leads
     */
    public function getLeadStats()
    {
        $total = Lead::count();
        $byStatus = Lead::selectRaw('status, count(*) as count')
                        ->groupBy('status')
                        ->get()
                        ->pluck('count', 'status')
                        ->toArray();
        
        // Garantir que todos os status possíveis estejam presentes
        $allStatuses = ['new', 'contacted', 'qualified', 'converted', 'closed'];
        foreach ($allStatuses as $status) {
            if (!isset($byStatus[$status])) {
                $byStatus[$status] = 0;
            }
        }
        
        $recentLeads = Lead::latest()->take(5)->get();
        
        $bySource = Lead::selectRaw('source, count(*) as count')
                        ->groupBy('source')
                        ->get()
                        ->pluck('count', 'source')
                        ->toArray();
        
        return [
            'total' => $total,
            'by_status' => $byStatus,
            'recent' => $recentLeads,
            'by_source' => $bySource
        ];
    }
} 