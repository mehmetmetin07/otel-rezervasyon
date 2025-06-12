<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Kullanıcının rolü
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Bu kullanıcının oluşturduğu rezervasyonlar
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Bu kullanıcının temizlik görevleri
     */
    public function cleaningTasks(): HasMany
    {
        return $this->hasMany(CleaningTask::class);
    }

    /**
     * Kullanıcının admin olup olmadığını kontrol eder
     */
    public function isAdmin(): bool
    {
        // Eğer role_id yoksa veya null ise
        if (!$this->role_id) {
            return false;
        }

        // Eğer role bir string ise
        if (is_string($this->role)) {
            return $this->role === 'Admin';
        }

        // Eğer role bir ilişki ise
        if ($this->role) {
            return $this->role->name === 'Admin';
        }

        return false;
    }

    /**
     * Kullanıcının resepsiyonist olup olmadığını kontrol eder
     */
    public function isReceptionist(): bool
    {
        // Eğer role_id yoksa veya null ise
        if (!$this->role_id) {
            return false;
        }

        // Eğer role bir string ise
        if (is_string($this->role)) {
            return $this->role === 'Receptionist';
        }

        // Eğer role bir ilişki ise
        if ($this->role) {
            return $this->role->name === 'Receptionist';
        }

        return false;
    }

    /**
     * Kullanıcının temizlik görevlisi olup olmadığını kontrol eder
     */
    public function isCleaner(): bool
    {
        // Eğer role_id yoksa veya null ise
        if (!$this->role_id) {
            return false;
        }

        // Eğer role bir string ise
        if (is_string($this->role)) {
            return $this->role === 'Cleaner';
        }

        // Eğer role bir ilişki ise
        if ($this->role) {
            return $this->role->name === 'Cleaner';
        }

        return false;
    }

    /**
     * Kullanıcının belirli bir role sahip olup olmadığını kontrol eder
     */
    public function hasRole(string $roleName): bool
    {
        if (!$this->role_id || !$this->role) {
            return false;
        }

        return $this->role->name === $roleName;
    }

    /**
     * Kullanıcının belirli rollerden birine sahip olup olmadığını kontrol eder
     */
    public function hasAnyRole(array $roles): bool
    {
        if (!$this->role_id || !$this->role) {
            return false;
        }

        return in_array($this->role->name, $roles);
    }

    /**
     * Kullanıcının yönetici yetkisi olup olmadığını kontrol eder (Admin veya Receptionist)
     */
    public function canManage(): bool
    {
        return $this->hasAnyRole(['Admin', 'Receptionist']);
    }
}
