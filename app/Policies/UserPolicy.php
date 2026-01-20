<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->isAdmin() || $user->isNazza();
    }

    public function delete(User $user): bool
    {
        //
        return $user->isAdmin();
    }
    public function deleteAny(User $user): bool
    {
        //
        return $user->isAdmin();
    }


}
