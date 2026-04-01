<?php

namespace App\Policies;

use App\Models\System\Settings;
use App\Models\System\User;
use Illuminate\Auth\Access\Response;

class SettingsPolicy
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

    /*

    public function view(User $user, Settings $settings): bool
    {
        //
    }


    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Settings $settings): bool
    {
        //
    }


    public function delete(User $user, Settings $settings): bool
    {
        //
    }


    public function restore(User $user, Settings $settings): bool
    {
        //
    }


    public function forceDelete(User $user, Settings $settings): bool
    {
        //
    }

    */
}
