<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Validator;

class LeadService
{
    /**
     * Obter todos os leads com filtros opcionais.
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

        // Filtrar spam: por padrão exibe apenas leads não-spam
        if (isset($filters['is_spam'])) {
            $query->where('is_spam', (bool) $filters['is_spam']);
        } else {
            $query->where('is_spam', false);
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
            $query->where(function ($q) use ($search) {
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
     * Obter um lead pelo ID.
     */
    public function getLeadById(int $id)
    {
        return Lead::findOrFail($id);
    }

    /**
     * Criar um novo lead com rastreamento anti-spam.
     *
     * @param array  $data
     * @param string $ipAddress  IP do cliente
     * @param string $userAgent  User-Agent do cliente
     * @param int    $spamScore  Score 0-100 calculado pelo controller
     */
    public function createLead(array $data, string $ipAddress = '', string $userAgent = '', int $spamScore = 0)
    {
        $validator = Validator::make($data, [
            'name'    => 'required|string|min:2|max:100',
            'email'   => 'required|string|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string|min:10|max:2000',
            'source'  => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            throw new \Exception(trans('validation.failed') . ': ' . $validator->errors()->first(), 422);
        }

        // Score 50-79 → salva mas marca como suspeito para revisão manual
        $isSpam = $spamScore >= 50;

        return Lead::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'] ?? null,
            'message'    => $data['message'] ?? null,
            'source'     => $data['source'] ?? 'website',
            'status'     => 'new',
            'ip_address' => $ipAddress,
            'user_agent' => substr($userAgent ?? '', 0, 255),
            'is_spam'    => $isSpam,
            'spam_score' => $spamScore,
        ]);
    }

    /**
     * Atualizar um lead existente.
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
     * Excluir um lead.
     */
    public function deleteLead(int $id)
    {
        $lead = Lead::findOrFail($id);
        return $lead->delete();
    }

    /**
     * Obter estatísticas de leads — inclui métricas de spam.
     */
    public function getLeadStats()
    {
        $total      = Lead::where('is_spam', false)->count();
        $totalSpam  = Lead::where('is_spam', true)->count();

        $byStatus = Lead::where('is_spam', false)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        foreach (['new', 'contacted', 'qualified', 'converted', 'closed'] as $status) {
            if (!isset($byStatus[$status])) {
                $byStatus[$status] = 0;
            }
        }

        $recentLeads = Lead::where('is_spam', false)->latest()->take(5)->get();

        $bySource = Lead::where('is_spam', false)
            ->selectRaw('source, count(*) as count')
            ->groupBy('source')
            ->get()
            ->pluck('count', 'source')
            ->toArray();

        return [
            'total'      => $total,
            'spam'       => $totalSpam,
            'by_status'  => $byStatus,
            'recent'     => $recentLeads,
            'by_source'  => $bySource,
        ];
    }
}
