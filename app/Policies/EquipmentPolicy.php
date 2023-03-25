<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Equipment;
use Illuminate\Auth\Access\HandlesAuthorization;

class EquipmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the equipment can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list allequipment');
    }

    /**
     * Determine whether the equipment can view the model.
     */
    public function view(User $user, Equipment $model): bool
    {
        return $user->hasPermissionTo('view allequipment');
    }

    /**
     * Determine whether the equipment can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create allequipment');
    }

    /**
     * Determine whether the equipment can update the model.
     */
    public function update(User $user, Equipment $model): bool
    {
        return $user->hasPermissionTo('update allequipment');
    }

    /**
     * Determine whether the equipment can delete the model.
     */
    public function delete(User $user, Equipment $model): bool
    {
        return $user->hasPermissionTo('delete allequipment');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete allequipment');
    }

    /**
     * Determine whether the equipment can restore the model.
     */
    public function restore(User $user, Equipment $model): bool
    {
        return false;
    }

    /**
     * Determine whether the equipment can permanently delete the model.
     */
    public function forceDelete(User $user, Equipment $model): bool
    {
        return false;
    }
}
