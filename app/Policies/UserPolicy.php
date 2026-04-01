<?php

namespace App\Policies;

use App\Models\System\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->role_name == 'root' || $user->role_name == 'admin')
            return true;

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if($user->role_name == 'root')
            return true;

        if ($user->role_name == 'admin' && $user->id==$model->id)
            return true;

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->role_name == 'root' || $user->role_name == 'admin')
            return true;

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {

        if($user->role_name == 'root')
            return true;

        if ($user->role_name == 'admin' && $user->id==$model->id)
            return true;

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if($user->role_name == 'root')
            return true;

        if ($user->role_name == 'admin' && $user->id==$model->id)
            return true;

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        if($user->role_name == 'root')
            return true;

        if ($user->role_name == 'admin' && $user->id==$model->id)
            return true;

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        if($user->role_name == 'root')
            return true;

        if ($user->role_name == 'admin' && $user->id==$model->id)
            return true;

        return false;
    }
}
