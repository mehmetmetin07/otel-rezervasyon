<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    use HasFactory;

    /**
     * Doldurulabilir alanlar
     */
    protected $fillable = [
        'name',
        'description',
        'capacity',
        'base_price'
    ];

    /**
     * Para alanlarını Decimal olarak cast et
     */
    protected $casts = [
        'base_price' => 'decimal:2',
    ];

    /**
     * Bu oda tipine ait odalar
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Toplam oda sayısı
     */
    public function getTotalRoomsAttribute(): int
    {
        return $this->rooms()->count();
    }

    /**
     * Müsait oda sayısı
     */
    public function getAvailableRoomsAttribute(): int
    {
        return $this->rooms()->where('status', 'available')->count();
    }
}
