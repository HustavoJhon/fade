<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
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
        return $user?->role === 'admin';
    }

    public function view(?User $user, Customer $customer): bool
    {
        if ($user->role === 'customer') {
            return $user->customer?->id === $customer->id;
        }

        return false;
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
