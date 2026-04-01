<?php

namespace App\Policies;

use App\Models\System\Language;
use App\Models\System\User;
use Illuminate\Auth\Access\Response;

class LanguagePolicy
{
    private array $allowedRoles = ['root','lang','admin'];
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if (in_array($user->role_name,$this->allowedRoles))
            return true;

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Language $language): bool
    {
        if (in_array($user->role_name,$this->allowedRoles))
            return true;

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if (in_array($user->role_name,$this->allowedRoles))
            return true;

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Language $language): bool
    {
        if (in_array($user->role_name,$this->allowedRoles))
            return true;

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Language $language): bool
    {
        if($user->role_name == 'root' || $user->role_name == 'admin')
            return true;

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Language $language): bool
    {
        if($user->role_name == 'root' || $user->role_name == 'admin')
            return true;

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Language $language): bool
    {
        if($user->role_name == 'root' || $user->role_name == 'admin')
            return true;

        return false;
    }
}
