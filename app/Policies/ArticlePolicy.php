<?php

namespace App\Policies;

use App\Models\Content\Article;
use App\Models\System\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    private array $allowedRoles =[ 'root','admin','editor'] ;
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
    public function view(User $user, Article $article): bool
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
    public function update(User $user, Article $article): bool
    {
        if($user->role_name == 'root')
            return true;

        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        if($user->role_name == 'root')
            return true;

        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Article $article): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Article $article): bool
    {
        if($user->role_name == 'root')
            return true;

        return $user->id === $article->user_id;
    }
}
