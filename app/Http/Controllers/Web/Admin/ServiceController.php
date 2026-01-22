<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    /**
     * Display list of services in admin
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'featured', 'search', 'per_page']);
        $services = $this->serviceService->getAllServices($filters);
        
        return view('pages.admin.services.index', compact('services'));
    }

    /**
     * Display form to create new service
     */
    public function create()
    {
        return view('pages.admin.services.create');
    }

    /**
     * Save new service
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:10000',
            'highlights' => 'nullable|array',
            'price' => 'nullable|numeric',
            'price_period' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
            'featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->serviceService->createService($request->all());
        
        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service created successfully!');
    }

    /**
     * Display service details
     */
    public function show($id)
    {
        $service = $this->serviceService->getServiceById($id);
        
        return view('pages.admin.services.show', compact('service'));
    }

    /**
     * Display form to edit service
     */
    public function edit($id)
    {
        $service = $this->serviceService->getServiceById($id);
        
        return view('pages.admin.services.edit', compact('service'));
    }

    /**
     * Update existing service
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:10000',
            'highlights' => 'nullable|array',
            'price' => 'nullable|numeric',
            'price_period' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
            'featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->serviceService->updateService($id, $request->all());
        
        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service updated successfully!');
    }

    /**
     * Remove service
     */
    public function destroy($id)
    {
        $this->serviceService->deleteService($id);
        
        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service removed successfully!');
    }
} 