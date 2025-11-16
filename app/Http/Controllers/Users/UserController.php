<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);
        
        $users = User::with(['roles', 'permissions', 'branches'])
            ->latest()
            ->paginate(10);
            
        return view('admin.users.index', [
            'users' => $users,
            'roles' => Role::all()->pluck('name')
        ]);
    }

    public function create()
    {
        $this->authorize('create', User::class);
        
        return view('admin.users.form', [
            'roles' => Role::all()->pluck('name'),
            'branches' => Branch::active()->get(['id', 'name', 'code'])
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        
        $branches = $request->has('branches') ? array_map('intval', $request->input('branches', [])) : [];
        $primaryBranch = $request->input('primary_branch');
        
        // Convert empty string to null
        if ($primaryBranch === '' || $primaryBranch === null) {
            $primaryBranch = null;
        } else {
            $primaryBranch = (int)$primaryBranch;
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'sometimes|array',
            'roles.*' => 'string|exists:roles,name',
            'branches' => 'nullable|array',
            'branches.*' => 'integer|exists:branches,id',
            'primary_branch' => [
                'nullable',
                function ($attribute, $value, $fail) use ($branches) {
                    if ($value !== null && $value !== '' && !empty($branches)) {
                        $value = (int)$value;
                        if (!in_array($value, $branches, true)) {
                            $fail('The selected primary branch must be one of the selected branches.');
                        }
                    }
                },
            ],
        ]);

        try {
            DB::beginTransaction();
            
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'email_verified_at' => now(),
            ]);
            
            if (isset($validated['roles'])) {
                $user->syncRoles($validated['roles']);
            }
            
            // Sync user branches
            $branchesToSync = $validated['branches'] ?? [];
            $primaryBranchId = $primaryBranch;
            $user->syncBranches($branchesToSync, $primaryBranchId);
            
            DB::commit();
            
            return redirect()
                ->route('users.index')
                ->with('success', 'User created successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('User creation failed: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return back()->withInput()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        
        $user->load(['roles', 'branches']);
        $primaryBranch = $user->primaryBranch()->first();
        
        return view('admin.users.form', [
            'user' => $user,
            'roles' => Role::all()->pluck('name'),
            'branches' => Branch::active()->get(['id', 'name', 'code']),
            'userBranches' => $user->branches->pluck('id')->toArray(),
            'primaryBranch' => $primaryBranch ? $primaryBranch->id : null
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        
        $branches = $request->has('branches') ? array_map('intval', $request->input('branches', [])) : [];
        $primaryBranch = $request->input('primary_branch');
        
        // Convert empty string to null
        if ($primaryBranch === '' || $primaryBranch === null) {
            $primaryBranch = null;
        } else {
            $primaryBranch = (int)$primaryBranch;
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'sometimes|array',
            'roles.*' => 'string|exists:roles,name',
            'branches' => 'nullable|array',
            'branches.*' => 'integer|exists:branches,id',
            'primary_branch' => [
                'nullable',
                function ($attribute, $value, $fail) use ($branches) {
                    if ($value !== null && $value !== '' && !empty($branches)) {
                        $value = (int)$value;
                        if (!in_array($value, $branches, true)) {
                            $fail('The selected primary branch must be one of the selected branches.');
                        }
                    }
                },
            ],
        ]);

        try {
            DB::beginTransaction();
            
            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];
            
            if (!empty($validated['password'])) {
                $updateData['password'] = bcrypt($validated['password']);
            }
            
            $user->update($updateData);
            
            if (isset($validated['roles'])) {
                $user->syncRoles($validated['roles']);
            }
            
            // Sync user branches
            $branchesToSync = $validated['branches'] ?? [];
            $primaryBranchId = $primaryBranch;
            $user->syncBranches($branchesToSync, $primaryBranchId);
            
            DB::commit();
            
            return redirect()
                ->route('users.index')
                ->with('success', 'User updated successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('User update failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'exception' => $e
            ]);
            return back()->withInput()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        
        // Prevent deleting your own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }
        
        $user->delete();
        
        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully');
    }

}

