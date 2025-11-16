<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any leads.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view leads');
    }

    /**
     * Determine whether the user can view a specific lead.
     */
    public function view(User $user, Lead $lead): bool
    {
        if ($user->can('view leads')) {
            return true;
        }

        return $lead->assigned_user_id === $user->id;
    }

    /**
     * Determine whether the user can create leads.
     */
    public function create(User $user): bool
    {
        return $user->can('create leads');
    }

    /**
     * Determine whether the user can update the lead.
     */
    public function update(User $user, Lead $lead): bool
    {
        // Allow if user has explicit permission or is assigned as lead agent
        if ($user->can('edit leads')) {
            return true;
        }

        // Fallback: allow assigned user to update
        if ($lead->assigned_user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the lead.
     */
    public function delete(User $user, Lead $lead): bool
    {
        return $user->can('delete leads');
    }
}

