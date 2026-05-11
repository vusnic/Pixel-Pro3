<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\LeadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    protected $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    /**
     * Armazenar um novo lead com proteções anti-spam.
     */
    public function store(Request $request)
    {
        // ── 1. HONEYPOT ─────────────────────────────────────────────────────────
        // O campo "website" fica oculto no formulário. Humanos não o preenchem.
        // Bots sim. Se vier preenchido, fingimos sucesso mas não salvamos nada.
        if (!empty($request->input('website'))) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! We\'ll be in touch soon.',
            ], 201);
        }

        // ── 2. VALIDAÇÃO ────────────────────────────────────────────────────────
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|min:2|max:100',
            'email'   => 'required|string|email:rfc,dns|max:255',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string|min:10|max:2000',
            'source'  => 'nullable|string|max:50',
        ], [
            'name.min'     => 'Nome muito curto.',
            'email.email'  => 'E-mail inválido.',
            'message.min'  => 'Mensagem muito curta (mínimo 10 caracteres).',
            'message.max'  => 'Mensagem muito longa (máximo 2000 caracteres).',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos.',
                'errors'  => $validator->errors()
            ], 422);
        }

        // ── 3. SCORE DE SPAM ────────────────────────────────────────────────────
        $spamScore = $this->calculateSpamScore($request);

        // Score >= 80 → bloquear silenciosamente (fingir sucesso)
        if ($spamScore >= 80) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! We\'ll be in touch soon.',
            ], 201);
        }

        // ── 4. ANTI-DUPLICATA ───────────────────────────────────────────────────
        // Mesmo e-mail nos últimos 30 minutos → rejeitar
        $recentDuplicate = Lead::where('email', $request->input('email'))
            ->where('created_at', '>=', now()->subMinutes(30))
            ->exists();

        if ($recentDuplicate) {
            return response()->json([
                'success' => false,
                'message' => 'Já recebemos sua mensagem recentemente. Aguarde antes de enviar novamente.',
            ], 429);
        }

        // ── 5. CRIAR LEAD ───────────────────────────────────────────────────────
        try {
            $lead = $this->leadService->createLead(
                $request->only(['name', 'email', 'phone', 'message', 'source']),
                $request->ip(),
                $request->userAgent(),
                $spamScore
            );

            return response()->json([
                'success' => true,
                'message' => 'Mensagem recebida! Entraremos em contato em breve.',
                'data'    => ['id' => $lead->id]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar mensagem. Tente novamente.',
            ], 500);
        }
    }

    /**
     * Calcula um score de spam de 0-100.
     * Score >= 80 → bloqueia, 50-79 → salva como suspeito.
     */
    private function calculateSpamScore(Request $request): int
    {
        $score = 0;
        $name    = $request->input('name', '');
        $email   = $request->input('email', '');
        $message = $request->input('message', '');

        // Domínios de e-mail descartáveis comuns
        $disposableDomains = [
            'mailinator.com', 'guerrillamail.com', 'tempmail.com', 'throwaway.email',
            'yopmail.com', 'trashmail.com', '10minutemail.com', 'sharklasers.com',
            'guerrillamailblock.com', 'grr.la', 'guerrillamail.info', 'spam4.me',
            'dispostable.com', 'fakeinbox.com', 'maildrop.cc', 'mailnull.com',
            'spamgourmet.com', 'trashmail.at', 'trashmail.io', 'temp-mail.org',
            'discard.email', 'spambox.us', 'nospamfor.us', 'mailnesia.com',
        ];

        $emailDomain = strtolower(substr(strrchr($email, '@'), 1));
        if (in_array($emailDomain, $disposableDomains)) {
            $score += 60; // domínio descartável = muito suspeito
        }

        // Nome parece gerado por bot (apenas letras aleatórias, sem espaço)
        if (preg_match('/^[a-z]{8,}$/i', $name) && !str_contains($name, ' ')) {
            $score += 20;
        }

        // Mensagem com muitos links
        $linkCount = preg_match_all('/https?:\/\//i', $message);
        if ($linkCount >= 2) $score += 30;
        if ($linkCount >= 4) $score += 30;

        // Palavras-chave de spam muito comuns
        $spamKeywords = ['casino', 'viagra', 'crypto', 'bitcoin', 'investment', 'loan',
                         'click here', 'buy now', 'free money', 'earn $', 'make money'];
        foreach ($spamKeywords as $kw) {
            if (stripos($message, $kw) !== false) {
                $score += 15;
            }
        }

        // Mensagem em CAPS LOCK (> 60% maiúsculas)
        $letters = preg_replace('/[^a-zA-Z]/', '', $message);
        if (strlen($letters) > 10) {
            $upperRatio = substr_count($message, strtoupper($message)) / strlen($letters);
            if (preg_match_all('/[A-Z]/', $message) / strlen($letters) > 0.6) {
                $score += 15;
            }
        }

        // IP com muitos leads nas últimas 24h
        $ipLeadCount = Lead::where('ip_address', $request->ip())
            ->where('created_at', '>=', now()->subHours(24))
            ->count();

        if ($ipLeadCount >= 5)  $score += 25;
        if ($ipLeadCount >= 10) $score += 40;

        return min($score, 100);
    }

    /**
     * Listar todos os leads (protegido).
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'source', 'start_date', 'end_date', 'search', 'per_page', 'is_spam']);
        $leads = $this->leadService->getAllLeads($filters);

        return response()->json([
            'success' => true,
            'data'    => $leads
        ]);
    }

    /**
     * Mostrar um lead específico (protegido).
     */
    public function show($id)
    {
        try {
            $lead = $this->leadService->getLeadById($id);
            return response()->json(['success' => true, 'data' => $lead]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lead não encontrado.'], 404);
        }
    }

    /**
     * Atualizar um lead (protegido).
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:new,contacted,qualified,converted,closed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('validation.failed'),
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $lead = $this->leadService->updateLead($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => trans('api.leads.updated_successfully'),
                'data'    => $lead
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('api.leads.failed_to_update'),
                'error'   => $e->getMessage()
            ], $e->getCode() == 404 ? 404 : ($e->getCode() == 422 ? 422 : 500));
        }
    }

    /**
     * Remover um lead (protegido).
     */
    public function destroy($id)
    {
        try {
            $this->leadService->deleteLead($id);
            return response()->json(['success' => true, 'message' => trans('api.leads.deleted_successfully')]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('api.leads.failed_to_delete'),
                'error'   => $e->getMessage()
            ], $e->getCode() == 404 ? 404 : 500);
        }
    }

    /**
     * Obter estatísticas de leads (protegido).
     */
    public function stats()
    {
        $stats = $this->leadService->getLeadStats();
        return response()->json(['success' => true, 'data' => $stats]);
    }
}
