<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\PortfolioService;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    protected $portfolioService;

    public function __construct(PortfolioService $portfolioService)
    {
        $this->portfolioService = $portfolioService;
    }

    /**
     * Exibir a página principal do portfólio
     */
    public function index(Request $request)
    {
        $filters = [
            'status' => 'published',
            'per_page' => 12
        ];
        
        if ($request->has('category')) {
            $filters['category'] = $request->category;
        }
        
        $portfolios = $this->portfolioService->getAllPortfolios($filters);
        $categories = $this->portfolioService->getCategories();
        
        return view('pages.portfolio', compact('portfolios', 'categories'));
    }

    /**
     * Exibir os detalhes de um projeto específico
     */
    public function show($id)
    {
        $portfolio = $this->portfolioService->getPortfolioById($id);
        
        // Verificar se o projeto está publicado
        if ($portfolio->status !== 'published') {
            abort(404);
        }
        
        // Buscar projetos relacionados da mesma categoria
        $related = $this->portfolioService->getAllPortfolios([
            'status' => 'published',
            'category' => $portfolio->category,
            'per_page' => 3
        ])->except($portfolio->id);
        
        return view('pages.portfolio-details', compact('portfolio', 'related'));
    }
}
