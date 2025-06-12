<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RoomPolicy
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
        // Tüm kullanıcılar odaları görebilir
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Room $room): bool
    {
        // Tüm kullanıcılar odaları görebilir
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Sadece admin ve resepsiyonist oda oluşturabilir
        return $user->isAdmin() || $user->isReceptionist();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Room $room): bool
    {
        // Sadece admin ve resepsiyonist odaları güncelleyebilir
        return $user->isAdmin() || $user->isReceptionist();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Room $room): bool
    {
        // Sadece admin odaları silebilir
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Room $room): bool
    {
        // Sadece admin odaları geri yükleyebilir
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Room $room): bool
    {
        // Sadece admin odaları kalıcı olarak silebilir
        return $user->isAdmin();
    }
}
