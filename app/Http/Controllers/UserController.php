<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(15);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'nullable|array',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Handle roles - ALWAYS convert to role names (never pass IDs)
        // This ensures we never pass numeric IDs to syncRoles
        $roleNames = [];
        if (isset($validated['roles']) && is_array($validated['roles'])) {
            foreach ($validated['roles'] as $role) {
                // Convert to string first to handle all cases
                $roleValue = (string) $role;
                
                // If it's numeric or looks like an ID, convert to name
                if (is_numeric($role) || ctype_digit($roleValue)) {
                    $roleModel = Role::find((int)$role);
                    if ($roleModel) {
                        $roleNames[] = $roleModel->name;
                    }
                } else {
                    // It's already a name - validate it exists
                    $roleModel = Role::where('name', $role)->first();
                    if ($roleModel) {
                        $roleNames[] = $roleModel->name;
                    }
                }
            }
        }
        
        // Always call syncRoles with an array of role names (never IDs)
        try {
            $user->syncRoles($roleNames);
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            // If we still get this error, log it and try to recover
            \Log::error('Role sync error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'roles_received' => $validated['roles'] ?? [],
                'roles_converted' => $roleNames
            ]);
            throw $e;
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load(['roles', 'leads', 'notes', 'followups']);

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray();

        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'nullable|array',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (isset($validated['password']) && ! empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        // Handle roles - ALWAYS convert to role names (never pass IDs)
        // This ensures we never pass numeric IDs to syncRoles
        $roleNames = [];
        if (isset($validated['roles']) && is_array($validated['roles'])) {
            foreach ($validated['roles'] as $role) {
                // Convert to string first to handle all cases
                $roleValue = (string) $role;
                
                // If it's numeric or looks like an ID, convert to name
                if (is_numeric($role) || ctype_digit($roleValue)) {
                    $roleModel = Role::find((int)$role);
                    if ($roleModel) {
                        $roleNames[] = $roleModel->name;
                    }
                } else {
                    // It's already a name - validate it exists
                    $roleModel = Role::where('name', $role)->first();
                    if ($roleModel) {
                        $roleNames[] = $roleModel->name;
                    }
                }
            }
        }
        
        // Always call syncRoles with an array of role names (never IDs)
        try {
            $user->syncRoles($roleNames);
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            // If we still get this error, log it and try to recover
            \Log::error('Role sync error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'roles_received' => $validated['roles'] ?? [],
                'roles_converted' => $roleNames
            ]);
            throw $e;
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
