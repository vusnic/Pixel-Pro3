<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    /**
     * Exibir página de serviços
     */
    public function index()
    {
        $services = $this->serviceService->getPublishedServices();
        
        return view('pages.services', compact('services'));
    }

    /**
     * Exibir detalhes de um serviço específico
     */
    public function show($id)
    {
        try {
            $service = $this->serviceService->getServiceById($id);
            
            // Verificar se o serviço está publicado
            if ($service->status !== 'published') {
                abort(404);
            }
            
            return view('pages.service-details', compact('service'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
} 