<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function __construct()
    {
        // Routes are already protected by middleware can:manage_roles
        // Only add additional authorization for specific actions if needed
    }

    public function index()
    {
        // Allow access if user has manage_roles permission, is super-admin, or is admin
        $user = auth()->user();
        if (!$user->can('manage_roles') && !$user->hasRole('super-admin') && !$user->hasRole('admin')) {
            abort(403, 'This action is unauthorized.');
        }

        $roles = Role::with('permissions')
            ->latest()
            ->paginate(10);
            
        return view('admin.roles.index', [
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        $user = auth()->user();
        if (!$user->can('manage_roles') && !$user->hasRole('super-admin') && !$user->hasRole('admin')) {
            abort(403, 'This action is unauthorized.');
        }

        // Group permissions by category
        $allPermissions = Permission::orderBy('name')->get();
        $groupedPermissions = [];
        
        foreach ($allPermissions as $permission) {
            // Extract category from permission name (e.g., "view users" -> "Users")
            $parts = explode(' ', $permission->name);
            if (count($parts) > 1) {
                $category = ucwords(implode(' ', array_slice($parts, 1)));
            } else {
                $category = 'General';
            }
            
            // Map common categories
            if (stripos($permission->name, 'user') !== false) {
                $category = 'Users';
            } elseif (stripos($permission->name, 'role') !== false) {
                $category = 'Roles';
            } elseif (stripos($permission->name, 'permission') !== false) {
                $category = 'Permissions';
            } elseif (stripos($permission->name, 'branch') !== false) {
                $category = 'Branches';
            } elseif (stripos($permission->name, 'lead') !== false && stripos($permission->name, 'lead agent') === false && stripos($permission->name, 'lead source') === false && stripos($permission->name, 'lead priorit') === false && stripos($permission->name, 'lead type') === false) {
                $category = 'Leads';
            } elseif (stripos($permission->name, 'lead agent') !== false) {
                $category = 'Lead Agents';
            } elseif (stripos($permission->name, 'lead source') !== false) {
                $category = 'Lead Sources';
            } elseif (stripos($permission->name, 'lead priorit') !== false) {
                $category = 'Lead Priorities';
            } elseif (stripos($permission->name, 'lead type') !== false) {
                $category = 'Lead Types';
            } elseif (stripos($permission->name, 'campaign') !== false) {
                $category = 'Campaigns';
            } elseif (stripos($permission->name, 'task') !== false) {
                $category = 'Tasks';
            } elseif (stripos($permission->name, 'customer') !== false) {
                $category = 'Customers';
            } elseif (stripos($permission->name, 'itinerary') !== false) {
                $category = 'Itineraries';
            } elseif (stripos($permission->name, 'destination') !== false) {
                $category = 'Destinations';
            } elseif (stripos($permission->name, 'attraction') !== false) {
                $category = 'Attractions';
            } elseif (stripos($permission->name, 'hotel') !== false) {
                $category = 'Hotels';
            } elseif (stripos($permission->name, 'blog') !== false) {
                $category = 'Blogs';
            } elseif (stripos($permission->name, 'testimonial') !== false) {
                $category = 'Testimonials';
            } elseif (stripos($permission->name, 'faq') !== false) {
                $category = 'FAQs';
            } elseif (stripos($permission->name, 'banner') !== false) {
                $category = 'Banners';
            } elseif (stripos($permission->name, 'contact') !== false) {
                $category = 'Contacts';
            } elseif (stripos($permission->name, 'newsletter') !== false) {
                $category = 'Newsletters';
            } elseif (stripos($permission->name, 'reminder') !== false) {
                $category = 'Reminders';
            } elseif (stripos($permission->name, 'calendar') !== false) {
                $category = 'Calendar';
            }
            
            $groupedPermissions[$category][] = $permission;
        }
        
        // Sort categories
        ksort($groupedPermissions);
        
        return view('admin.roles.form', [
            'permissions' => $allPermissions,
            'groupedPermissions' => $groupedPermissions,
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->can('manage_roles') && !$user->hasRole('super-admin') && !$user->hasRole('admin')) {
            abort(403, 'This action is unauthorized.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'sometimes|array',
            'permissions.*' => 'string|exists:permissions,name'
        ]);

        try {
            DB::beginTransaction();
            
            $role = Role::create(['name' => $validated['name']]);
            
            if (isset($validated['permissions'])) {
                $role->syncPermissions($validated['permissions']);
            }
            
            DB::commit();
            
            return redirect()
                ->route('roles.index')
                ->with('success', 'Role created successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create role');
        }
    }

    public function edit(Role $role)
    {
        $user = auth()->user();
        if (!$user->can('manage_roles') && !$user->hasRole('super-admin') && !$user->hasRole('admin')) {
            abort(403, 'This action is unauthorized.');
        }

        // Prevent editing super-admin role unless user is super-admin
        if ($role->name === 'super-admin' && !$user->hasRole('super-admin')) {
            abort(403, 'You cannot edit the super-admin role.');
        }

        // Group permissions by category
        $allPermissions = Permission::orderBy('name')->get();
        $groupedPermissions = [];
        
        foreach ($allPermissions as $permission) {
            // Extract category from permission name
            $parts = explode(' ', $permission->name);
            if (count($parts) > 1) {
                $category = ucwords(implode(' ', array_slice($parts, 1)));
            } else {
                $category = 'General';
            }
            
            // Map common categories
            if (stripos($permission->name, 'user') !== false) {
                $category = 'Users';
            } elseif (stripos($permission->name, 'role') !== false) {
                $category = 'Roles';
            } elseif (stripos($permission->name, 'permission') !== false) {
                $category = 'Permissions';
            } elseif (stripos($permission->name, 'branch') !== false) {
                $category = 'Branches';
            } elseif (stripos($permission->name, 'lead') !== false && stripos($permission->name, 'lead agent') === false && stripos($permission->name, 'lead source') === false && stripos($permission->name, 'lead priorit') === false && stripos($permission->name, 'lead type') === false) {
                $category = 'Leads';
            } elseif (stripos($permission->name, 'lead agent') !== false) {
                $category = 'Lead Agents';
            } elseif (stripos($permission->name, 'lead source') !== false) {
                $category = 'Lead Sources';
            } elseif (stripos($permission->name, 'lead priorit') !== false) {
                $category = 'Lead Priorities';
            } elseif (stripos($permission->name, 'lead type') !== false) {
                $category = 'Lead Types';
            } elseif (stripos($permission->name, 'campaign') !== false) {
                $category = 'Campaigns';
            } elseif (stripos($permission->name, 'task') !== false) {
                $category = 'Tasks';
            } elseif (stripos($permission->name, 'customer') !== false) {
                $category = 'Customers';
            } elseif (stripos($permission->name, 'itinerary') !== false) {
                $category = 'Itineraries';
            } elseif (stripos($permission->name, 'destination') !== false) {
                $category = 'Destinations';
            } elseif (stripos($permission->name, 'attraction') !== false) {
                $category = 'Attractions';
            } elseif (stripos($permission->name, 'hotel') !== false) {
                $category = 'Hotels';
            } elseif (stripos($permission->name, 'blog') !== false) {
                $category = 'Blogs';
            } elseif (stripos($permission->name, 'testimonial') !== false) {
                $category = 'Testimonials';
            } elseif (stripos($permission->name, 'faq') !== false) {
                $category = 'FAQs';
            } elseif (stripos($permission->name, 'banner') !== false) {
                $category = 'Banners';
            } elseif (stripos($permission->name, 'contact') !== false) {
                $category = 'Contacts';
            } elseif (stripos($permission->name, 'newsletter') !== false) {
                $category = 'Newsletters';
            } elseif (stripos($permission->name, 'reminder') !== false) {
                $category = 'Reminders';
            } elseif (stripos($permission->name, 'calendar') !== false) {
                $category = 'Calendar';
            }
            
            $groupedPermissions[$category][] = $permission;
        }
        
        // Sort categories
        ksort($groupedPermissions);
        
        return view('admin.roles.form', [
            'role' => $role->load('permissions'),
            'permissions' => $allPermissions,
            'groupedPermissions' => $groupedPermissions,
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $user = auth()->user();
        if (!$user->can('manage_roles') && !$user->hasRole('super-admin') && !$user->hasRole('admin')) {
            abort(403, 'This action is unauthorized.');
        }

        // Protected roles that cannot be modified
        $protectedRoles = ['super-admin', 'team-lead', 'manager', 'agent'];
        if (in_array($role->name, $protectedRoles)) {
            abort(403, 'This role cannot be modified.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'sometimes|array',
            'permissions.*' => 'string|exists:permissions,name'
        ]);

        try {
            DB::beginTransaction();
            
            // Protected roles cannot have their name changed
            $protectedRoles = ['super-admin', 'team-lead', 'manager', 'agent'];
            if (!in_array($role->name, $protectedRoles)) {
                $role->update(['name' => $validated['name']]);
            }
            
            if (isset($validated['permissions'])) {
                $role->syncPermissions($validated['permissions']);
            }
            
            DB::commit();
            
            return redirect()
                ->route('roles.index')
                ->with('success', 'Role updated successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update role');
        }
    }

    public function destroy(Role $role)
    {
        $user = auth()->user();
        if (!$user->can('manage_roles') && !$user->hasRole('super-admin') && !$user->hasRole('admin')) {
            abort(403, 'This action is unauthorized.');
        }

        // Protected roles that cannot be deleted
        $protectedRoles = ['super-admin', 'team-lead', 'manager', 'agent'];
        if (in_array($role->name, $protectedRoles)) {
            return back()->with('error', 'Cannot delete this protected role.');
        }

        // Prevent deleting roles assigned to users
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Cannot delete role assigned to users.');
        }

        try {
            $role->delete();
            
            return redirect()
                ->route('roles.index')
                ->with('success', 'Role deleted successfully');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete role');
        }
    }
}
