<?php

namespace App\Http\Controllers\Leads;

use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\LeadFollowUp;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LeadAnalyticsController
{
    /**
     * Show the leads analytics dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function analytics(Request $request)
    {
        // Get date range from request or use default (last 365 days)
        $endDate = $request->filled('end_date') 
            ? Carbon::parse($request->end_date)->endOfDay()
            : now();
            
        $startDate = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : $endDate->copy()->subYear();

        $user = Auth::user();
        
        // Base query with date range filtering
        $baseQuery = Lead::query()
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            });
        
        // Apply visibility rules based on user role
        $this->applyLeadVisibility($baseQuery, $user);

        $total = (clone $baseQuery)->count();
        $converted = (clone $baseQuery)->whereHas('lead_status', function($q) {
            $q->where('slug', 'converted');
        })->count();
        $conversionRate = $total > 0 ? round(($converted / $total) * 100, 2) : 0;

        $stats = [
            'total' => $total,
            'new' => (clone $baseQuery)->whereHas('lead_status', function($q) {
                $q->where('slug', 'new');
            })->count(),
            'hot_lead' => (clone $baseQuery)->whereHas('lead_status', function($q) {
                $q->where('slug', 'hot_lead');
            })->count(),
            'convert_this_week' => (clone $baseQuery)->whereHas('lead_status', function($q) {
                $q->where('slug', 'convert_this_week');
            })->count(),
            'cold_lead' => (clone $baseQuery)->whereHas('lead_status', function($q) {
                $q->where('slug', 'cold_lead');
            })->count(),
            'converted' => $converted,
            'lost' => (clone $baseQuery)->whereHas('lead_status', function($q) {
                $q->where('slug', 'lost');
            })->count(),
            'conversion_rate' => $conversionRate,
            'by_source' => (clone $baseQuery)
                ->select('lead_source_id', DB::raw('count(*) as total'))
                ->groupBy('lead_source_id')
                ->with('lead_source')
                ->get(),
            'by_status' => (clone $baseQuery)
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get(),
            'by_agent' => (clone $baseQuery)
                ->select('assigned_user_id', DB::raw('count(*) as total'))
                ->groupBy('assigned_user_id')
                ->with('assigned_user')
                ->get(),
            'by_priority' => (clone $baseQuery)
                ->select('lead_priority_id', DB::raw('count(*) as total'))
                ->groupBy('lead_priority_id')
                ->with('lead_priority')
                ->get(),
            'monthly_trends' => $this->getMonthlyTrends($startDate, $endDate, $user),
            'daily_trends' => $this->getDailyTrends($startDate, $endDate, $user),
            'weekly_trends' => $this->getWeeklyTrends($startDate, $endDate, $user),
            'status_over_time' => $this->getStatusOverTime($startDate, $endDate, $user),
            'top_agents' => $this->getTopAgents($startDate, $endDate, $user),
            'top_sources' => $this->getTopSources($startDate, $endDate, $user),
            'time_to_conversion' => $this->getTimeToConversion($startDate, $endDate, $user),
            'response_time_metrics' => $this->getResponseTimeMetrics($startDate, $endDate, $user),
            'follow_up_metrics' => $this->getFollowUpMetrics($startDate, $endDate, $user),
            'activity_metrics' => $this->getActivityMetrics($startDate, $endDate, $user),
            'geographic_analytics' => $this->getGeographicAnalytics($startDate, $endDate, $user),
            'campaign_performance' => $this->getCampaignPerformance($startDate, $endDate, $user),
            'conversion_funnel' => $this->getConversionFunnel($startDate, $endDate, $user),
            'response_rate' => $this->getResponseRate($startDate, $endDate, $user),
            'itinerary_metrics' => $this->getItineraryMetrics($startDate, $endDate, $user),
            'lead_age_analysis' => $this->getLeadAgeAnalysis($startDate, $endDate, $user),
            'lost_reason_stats' => $this->getLostReasonStats($startDate, $endDate, $user),
            'date_range' => [
                'start' => $startDate->toDateString(),
                'end' => $endDate->toDateString(),
            ],
        ];

        return view('admin.leads.analytics', [
            'stats' => $stats,
            'filters' => [
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
            ],
        ]);
    }
    
    /**
     * Get monthly lead trends for the given date range.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return array
     */
    protected function getMonthlyTrends($startDate, $endDate, $user = null)
    {
        $query = Lead::query()
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($user) {
            $this->applyLeadVisibility($query, $user);
        }
        
        $results = $query->groupBy('month')
            ->orderBy('month')
            ->get();

        return $results->map(function ($item) {
            return [
                'month' => $item->month,
                'count' => $item->count,
            ];
        });
    }

    protected function getDailyTrends($startDate, $endDate, $user = null)
    {
        $query = Lead::query()
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($user) {
            $this->applyLeadVisibility($query, $user);
        }
        
        $results = $query->groupBy('date')
            ->orderBy('date')
            ->get();

        return $results->map(function ($item) {
            return [
                'date' => $item->date,
                'count' => $item->count,
            ];
        });
    }

    protected function getWeeklyTrends($startDate, $endDate, $user = null)
    {
        $query = Lead::query()
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('WEEK(created_at) as week'),
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($user) {
            $this->applyLeadVisibility($query, $user);
        }
        
        $results = $query->groupBy('year', 'week')
            ->orderBy('year')
            ->orderBy('week')
            ->get();

        return $results->map(function ($item) {
            return [
                'year' => $item->year,
                'week' => $item->week,
                'count' => $item->count,
            ];
        });
    }

    protected function getStatusOverTime($startDate, $endDate, $user = null)
    {
        $query = Lead::query()
            ->select(
                DB::raw('DATE(created_at) as date'),
                'lead_status_id',
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($user) {
            $this->applyLeadVisibility($query, $user);
        }
        
        $results = $query->groupBy('date', 'lead_status_id')
            ->orderBy('date')
            ->orderBy('lead_status_id')
            ->with('lead_status')
            ->get();

        $grouped = [];
        foreach ($results as $item) {
            if (!isset($grouped[$item->date])) {
                $grouped[$item->date] = [];
            }
            $statusSlug = $item->lead_status ? $item->lead_status->slug : 'unknown';
            $grouped[$item->date][$statusSlug] = $item->count;
        }

        return $grouped;
    }

    protected function getTopAgents($startDate, $endDate, $user = null, $limit = 10)
    {
        $query = Lead::query()
            ->select('assigned_user_id', DB::raw('count(*) as total'), DB::raw('sum(case when lead_status_id = (SELECT id FROM lead_statuses WHERE slug = "converted") then 1 else 0 end) as converted'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('assigned_user_id');
        
        if ($user) {
            $this->applyLeadVisibility($query, $user);
        }
        
        return $query->groupBy('assigned_user_id')
            ->with('assigned_user')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'agent_name' => $item->assigned_user->name ?? 'Unknown',
                    'total' => $item->total,
                    'converted' => $item->converted,
                    'conversion_rate' => $item->total > 0 ? round(($item->converted / $item->total) * 100, 2) : 0,
                ];
            });
    }

    protected function getTopSources($startDate, $endDate, $user = null, $limit = 10)
    {
        $query = Lead::query()
            ->select('lead_source_id', DB::raw('count(*) as total'), DB::raw('sum(case when lead_status_id = (SELECT id FROM lead_statuses WHERE slug = "converted") then 1 else 0 end) as converted'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('lead_source_id');
        
        if ($user) {
            $this->applyLeadVisibility($query, $user);
        }
        
        return $query->groupBy('lead_source_id')
            ->with('lead_source')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'source_name' => $item->lead_source->name ?? 'Unknown',
                    'total' => $item->total,
                    'converted' => $item->converted,
                    'conversion_rate' => $item->total > 0 ? round(($item->converted / $item->total) * 100, 2) : 0,
                ];
            });
    }

    protected function getTimeToConversion($startDate, $endDate, $user = null)
    {
        $baseQuery = Lead::query()
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($user) {
            $this->applyLeadVisibility($baseQuery, $user);
        }
            
        $convertedLeads = (clone $baseQuery)
            ->whereHas('lead_status', function($q) {
                $q->where('slug', 'converted');
            })
            ->whereNotNull('converted_at')
            ->get();

        if ($convertedLeads->isEmpty()) {
            return [
                'average_days' => 0,
                'median_days' => 0,
                'min_days' => 0,
                'max_days' => 0,
                'distribution' => [
                    '0-7' => 0,
                    '8-14' => 0,
                    '15-30' => 0,
                    '31-60' => 0,
                    '61-90' => 0,
                    '90+' => 0,
                ],
            ];
        }

        $daysToConversion = $convertedLeads->map(function ($lead) {
            return $lead->created_at->diffInDays($lead->converted_at);
        })->sort()->values();

        return [
            'average_days' => round($daysToConversion->avg(), 1),
            'median_days' => $daysToConversion->median(),
            'min_days' => $daysToConversion->first(),
            'max_days' => $daysToConversion->last(),
            'distribution' => $this->getDaysDistribution($daysToConversion),
        ];
    }

    protected function getDaysDistribution($daysArray)
    {
        $ranges = [
            '0-7' => 0,
            '8-14' => 0,
            '15-30' => 0,
            '31-60' => 0,
            '61-90' => 0,
            '90+' => 0,
        ];

        foreach ($daysArray as $days) {
            if ($days <= 7) {
                $ranges['0-7']++;
            } elseif ($days <= 14) {
                $ranges['8-14']++;
            } elseif ($days <= 30) {
                $ranges['15-30']++;
            } elseif ($days <= 60) {
                $ranges['31-60']++;
            } elseif ($days <= 90) {
                $ranges['61-90']++;
            } else {
                $ranges['90+']++;
            }
        }

        return $ranges;
    }

    protected function getResponseTimeMetrics($startDate, $endDate, $user = null)
    {
        $query = Lead::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('last_contacted_at');
        
        if ($user) {
            $this->applyLeadVisibility($query, $user);
        }
        
        $leadsWithContact = $query->get();

        if ($leadsWithContact->isEmpty()) {
            return [
                'average_hours' => 0,
                'average_days' => 0,
                'total_contacted' => 0,
            ];
        }

        $responseTimes = $leadsWithContact->map(function ($lead) {
            return $lead->created_at->diffInHours($lead->last_contacted_at);
        });

        return [
            'average_hours' => round($responseTimes->avg(), 1),
            'average_days' => round($responseTimes->avg() / 24, 1),
            'total_contacted' => $leadsWithContact->count(),
        ];
    }

    protected function getFollowUpMetrics($startDate, $endDate, $user = null)
    {
        $query = Lead::query()
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($user) {
            $this->applyLeadVisibility($query, $user);
        }
        
        $leads = $query->pluck('id');

        $followUps = LeadFollowUp::query()
            ->whereIn('lead_id', $leads)
            ->get();

        $byType = $followUps->groupBy('type')->map(function ($group) {
            return $group->count();
        });

        $byStatus = $followUps->groupBy('status')->map(function ($group) {
            return $group->count();
        });

        return [
            'total' => $followUps->count(),
            'completed' => $followUps->where('status', LeadFollowUp::STATUS_COMPLETED)->count(),
            'scheduled' => $followUps->where('status', LeadFollowUp::STATUS_SCHEDULED)->count(),
            'canceled' => $followUps->where('status', LeadFollowUp::STATUS_CANCELED)->count(),
            'by_type' => $byType->toArray(),
            'by_status' => $byStatus->toArray(),
            'completion_rate' => $followUps->count() > 0 
                ? round(($followUps->where('status', LeadFollowUp::STATUS_COMPLETED)->count() / $followUps->count()) * 100, 2)
                : 0,
        ];
    }

    protected function getActivityMetrics($startDate, $endDate, $user = null)
    {
        $query = Lead::query()
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($user) {
            $this->applyLeadVisibility($query, $user);
        }
        
        $leads = $query->pluck('id');

        $activities = LeadActivity::query()
            ->whereIn('lead_id', $leads)
            ->get();

        $byType = $activities->groupBy('type')->map(function ($group) {
            return $group->count();
        });

        return [
            'total' => $activities->count(),
            'by_type' => $byType->toArray(),
            'average_per_lead' => $leads->count() > 0 
                ? round($activities->count() / $leads->count(), 2)
                : 0,
        ];
    }

    protected function getGeographicAnalytics($startDate, $endDate, $user = null)
    {
        $baseQuery = Lead::query()
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($user) {
            $this->applyLeadVisibility($baseQuery, $user);
        }

        $byCountry = (clone $baseQuery)
            ->select('country_id', DB::raw('count(*) as total'))
            ->whereNotNull('country_id')
            ->groupBy('country_id')
            ->with('country')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'country' => $item->country->name ?? 'Unknown',
                    'total' => $item->total,
                ];
            });

        $byState = (clone $baseQuery)
            ->select('state_id', DB::raw('count(*) as total'))
            ->whereNotNull('state_id')
            ->groupBy('state_id')
            ->with('state')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'state' => $item->state->name ?? 'Unknown',
                    'total' => $item->total,
                ];
            });

        return [
            'by_country' => $byCountry,
            'by_state' => $byState,
        ];
    }

    protected function getCampaignPerformance($startDate, $endDate, $user = null)
    {
        $query = Lead::query()
            ->select('campaign_id', DB::raw('count(*) as total'), DB::raw('sum(case when lead_status_id = (SELECT id FROM lead_statuses WHERE slug = "converted") then 1 else 0 end) as converted'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('campaign_id');
        
        if ($user) {
            $this->applyLeadVisibility($query, $user);
        }
        
        return $query->groupBy('campaign_id')
            ->with('campaign')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'campaign_name' => $item->campaign->name ?? 'Unknown',
                    'total' => $item->total,
                    'converted' => $item->converted,
                    'conversion_rate' => $item->total > 0 ? round(($item->converted / $item->total) * 100, 2) : 0,
                ];
            });
    }

    protected function getConversionFunnel($startDate, $endDate, $user = null)
    {
        $baseQuery = Lead::query()
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($user) {
            $this->applyLeadVisibility($baseQuery, $user);
        }

        $total = (clone $baseQuery)->count();
        $new = (clone $baseQuery)->whereHas('lead_status', function($q) {
            $q->where('slug', 'new');
        })->count();
        $contacted = (clone $baseQuery)->whereNotNull('last_contacted_at')->count();
        $hotLead = (clone $baseQuery)->whereHas('lead_status', function($q) {
            $q->where('slug', 'hot_lead');
        })->count();
        $converted = (clone $baseQuery)->whereHas('lead_status', function($q) {
            $q->where('slug', 'converted');
        })->count();
        $lost = (clone $baseQuery)->whereHas('lead_status', function($q) {
            $q->where('slug', 'lost');
        })->count();

        return [
            'total_leads' => $total,
            'new' => $new,
            'contacted' => $contacted,
            'hot_lead' => $hotLead,
            'converted' => $converted,
            'lost' => $lost,
            'contact_rate' => $total > 0 ? round(($contacted / $total) * 100, 2) : 0,
            'hot_lead_rate' => $total > 0 ? round(($hotLead / $total) * 100, 2) : 0,
            'conversion_rate' => $total > 0 ? round(($converted / $total) * 100, 2) : 0,
            'loss_rate' => $total > 0 ? round(($lost / $total) * 100, 2) : 0,
        ];
    }

    protected function getResponseRate($startDate, $endDate, $user = null)
    {
        $baseQuery = Lead::query()
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($user) {
            $this->applyLeadVisibility($baseQuery, $user);
        }

        $total = (clone $baseQuery)->count();
        $withFollowUps = (clone $baseQuery)
            ->whereHas('follow_ups')
            ->count();
        $withActivities = (clone $baseQuery)
            ->whereHas('activities')
            ->count();
        $contacted = (clone $baseQuery)
            ->whereNotNull('last_contacted_at')
            ->count();

        return [
            'total' => $total,
            'with_follow_ups' => $withFollowUps,
            'with_activities' => $withActivities,
            'contacted' => $contacted,
            'follow_up_rate' => $total > 0 ? round(($withFollowUps / $total) * 100, 2) : 0,
            'activity_rate' => $total > 0 ? round(($withActivities / $total) * 100, 2) : 0,
            'contact_rate' => $total > 0 ? round(($contacted / $total) * 100, 2) : 0,
        ];
    }

    protected function getItineraryMetrics($startDate, $endDate, $user = null)
    {
        $baseQuery = Lead::query()
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($user) {
            $this->applyLeadVisibility($baseQuery, $user);
        }

        $total = (clone $baseQuery)->count();
        $itinerarySent = (clone $baseQuery)->whereNotNull('itinerary_sent_at')->count();
        $convertedAfterItinerary = (clone $baseQuery)
            ->whereNotNull('itinerary_sent_at')
            ->whereHas('lead_status', function($q) {
                $q->where('slug', 'converted');
            })
            ->count();

        return [
            'total_sent' => $itinerarySent,
            'converted_after_itinerary' => $convertedAfterItinerary,
            'send_rate' => $total > 0 ? round(($itinerarySent / $total) * 100, 2) : 0,
            'conversion_rate_after_itinerary' => $itinerarySent > 0 
                ? round(($convertedAfterItinerary / $itinerarySent) * 100, 2)
                : 0,
        ];
    }

    protected function getLeadAgeAnalysis($startDate, $endDate, $user = null)
    {
        $query = Lead::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('lead_status', function($q) {
                $q->whereNotIn('slug', ['converted', 'lost']);
            });
        
        if ($user) {
            $this->applyLeadVisibility($query, $user);
        }
        
        $leads = $query->get();

        $ageRanges = [
            '0-7 days' => 0,
            '8-14 days' => 0,
            '15-30 days' => 0,
            '31-60 days' => 0,
            '61-90 days' => 0,
            '90+ days' => 0,
        ];

        foreach ($leads as $lead) {
            $ageInDays = $lead->created_at->diffInDays(now());
            
            if ($ageInDays <= 7) {
                $ageRanges['0-7 days']++;
            } elseif ($ageInDays <= 14) {
                $ageRanges['8-14 days']++;
            } elseif ($ageInDays <= 30) {
                $ageRanges['15-30 days']++;
            } elseif ($ageInDays <= 60) {
                $ageRanges['31-60 days']++;
            } elseif ($ageInDays <= 90) {
                $ageRanges['61-90 days']++;
            } else {
                $ageRanges['90+ days']++;
            }
        }

        return [
            'age_distribution' => $ageRanges,
            'average_age' => $leads->count() > 0 
                ? round($leads->avg(function ($lead) {
                    return $lead->created_at->diffInDays(now());
                }), 1)
                : 0,
        ];
    }

    protected function getLostReasonStats($startDate, $endDate, $user = null)
    {
        $query = Lead::query()
            ->whereHas('lead_status', function($q) {
                $q->where('slug', 'lost');
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('lead_loss_reason_id');
        
        if ($user) {
            $this->applyLeadVisibility($query, $user);
        }
        
        return $query->selectRaw('lead_loss_reason_id, COUNT(*) as count')
            ->groupBy('lead_loss_reason_id')
            ->get()
            ->map(function ($item) {
                $lossReason = \App\Models\LeadLossReason::find($item->lead_loss_reason_id);
                return [
                    'reason' => $lossReason->name ?? 'Unknown',
                    'icon' => $lossReason->icon ?? 'fa-exclamation-triangle',
                    'color' => $lossReason->color ?? '#ef4444',
                    'count' => $item->count,
                ];
            })
            ->sortByDesc('count')
            ->values();
    }


    /**
     * Apply lead visibility rules based on user role.
     * 
     * - Super-admin: sees all leads
     * - Manager: sees all leads in their branches + their assigned leads (even in other branches)
     * - Team lead: sees all leads assigned to their team members + their assigned leads
     * - Agent: sees only their assigned leads
     */
    protected function applyLeadVisibility($query, $user)
    {
        // Super-admin sees all leads
        if ($user->hasRole('super-admin')) {
            return;
        }

        // Manager: sees all leads in their branches + their assigned leads
        if ($user->hasRole('manager')) {
            $branchIds = $user->branches()->pluck('branches.id');
            $query->where(function($q) use ($user, $branchIds) {
                // Leads in manager's branches
                if ($branchIds->isNotEmpty()) {
                    $q->whereIn('branch_id', $branchIds);
                }
                // OR leads assigned to the manager (even in other branches)
                $q->orWhere('assigned_user_id', $user->id);
            });
            return;
        }

        // Team lead: sees all leads assigned to their team members + their assigned leads
        if ($user->hasRole('team-lead')) {
            $teamMemberIds = collect();
            // Get all team members from teams where this user is the team lead
            $ledTeams = $user->ledTeams()->with('users')->get();
            foreach ($ledTeams as $team) {
                $teamMemberIds = $teamMemberIds->merge($team->users->pluck('id'));
            }
            // Remove the team lead's own ID from the list (we'll add it separately)
            $teamMemberIds = $teamMemberIds->unique()->filter(function($id) use ($user) {
                return $id != $user->id;
            });

            $query->where(function($q) use ($user, $teamMemberIds) {
                // Leads assigned to team members
                if ($teamMemberIds->isNotEmpty()) {
                    $q->whereIn('assigned_user_id', $teamMemberIds);
                }
                // OR leads assigned to the team lead
                $q->orWhere('assigned_user_id', $user->id);
            });
            return;
        }

        // Agent: sees only their assigned leads
        $query->where('assigned_user_id', $user->id);
    }
}
