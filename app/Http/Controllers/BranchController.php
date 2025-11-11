<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('view branches'), 403, 'Unauthorized action.');
        
        $branches = Branch::withCount('leads')->paginate(15);

        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create branches'), 403, 'Unauthorized action.');
        
        return view('branches.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create branches'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        Branch::create($validated);

        return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
    }

    public function show(Branch $branch)
    {
        $branch->load('leads');

        return view('branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        abort_unless(auth()->user()->can('edit branches'), 403, 'Unauthorized action.');
        
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        abort_unless(auth()->user()->can('edit branches'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $branch->update($validated);

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        abort_unless(auth()->user()->can('delete branches'), 403, 'Unauthorized action.');
        
        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully.');
    }
}
