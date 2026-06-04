<?php

namespace App\Policies;

use App\Models\User;

class ServicePolicy
{
    public function before(?User $user, string $ability): ?bool
    {
        if ($user && $user->role === 'admin') {
            return true;
        }

        return null;
    }

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user): bool
    {
        return true;
    }

    public function create(?User $user): bool
    {
        return false;
    }

    public function update(?User $user): bool
    {
        return false;
    }

    public function delete(?User $user): bool
    {
        return false;
    }
}
