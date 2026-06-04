<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
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

    public function view(?User $user, Review $review): bool
    {
        return true;
    }

    public function create(?User $user): bool
    {
        return $user !== null && $user->role === 'customer';
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
