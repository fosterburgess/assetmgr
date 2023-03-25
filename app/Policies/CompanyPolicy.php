<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the company can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list companies');
    }

    /**
     * Determine whether the company can view the model.
     */
    public function view(User $user, Company $model): bool
    {
        return $user->hasPermissionTo('view companies');
    }

    /**
     * Determine whether the company can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create companies');
    }

    /**
     * Determine whether the company can update the model.
     */
    public function update(User $user, Company $model): bool
    {
        return $user->hasPermissionTo('update companies');
    }

    /**
     * Determine whether the company can delete the model.
     */
    public function delete(User $user, Company $model): bool
    {
        return $user->hasPermissionTo('delete companies');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete companies');
    }

    /**
     * Determine whether the company can restore the model.
     */
    public function restore(User $user, Company $model): bool
    {
        return false;
    }

    /**
     * Determine whether the company can permanently delete the model.
     */
    public function forceDelete(User $user, Company $model): bool
    {
        return false;
    }
}
