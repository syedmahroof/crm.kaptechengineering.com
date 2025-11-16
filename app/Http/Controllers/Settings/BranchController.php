<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Branch;
use App\Models\Lead;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

final readonly class BranchController
{
    /**
     * Display a listing of branches.
     */
    public function index(Request $request): View
    {
        $query = Branch::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('manager_name', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->active();
            } elseif ($status === 'inactive') {
                $query->inactive();
            }
        }

        $branches = $query->latest()->paginate(15)->withQueryString();

        return view('admin.settings.branches.index', [
            'branches' => $branches,
            'filters' => $request->only(['search', 'status']),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Show the form for creating a new branch.
     */
    public function create(): View
    {
        return view('admin.settings.branches.create');
    }

    /**
     * Store a newly created branch in storage.
     */
    public function store(StoreBranchRequest $request): RedirectResponse
    {
        $branch = Branch::create($request->validated());

        return redirect()
            ->route('settings.branches.index')
            ->with('status', 'Branch created successfully.');
    }

    /**
     * Display the specified branch.
     */
    public function show(Branch $branch): View
    {
        $branch->load(['users', 'leads', 'customers']);

        return view('admin.settings.branches.show', [
            'branch' => $branch,
        ]);
    }

    /**
     * Show the form for editing the specified branch.
     */
    public function edit(Branch $branch): View
    {
        return view('admin.settings.branches.edit', [
            'branch' => $branch,
        ]);
    }

    /**
     * Update the specified branch in storage.
     */
    public function update(UpdateBranchRequest $request, Branch $branch): RedirectResponse
    {
        $branch->update($request->validated());

        return redirect()
            ->route('settings.branches.index')
            ->with('status', 'Branch updated successfully.');
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroy(Branch $branch): RedirectResponse
    {
        DB::transaction(function () use ($branch) {
            // Detach users from pivot to avoid FK blocks
            $branch->users()->detach();

            // Nullify related foreign keys so we can delete the branch
            Lead::where('branch_id', $branch->id)->update(['branch_id' => null]);
            Customer::where('branch_id', $branch->id)->update(['branch_id' => null]);

            // Delete the branch
            $branch->delete();
        });

        return redirect()
            ->route('settings.branches.index')
            ->with('status', 'Branch deleted successfully.');
    }

    /**
     * Toggle branch status.
     */
    public function toggleStatus(Branch $branch): RedirectResponse
    {
        $branch->update(['is_active' => !$branch->is_active]);

        $status = $branch->is_active ? 'activated' : 'deactivated';

        return back()->with('status', "Branch {$status} successfully.");
    }
}





