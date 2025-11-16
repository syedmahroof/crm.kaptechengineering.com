<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view roles');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        return $user->can('view roles');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create roles');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        // Protected roles that cannot be modified
        $protectedRoles = ['super-admin', 'team-lead', 'manager', 'agent'];
        if (in_array($role->name, $protectedRoles)) {
            return false;
        }
        
        return $user->can('edit roles');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        // Protected roles that cannot be deleted
        $protectedRoles = ['super-admin', 'team-lead', 'manager', 'agent'];
        if (in_array($role->name, $protectedRoles)) {
            return false;
        }
        
        // Prevent deleting roles that are assigned to users
        if ($role->users()->count() > 0) {
            return false;
        }
        
        return $user->can('delete roles');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        return $user->hasRole('super-admin');
    }
}
