<?php

namespace App\Http\Controllers;

use App\Models\ProjectContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProjectContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $roles = array_merge(array_keys(ProjectContact::getRoles()), ['other']);

        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', Rule::in($roles)],
            'role_custom' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'is_primary' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
        ]);

        $role = $validated['role'] ?? null;
        $roleCustom = $validated['role_custom'] ?? null;
        if (($role === 'other' || $role === null) && !empty($roleCustom)) {
            $role = Str::slug($roleCustom, '_');
        }

        unset($validated['role_custom']);
        $validated['role'] = $role;
        $validated['is_primary'] = $request->boolean('is_primary');

        if ($validated['is_primary']) {
            ProjectContact::where('project_id', $validated['project_id'])->update(['is_primary' => false]);
        }

        ProjectContact::create($validated);

        return redirect()
            ->route('projects.show', $validated['project_id'])
            ->with('success', 'Project contact added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectContact $projectContact)
    {
        $projectContact->load('project');
        $roles = ProjectContact::getRoles();

        return view('admin.project-contacts.edit', [
            'projectContact' => $projectContact,
            'project' => $projectContact->project,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectContact $projectContact): RedirectResponse
    {
        $roles = array_merge(array_keys(ProjectContact::getRoles()), ['other']);

        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', Rule::in($roles)],
            'role_custom' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'is_primary' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
        ]);

        $role = $validated['role'] ?? null;
        $roleCustom = $validated['role_custom'] ?? null;
        if (($role === 'other' || $role === null) && !empty($roleCustom)) {
            $role = Str::slug($roleCustom, '_');
        }

        unset($validated['role_custom']);
        $validated['role'] = $role;
        $validated['is_primary'] = $request->boolean('is_primary');

        if ($validated['is_primary']) {
            ProjectContact::where('project_id', $validated['project_id'])
                ->whereKeyNot($projectContact->id)
                ->update(['is_primary' => false]);
        }

        $projectContact->update($validated);

        return redirect()
            ->route('projects.show', $validated['project_id'])
            ->with('success', 'Project contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectContact $projectContact): RedirectResponse
    {
        $projectId = $projectContact->project_id;
        $projectContact->delete();

        return redirect()
            ->route('projects.show', $projectId)
            ->with('success', 'Project contact deleted successfully.');
    }
}
