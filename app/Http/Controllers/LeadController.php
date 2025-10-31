<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Product;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Lead::with(['status', 'assignedUser', 'product', 'branch']);

            // Apply filters
            if ($request->filled('status')) {
                $query->whereHas('status', function ($q) use ($request) {
                    $q->where('name', $request->status);
                });
            }

            if ($request->filled('lead_type')) {
                $query->where('lead_type', $request->lead_type);
            }

            if ($request->filled('assigned_to')) {
                if ($request->assigned_to === 'Unassigned') {
                    $query->whereNull('assigned_to');
                } else {
                    $query->whereHas('assignedUser', function ($q) use ($request) {
                        $q->where('name', $request->assigned_to);
                    });
                }
            }

            if ($request->filled('source')) {
                $query->where('source', $request->source);
            }

            return DataTables::eloquent($query)
                ->addColumn('action', function ($lead) {
                    return view('leads.partials.actions', compact('lead'))->render();
                })
                ->editColumn('id', function ($lead) {
                    return '<span class="badge bg-light text-dark">#'.$lead->id.'</span>';
                })
                ->editColumn('name', function ($lead) {
                    return view('leads.partials.name', compact('lead'))->render();
                })
                ->editColumn('email', function ($lead) {
                    return view('leads.partials.email', compact('lead'))->render();
                })
                ->editColumn('phone', function ($lead) {
                    return view('leads.partials.phone', compact('lead'))->render();
                })
                ->addColumn('status', function ($lead) {
                    return view('leads.partials.status', compact('lead'))->render();
                })
                ->addColumn('lead_type', function ($lead) {
                    return view('leads.partials.lead-type', compact('lead'))->render();
                })
                ->addColumn('assigned_to', function ($lead) {
                    return view('leads.partials.assigned', compact('lead'))->render();
                })
                ->addColumn('product', function ($lead) {
                    $names = $lead->products ? $lead->products->pluck('name')->implode(', ') : ($lead->product->name ?? '-');
                    return $names ?: '-';
                })
                ->addColumn('branch', function ($lead) {
                    return view('leads.partials.branch', compact('lead'))->render();
                })
                ->addColumn('source', function ($lead) {
                    return view('leads.partials.source', compact('lead'))->render();
                })
                ->editColumn('created_at', function ($lead) {
                    return view('leads.partials.created', compact('lead'))->render();
                })
                ->rawColumns(['id', 'name', 'email', 'phone', 'status', 'lead_type', 'assigned_to', 'product', 'branch', 'source', 'created_at', 'action'])
                ->make(true);
        }

        $statuses = LeadStatus::all();
        $users = User::all();
        $products = Product::all();
        $branches = Branch::all();

        $totalLeads = Lead::count();
        $leadsByStatus = LeadStatus::withCount('leads')->get();
        $convertedLeads = Lead::whereHas('status', function ($q) {
            $q->where('name', 'like', '%won%')
              ->orWhere('name', 'like', '%converted%')
              ->orWhere('name', 'like', '%closed%');
        })->count();
        $totalProducts = Product::count();

        return view('leads.index', compact(
            'statuses',
            'users',
            'products',
            'branches',
            'totalLeads',
            'leadsByStatus',
            'convertedLeads',
            'totalProducts'
        ));
    }

    public function create()
    {
        $statuses = LeadStatus::all();
        $users = User::all();
        $products = Product::where('status', 'active')->get();
        $branches = Branch::all();

        return view('leads.create', compact('statuses', 'users', 'products', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'status_id' => 'required|exists:lead_statuses,id',
            'assigned_to' => 'nullable|exists:users,id',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'branch_id' => 'nullable|exists:branches,id',
            'source' => 'nullable|string|max:255',
            'lead_type' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'closing_date' => 'nullable|date',
            'products' => 'nullable|array',
            'products.*.product_id' => 'required_with:products|exists:products,id',
            'products.*.quantity' => 'nullable|integer|min:1',
            'products.*.description' => 'nullable|string|max:1000',
        ]);

        $leadData = collect($validated)->except(['product_ids'])->toArray();
        $lead = Lead::create($leadData);

        if (! empty($validated['products'])) {
            $sync = [];
            foreach ($validated['products'] as $row) {
                if (! empty($row['product_id'])) {
                    $sync[$row['product_id']] = [
                        'quantity' => $row['quantity'] ?? 1,
                        'description' => $row['description'] ?? null,
                    ];
                }
            }
            if (! empty($sync)) {
                $lead->products()->sync($sync);
            }
        }
        

        // Create notifications
        if (! empty($validated['assigned_to'])) {
            $assignedUser = User::find($validated['assigned_to']);
            NotificationService::leadAssigned($assignedUser, $lead);
        }

        // Notify admins about new lead
        try {
            NotificationService::notifyAdmins(
                'lead_created',
                'New Lead Created',
                "A new lead '{$lead->name}' has been created by ".auth()->user()->name.'.',
                route('leads.show', $lead),
                'plus-circle',
                'success'
            );
        } catch (\Exception $e) {
            // Silently fail if notifications don't work in test environment
        }

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    public function show(Lead $lead)
    {
        $lead->load(['status', 'assignedUser', 'product', 'products', 'branch', 'leadNotes.user', 'followups.user']);
        $statuses = LeadStatus::all();

        return view('leads.show', compact('lead', 'statuses'));
    }

    public function edit(Lead $lead)
    {
        $statuses = LeadStatus::all();
        $users = User::all();
        $products = Product::where('status', 'active')->get();
        $branches = Branch::all();

        return view('leads.edit', compact('lead', 'statuses', 'users', 'products', 'branches'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'status_id' => 'required|exists:lead_statuses,id',
            'assigned_to' => 'nullable|exists:users,id',
            'products' => 'nullable|array',
            'products.*.product_id' => 'required_with:products|exists:products,id',
            'products.*.quantity' => 'nullable|integer|min:1',
            'products.*.description' => 'nullable|string|max:1000',
            'branch_id' => 'nullable|exists:branches,id',
            'source' => 'nullable|string|max:255',
            'lead_type' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'closing_date' => 'nullable|date',
        ]);

        $leadData = collect($validated)->except(['product_ids'])->toArray();
        $lead->update($leadData);
        $sync = [];
        foreach (($validated['products'] ?? []) as $row) {
            if (! empty($row['product_id'])) {
                $sync[$row['product_id']] = [
                    'quantity' => $row['quantity'] ?? 1,
                    'description' => $row['description'] ?? null,
                ];
            }
        }
        $lead->products()->sync($sync);

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status_id' => 'required|exists:lead_statuses,id',
        ]);

        $lead->update(['status_id' => $validated['status_id']]);

        return redirect()->route('leads.show', $lead)->with('success', 'Lead status updated successfully.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }
}
