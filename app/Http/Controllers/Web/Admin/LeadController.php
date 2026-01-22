<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\LeadService;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    protected $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    /**
     * Display all leads
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'source', 'start_date', 'end_date', 'search', 'per_page']);
        $leads = $this->leadService->getAllLeads($filters);
        
        return view('pages.admin.leads.index', compact('leads'));
    }

    /**
     * Display specific lead details
     */
    public function show($id)
    {
        $lead = $this->leadService->getLeadById($id);
        return view('pages.admin.leads.show', compact('lead'));
    }

    /**
     * Update lead status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:new,contacted,qualified,converted,closed',
        ]);

        $lead = $this->leadService->updateLead($id, $request->only('status'));

        return redirect()->route('admin.leads.show', $lead)
            ->with('success', 'Lead status updated successfully!');
    }

    /**
     * Remove a lead
     */
    public function destroy($id)
    {
        $this->leadService->deleteLead($id);

        return redirect()->route('admin.leads.index')
            ->with('success', 'Lead removed successfully!');
    }

    /**
     * Export leads to PDF view
     */
    public function exportToPdf(Request $request)
    {
        $filters = $request->only(['status', 'source', 'start_date', 'end_date', 'search']);
        $filters['per_page'] = 1000; // Get more records for PDF export
        $leads = $this->leadService->getAllLeads($filters);
        
        return view('pages.admin.leads.export-pdf', compact('leads', 'filters'));
    }
} 