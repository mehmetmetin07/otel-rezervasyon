<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomRequest extends Model
{
    use HasFactory;

    /**
     * Doldurulabilir alanlar
     */
    protected $fillable = [
        'room_id',
        'user_id',
        'request_content',
        'status',
        'notes',
        'completed_at'
    ];

    /**
     * Tarih alanlarını cast et
     */
    protected $casts = [
        'completed_at' => 'datetime',
    ];

    /**
     * İsteğin ait olduğu oda
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * İsteği oluşturan kullanıcı
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * İsteği tamamlandı olarak işaretle
     */
    public function complete(): bool
    {
        $this->status = 'completed';
        $this->completed_at = now();
        return $this->save();
    }

    /**
     * İsteği işlemde olarak işaretle
     */
    public function markInProgress(): bool
    {
        $this->status = 'in_progress';
        return $this->save();
    }

    /**
     * Durum güncelleme
     */
    public function updateStatus(string $status): bool
    {
        if ($status === 'completed') {
            return $this->complete();
        }

        $this->status = $status;
        return $this->save();
    }
}
