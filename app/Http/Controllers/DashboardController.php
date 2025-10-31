<?php

namespace App\Http\Controllers;

use App\Models\Followup;
use App\Models\Lead;
use App\Models\LeadStatus;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLeads = Lead::count();
        $leadsByStatus = LeadStatus::withCount('leads')->get();
        $recentFollowups = Followup::with(['lead', 'user'])
            ->orderBy('followup_date', 'desc')
            ->limit(10)
            ->get();
        $recentLeads = Lead::with(['status', 'assignedUser'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact('totalLeads', 'leadsByStatus', 'recentFollowups', 'recentLeads'));
    }
}
