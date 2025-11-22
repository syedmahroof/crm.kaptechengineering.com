<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;

class ProjectTypeController extends Controller
{
    public function index()
    {
        $types = ProjectType::ordered()->get();
        
        return view('admin.project-types.index', [
            'types' => $types,
        ]);
    }

    public function create()
    {
        return view('admin.project-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:project_types,slug',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        ProjectType::create($validated);

        return redirect()->route('project-types.index')
            ->with('success', 'Project type created successfully.');
    }

    public function edit(ProjectType $projectType)
    {
        return view('admin.project-types.edit', [
            'type' => $projectType,
        ]);
    }

    public function update(Request $request, ProjectType $projectType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:project_types,slug,' . $projectType->id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $projectType->update($validated);

        return redirect()->route('project-types.index')
            ->with('success', 'Project type updated successfully.');
    }

    public function destroy(ProjectType $projectType)
    {
        if ($projectType->projects()->exists()) {
            return back()->with('error', 'Cannot delete project type with associated projects.');
        }

        $projectType->delete();

        return redirect()->route('project-types.index')
            ->with('success', 'Project type deleted successfully.');
    }
}

