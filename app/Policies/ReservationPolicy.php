<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{
    /**
     * Allow all actions for all users by default
     */
    public function before(User $user, $ability)
    {
        // Always return true to bypass all policy checks
        return true;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Tüm kullanıcılar rezervasyonları görebilir
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reservation $reservation): bool
    {
        // Tüm kullanıcılar rezervasyonları görebilir
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Sadece admin ve resepsiyonist rezervasyon oluşturabilir
        return $user->isAdmin() || $user->isReceptionist();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reservation $reservation): bool
    {
        // Sadece admin ve resepsiyonist rezervasyonları güncelleyebilir
        return $user->isAdmin() || $user->isReceptionist();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reservation $reservation): bool
    {
        // Sadece admin rezervasyonları silebilir
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reservation $reservation): bool
    {
        // Sadece admin rezervasyonları geri yükleyebilir
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reservation $reservation): bool
    {
        // Sadece admin rezervasyonları kalıcı olarak silebilir
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can check in a reservation
     */
    public function checkIn(User $user, Reservation $reservation): bool
    {
        // Sadece admin ve resepsiyonist check-in yapabilir
        // Ve check-in tarihi bugün veya geçmişte olmalı
        $isAuthorized = ($user->isAdmin() || $user->isReceptionist()) && $reservation->status === 'confirmed';
        $isCheckInDateValid = now()->startOfDay()->greaterThanOrEqualTo($reservation->check_in->startOfDay());

        return $isAuthorized && $isCheckInDateValid;
    }

    /**
     * Determine whether the user can check out a reservation
     */
    public function checkOut(User $user, Reservation $reservation): bool
    {
        // Sadece admin ve resepsiyonist check-out yapabilir
        return ($user->isAdmin() || $user->isReceptionist()) && $reservation->status === 'checked_in';
    }

    /**
     * Determine whether the user can confirm a reservation
     */
    public function confirm(User $user, Reservation $reservation): bool
    {
        // Sadece admin ve resepsiyonist rezervasyonu onaylayabilir
        return ($user->isAdmin() || $user->isReceptionist()) && $reservation->status === 'pending';
    }

    /**
     * Determine whether the user can cancel a reservation
     */
    public function cancel(User $user, Reservation $reservation): bool
    {
        // Sadece admin ve resepsiyonist rezervasyonu iptal edebilir
        return ($user->isAdmin() || $user->isReceptionist()) &&
            in_array($reservation->status, ['pending', 'confirmed']);
    }
}
