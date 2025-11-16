<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LeadAgent;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadAgentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view leads');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LeadAgent $leadAgent): bool
    {
        return $user->can('view leads');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('edit leads') || $user->hasRole(['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LeadAgent $leadAgent): bool
    {
        return $user->can('edit leads') || $user->hasRole(['admin', 'super-admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LeadAgent $leadAgent): bool
    {
        return $user->can('delete leads') || $user->hasRole(['admin', 'super-admin']);
    }
}

