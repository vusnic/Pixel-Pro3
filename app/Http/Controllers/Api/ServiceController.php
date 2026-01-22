<?php

namespace App\Http\Controllers\Api;

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
     * List all services
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'featured', 'search', 'per_page']);
        
        // For unauthenticated users, force published status
        if (!auth('sanctum')->check()) {
            $filters['status'] = 'published';
        }
        
        $services = $this->serviceService->getAllServices($filters);
        
        return response()->json([
            'success' => true,
            'data' => $services
        ]);
    }

    /**
     * List featured services
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function featured()
    {
        $services = $this->serviceService->getAllServices([
            'status' => 'published',
            'featured' => true
        ]);
        
        return response()->json([
            'success' => true,
            'data' => $services
        ]);
    }

    /**
     * Get a specific service
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $service = $this->serviceService->getServiceById($id);
            
            // Check if the service is published or if the user is authenticated
            if ($service->status !== 'published' && !auth('sanctum')->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => $service
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found'
            ], 404);
        }
    }

    /**
     * Create a new service
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Check authentication
        if (!auth('sanctum')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
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
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $service = $this->serviceService->createService($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Service created successfully',
                'data' => $service
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating service: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing service
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Check authentication
        if (!auth('sanctum')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:10000',
            'highlights' => 'nullable|array',
            'price' => 'nullable|numeric',
            'price_period' => 'nullable|string|max:50',
            'order' => 'nullable|integer',
            'featured' => 'nullable|boolean',
            'status' => 'nullable|in:draft,published',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $service = $this->serviceService->updateService($id, $request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Service updated successfully',
                'data' => $service
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating service: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Remove a service
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Check authentication
        if (!auth('sanctum')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        
        try {
            $this->serviceService->deleteService($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Service removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing service: ' . $e->getMessage()
            ], 404);
        }
    }
} 