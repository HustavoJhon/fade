<?php

namespace App\Policies;

use App\Models\User;

class BarberPolicy
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
        return $user?->role === 'admin';
    }

    public function update(?User $user): bool
    {
        return $user?->role === 'admin';
    }

    public function delete(?User $user): bool
    {
        return $user?->role === 'admin';
    }
}
