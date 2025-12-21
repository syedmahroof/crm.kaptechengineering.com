<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Builder;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuilderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_builders');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Builder $builder): bool
    {
        return $user->can('view_builders');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_builders');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Builder $builder): bool
    {
        return $user->can('edit_builders');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Builder $builder): bool
    {
        return $user->can('delete_builders');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Builder $builder): bool
    {
        return $user->can('restore_builders');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Builder $builder): bool
    {
        return $user->can('force_delete_builders');
    }
}
