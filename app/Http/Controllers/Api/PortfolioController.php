<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PortfolioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{
    protected $portfolioService;

    public function __construct(PortfolioService $portfolioService)
    {
        $this->portfolioService = $portfolioService;
    }

    /**
     * Obter lista de projetos
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'category', 'featured', 'per_page']);
        
        // Para a API pública, padrão é mostrar apenas os projetos publicados
        if (!isset($filters['status']) && !auth('sanctum')->check()) {
            $filters['status'] = 'published';
        }
        
        $portfolios = $this->portfolioService->getAllPortfolios($filters);
        
        return response()->json([
            'success' => true,
            'data' => $portfolios
        ]);
    }

    /**
     * Obter detalhes de um projeto específico
     */
    public function show($id)
    {
        try {
            $portfolio = $this->portfolioService->getPortfolioById($id);
            
            // Verificar se o projeto está publicado ou se o usuário está autenticado
            if ($portfolio->status !== 'published' && !auth('sanctum')->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project not found or not available.'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => $portfolio
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.'
            ], 404);
        }
    }

    /**
     * Obter categorias disponíveis
     */
    public function categories()
    {
        $categories = $this->portfolioService->getCategories();
        
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Criar novo projeto (requer autenticação)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:10000',
            'category' => 'required|string|max:50',
            'technologies' => 'nullable|string',
            'client_name' => 'nullable|string|max:100',
            'project_url' => 'nullable|url|max:255',
            'completion_date' => 'nullable|date',
            'highlights' => 'nullable|array',
            'order' => 'nullable|integer',
            'featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $portfolio = $this->portfolioService->createPortfolio($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Project created successfully.',
                'data' => $portfolio
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create project.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualizar projeto existente (requer autenticação)
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image' => 'nullable|image|max:10000',
            'category' => 'sometimes|required|string|max:50',
            'technologies' => 'nullable|string',
            'client_name' => 'nullable|string|max:100',
            'project_url' => 'nullable|url|max:255',
            'completion_date' => 'nullable|date',
            'highlights' => 'nullable|array',
            'order' => 'nullable|integer',
            'featured' => 'nullable|boolean',
            'status' => 'sometimes|required|in:draft,published',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $portfolio = $this->portfolioService->updatePortfolio($id, $request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Project updated successfully.',
                'data' => $portfolio
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update project.',
                'error' => $e->getMessage()
            ], $e->getCode() == 404 ? 404 : 500);
        }
    }

    /**
     * Excluir projeto (requer autenticação)
     */
    public function destroy($id)
    {
        try {
            $this->portfolioService->deletePortfolio($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Project deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete project.',
                'error' => $e->getMessage()
            ], $e->getCode() == 404 ? 404 : 500);
        }
    }
}
