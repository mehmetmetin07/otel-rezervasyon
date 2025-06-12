<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use HasFactory;

    /**
     * Doldurulabilir alanlar
     */
    protected $fillable = [
        'room_number',
        'room_type_id',
        'description',
        'price_adjustment',
        'status',
        'floor'
    ];

    /**
     * Para alanlarını Decimal olarak cast et
     */
    protected $casts = [
        'price_adjustment' => 'decimal:2',
    ];

    /**
     * Odanın oda tipi
     */
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Odaya ait rezervasyonlar
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Odaya ait temizlik görevleri
     */
    public function cleaningTasks(): HasMany
    {
        return $this->hasMany(CleaningTask::class);
    }

    /**
     * Odanın QR menüsü
     */
    public function qrMenu(): HasOne
    {
        return $this->hasOne(QrMenu::class);
    }
    
    /**
     * Odaya ait istekler
     */
    public function roomRequests(): HasMany
    {
        return $this->hasMany(RoomRequest::class);
    }

    /**
     * Odanın toplam fiyatı (temel fiyat + fiyat ayarlaması)
     */
    public function getTotalPriceAttribute(): float
    {
        return $this->roomType->base_price + $this->price_adjustment;
    }

    /**
     * Odanın durumunu güncelle
     */
    public function updateStatus(string $status): void
    {
        $this->status = $status;
        $this->save();
    }

    /**
     * Odanın müsait olup olmadığını kontrol et
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
