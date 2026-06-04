<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
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
        return $user !== null;
    }

    public function view(?User $user, Appointment $appointment): bool
    {
        if (!$user) {
            return false;
        }

        if ($user->role === 'barber') {
            return $appointment->barber_id === $user->barber?->id;
        }

        if ($user->role === 'customer') {
            return $appointment->user_id === $user->id;
        }

        return false;
    }

    public function create(?User $user): bool
    {
        return true;
    }

    public function update(?User $user, Appointment $appointment): bool
    {
        if (!$user) {
            return false;
        }

        if ($user->role === 'barber') {
            return $appointment->barber_id === $user->barber?->id;
        }

        return false;
    }

    public function delete(?User $user): bool
    {
        return false;
    }

    public function cancel(?User $user, Appointment $appointment): bool
    {
        if (!$user) {
            return false;
        }

        if ($user->role === 'customer') {
            return $appointment->user_id === $user->id && $appointment->canBeCancelled();
        }

        return true;
    }
}
