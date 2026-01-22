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
     * Armazenar um novo lead.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|max:5',
            'website' => 'nullable|string|url|max:255',
            'message' => 'nullable|string',
            'source' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('validation.failed'),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $lead = $this->leadService->createLead($request->all());
            
            return response()->json([
                'success' => true,
                'message' => trans('api.leads.created_successfully'),
                'data' => $lead
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('api.leads.failed_to_create'),
                'error' => $e->getMessage()
            ], $e->getCode() == 422 ? 422 : 500);
        }
    }

    /**
     * Listar todos os leads (protegido).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Esta rota deve ser protegida com middleware auth:sanctum
        $filters = $request->only(['status', 'source', 'start_date', 'end_date', 'search', 'per_page']);
        
        $leads = $this->leadService->getAllLeads($filters);
        
        return response()->json([
            'success' => true,
            'data' => $leads
        ]);
    }

    /**
     * Mostrar um lead específico (protegido).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Esta rota deve ser protegida com middleware auth:sanctum
        try {
            $lead = $this->leadService->getLeadById($id);
            
            return response()->json([
                'success' => true,
                'data' => $lead
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('api.leads.not_found')
            ], 404);
        }
    }

    /**
     * Atualizar um lead (protegido).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Esta rota deve ser protegida com middleware auth:sanctum
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:new,contacted,qualified,converted,closed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('validation.failed'),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $lead = $this->leadService->updateLead($id, $request->all());
            
            return response()->json([
                'success' => true,
                'message' => trans('api.leads.updated_successfully'),
                'data' => $lead
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('api.leads.failed_to_update'),
                'error' => $e->getMessage()
            ], $e->getCode() == 404 ? 404 : ($e->getCode() == 422 ? 422 : 500));
        }
    }

    /**
     * Remover um lead (protegido).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Esta rota deve ser protegida com middleware auth:sanctum
        try {
            $this->leadService->deleteLead($id);
            
            return response()->json([
                'success' => true,
                'message' => trans('api.leads.deleted_successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('api.leads.failed_to_delete'),
                'error' => $e->getMessage()
            ], $e->getCode() == 404 ? 404 : 500);
        }
    }
    
    /**
     * Obter estatísticas de leads (protegido).
     *
     * @return \Illuminate\Http\Response
     */
    public function stats()
    {
        // Esta rota deve ser protegida com middleware auth:sanctum
        $stats = $this->leadService->getLeadStats();
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
} 