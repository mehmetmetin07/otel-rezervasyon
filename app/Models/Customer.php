<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * Doldurulabilir alanlar
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'id_number',
        'address',
        'notes'
    ];

    /**
     * Tarih alanlarını cast et
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Müşteriye ait rezervasyonlar
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Müşterinin tam adı
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Daha önce konaklama yapıp yapmadığını kontrol et
     */
    public function hasPreviousStay(): bool
    {
        return $this->reservations()->where('status', 'checked_out')->exists();
    }

    /**
     * Aktif bir rezervasyonu olup olmadığını kontrol et
     */
    public function hasActiveReservation(): bool
    {
        return $this->reservations()
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->exists();
    }
}
