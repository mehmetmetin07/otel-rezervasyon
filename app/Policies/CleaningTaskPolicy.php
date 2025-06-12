<?php

namespace App\Policies;

use App\Models\CleaningTask;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CleaningTaskPolicy
{
    /**
     * Admin kullanıcıları için tüm işlemlere izin ver
     */
    public function before(User $user, $ability)
    {
        // Sadece admin kullanıcıları için tüm işlemlere izin ver
        if ($user->isAdmin()) {
            return true;
        }
        
        // Diğer kullanıcılar için politika kontrolleri devam etsin
        return null;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Tüm kullanıcılar temizlik görevlerini görebilir
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CleaningTask $cleaningTask): bool
    {
        // Tüm kullanıcılar temizlik görevlerini görebilir
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Sadece admin ve resepsiyonist temizlik görevi oluşturabilir
        return $user->isAdmin() || $user->isReceptionist();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CleaningTask $cleaningTask): bool
    {
        // Tüm kullanıcılar temizlik görevlerini güncelleyebilir
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CleaningTask $cleaningTask): bool
    {
        // Tüm kullanıcılar temizlik görevlerini silebilir
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CleaningTask $cleaningTask): bool
    {
        // Sadece admin temizlik görevlerini geri yükleyebilir
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CleaningTask $cleaningTask): bool
    {
        // Sadece admin temizlik görevlerini kalıcı olarak silebilir
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can mark a task as completed
     */
    public function complete(User $user, CleaningTask $cleaningTask): bool
    {
        // Tüm kullanıcılar temizlik görevlerini tamamlayabilir
        return true;
    }

    /**
     * Determine whether the user can cancel a task
     */
    public function cancel(User $user, CleaningTask $cleaningTask): bool
    {
        // Tüm kullanıcılar görevleri iptal edebilir
        return true;
    }

    /**
     * Determine whether the user can assign a task
     */
    public function assign(User $user, CleaningTask $cleaningTask): bool
    {
        // Sadece admin ve resepsiyonist görevleri atayabilir
        return $user->isAdmin() || $user->isReceptionist();
    }
}
