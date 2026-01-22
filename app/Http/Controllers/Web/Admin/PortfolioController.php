<?php

namespace App\Http\Controllers\Web\Admin;

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
     * Display list of portfolio projects in admin
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'category', 'featured', 'per_page']);
        $portfolios = $this->portfolioService->getAllPortfolios($filters);
        
        return view('pages.admin.portfolio.index', compact('portfolios'));
    }

    /**
     * Display form to create new project
     */
    public function create()
    {
        $categories = $this->portfolioService->getCategories();
        
        return view('pages.admin.portfolio.create', compact('categories'));
    }

    /**
     * Save new project
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
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $portfolio = $this->portfolioService->createPortfolio($request->all());
        
        return redirect()
            ->route('admin.portfolio.index')
            ->with('success', 'Project created successfully!');
    }

    /**
     * Display project details
     */
    public function show($id)
    {
        $portfolio = $this->portfolioService->getPortfolioById($id);
        
        return view('pages.admin.portfolio.show', compact('portfolio'));
    }

    /**
     * Display form to edit project
     */
    public function edit($id)
    {
        $portfolio = $this->portfolioService->getPortfolioById($id);
        $categories = $this->portfolioService->getCategories();
        
        return view('pages.admin.portfolio.edit', compact('portfolio', 'categories'));
    }

    /**
     * Update existing project
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:10000',
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
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $portfolio = $this->portfolioService->updatePortfolio($id, $request->all());
        
        return redirect()
            ->route('admin.portfolio.index')
            ->with('success', 'Project updated successfully!');
    }

    /**
     * Remove project
     */
    public function destroy($id)
    {
        $this->portfolioService->deletePortfolio($id);
        
        return redirect()
            ->route('admin.portfolio.index')
            ->with('success', 'Project removed successfully!');
    }

    /**
     * Display categories page
     */
    public function categories()
    {
        $categories = $this->portfolioService->getCategories();
        
        return view('pages.admin.portfolio.categories', compact('categories'));
    }
}
