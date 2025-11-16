<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        // Routes are already protected by middleware can:manage_roles
    }

    public function index()
    {
        $user = auth()->user();
        if (!$user->can('manage_roles') && !$user->hasRole('super-admin') && !$user->hasRole('admin')) {
            abort(403, 'This action is unauthorized.');
        }

        $permissions = Permission::latest()
            ->paginate(10);
            
        return view('admin.permissions.index', [
            'permissions' => $permissions,
        ]);
    }

    public function create()
    {
        $user = auth()->user();
        if (!$user->can('manage_roles') && !$user->hasRole('super-admin') && !$user->hasRole('admin')) {
            abort(403, 'This action is unauthorized.');
        }

        return view('admin.permissions.form');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->can('manage_roles') && !$user->hasRole('super-admin') && !$user->hasRole('admin')) {
            abort(403, 'This action is unauthorized.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'sometimes|string|in:web,api',
        ]);

        try {
            DB::beginTransaction();
            
            Permission::create([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name'] ?? 'web',
            ]);
            
            DB::commit();
            
            return redirect()
                ->route('permissions.index')
                ->with('success', 'Permission created successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create permission');
        }
    }

    public function edit(Permission $permission)
    {
        $user = auth()->user();
        if (!$user->can('manage_roles') && !$user->hasRole('super-admin') && !$user->hasRole('admin')) {
            abort(403, 'This action is unauthorized.');
        }

        return view('admin.permissions.form', [
            'permission' => $permission,
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $user = auth()->user();
        if (!$user->can('manage_roles') && !$user->hasRole('super-admin') && !$user->hasRole('admin')) {
            abort(403, 'This action is unauthorized.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'guard_name' => 'sometimes|string|in:web,api',
        ]);

        try {
            DB::beginTransaction();
            
            $permission->update([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name'] ?? $permission->guard_name,
            ]);
            
            DB::commit();
            
            return redirect()
                ->route('permissions.index')
                ->with('success', 'Permission updated successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update permission');
        }
    }

    public function destroy(Permission $permission)
    {
        $user = auth()->user();
        if (!$user->can('manage_roles') && !$user->hasRole('super-admin') && !$user->hasRole('admin')) {
            abort(403, 'This action is unauthorized.');
        }

        try {
            // Don't allow deletion if permission is assigned to roles
            if ($permission->roles()->count() > 0) {
                return back()
                    ->with('error', 'Cannot delete permission assigned to roles');
            }
            
            $permission->delete();
            
            return redirect()
                ->route('permissions.index')
                ->with('success', 'Permission deleted successfully');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete permission');
        }
    }
}