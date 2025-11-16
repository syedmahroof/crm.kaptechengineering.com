<?php

namespace App\Http\Controllers\Leads;


use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class LeadsAnalyticsController
{
    /**
     * Show the leads analytics dashboard.
     *
     * @return \Inertia\Response
     */
    public function analytics()
    {
        $stats = [
            'total' => Lead::count(),
            'new' => Lead::where('status', Lead::STATUS_NEW)->count(),
            'contacted' => Lead::where('status', Lead::STATUS_CONTACTED)->count(),
            'qualified' => Lead::where('status', Lead::STATUS_QUALIFIED)->count(),
            'converted' => Lead::where('status', Lead::STATUS_CONVERTED)->count(),
            'lost' => Lead::where('status', Lead::STATUS_LOST)->count(),
            'by_source' => Lead::select('lead_source_id', DB::raw('count(*) as total'))
                ->groupBy('lead_source_id')
                ->with('lead_source')
                ->get(),
            'by_status' => Lead::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get(),
            'by_agent' => Lead::select('lead_agent_id', DB::raw('count(*) as total'))
                ->groupBy('lead_agent_id')
                ->with('lead_agent.user')
                ->get(),
        ];

        return Inertia::render('leads/Analytics', [
            'stats' => $stats
        ]);
    }
    
}
