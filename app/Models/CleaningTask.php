<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CleaningTask extends Model
{
    use HasFactory;

    /**
     * Doldurulabilir alanlar
     */
    protected $fillable = [
        'room_id',
        'user_id',
        'scheduled_at',
        'completed_at',
        'status',
        'notes'
    ];

    /**
     * Tarih alanlarını cast et
     */
    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Göreve ait oda
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Görevi tamamlayan personel
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Görevi tamamlandı olarak işaretle
     */
    public function complete(int $userId): void
    {
        $this->status = 'completed';
        $this->user_id = $userId;
        $this->completed_at = Carbon::now();
        $this->save();

        // Odayı kullanılabilir olarak güncelle
        $this->room->updateStatus('available');
    }

    /**
     * Görevi iptal et
     */
    public function cancel(): void
    {
        $this->status = 'cancelled';
        $this->save();
    }

    /**
     * Görevin beklemede olup olmadığını kontrol et
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Görevin devam etmekte olup olmadığını kontrol et
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Görevin tamamlanmış olup olmadığını kontrol et
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
