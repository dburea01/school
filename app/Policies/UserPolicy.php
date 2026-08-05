<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $userConnected): bool
    {
        return $userConnected->isAdmin() || $userConnected->isDirector() || $userConnected->isTeacher();
    }

    public function view(User $userConnected, User $user): bool
    {
        return $userConnected->isAdmin() || $userConnected->isDirector() || $userConnected->isTeacher()
        || $userConnected->id == $user->id;
    }

    public function create(User $userConnected): bool
    {
        return $userConnected->isAdmin() || $userConnected->isDirector();
    }

    public function update(User $userConnected, User $user): bool
    {
        return $userConnected->isAdmin() || $userConnected->isDirector();
    }

    public function delete(User $userConnected, User $user): bool
    {
        return $userConnected->isAdmin() || $userConnected->isDirector();
    }
}
