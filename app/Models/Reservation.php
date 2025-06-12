<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    use HasFactory;

    /**
     * Doldurulabilir alanlar
     */
    protected $fillable = [
        'customer_id',
        'room_id',
        'user_id',
        'check_in',
        'check_out',
        'actual_check_in',
        'actual_check_out',
        'adults',
        'children',
        'total_price',
        'status',
        'is_paid',
        'special_requests',
        'notes'
    ];

    /**
     * Tarih ve para alanlarını cast et
     */
    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'actual_check_in' => 'datetime',
        'actual_check_out' => 'datetime',
        'total_price' => 'decimal:2',
        'is_paid' => 'boolean',
    ];

    /**
     * Rezervasyona ait müşteri
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Rezervasyona ait oda
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Rezervasyonu yapan kullanıcı
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Rezervasyona ait minibar tüketimleri
     */
    public function minibarConsumptions(): HasMany
    {
        return $this->hasMany(MinibarConsumption::class);
    }

    /**
     * Rezervasyona ait çamaşırhane hizmetleri
     */
    public function laundryServices(): HasMany
    {
        return $this->hasMany(LaundryService::class);
    }

    /**
     * Rezervasyona ait siparişler
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Toplam konaklama gün sayısı
     */
    public function getStayDurationAttribute(): int
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    /**
     * Rezervasyon durumunu güncelle
     */
    public function updateStatus(string $status): void
    {
        $this->status = $status;
        $this->save();

        // Oda durumunu da güncelle
        if ($status === 'checked_in') {
            $this->room->updateStatus('occupied');
            $this->actual_check_in = Carbon::now();
        } elseif ($status === 'checked_out') {
            $this->room->updateStatus('cleaning');
            $this->actual_check_out = Carbon::now();

            // Otomatik temizlik görevi oluştur
            CleaningTask::create([
                'room_id' => $this->room_id,
                'scheduled_at' => Carbon::now()->addHour(),
                'status' => 'pending',
                'notes' => 'Check-out sonrası otomatik oluşturulmuş görev'
            ]);
        } elseif ($status === 'cancelled') {
            $this->room->updateStatus('available');
        }
    }

    /**
     * Müşterinin toplam ekstra harcamaları
     */
    public function getTotalExtrasAttribute(): float
    {
        $minibarTotal = $this->minibarConsumptions()->sum('total_price');
        $laundryTotal = $this->laundryServices()->sum('total_price');
        $roomServiceTotal = $this->orders()->sum('total_amount');

        return $minibarTotal + $laundryTotal + $roomServiceTotal;
    }

    /**
     * Rezervasyon için fatura tutarı
     */
    public function getFinalTotalAttribute(): float
    {
        return $this->total_price + $this->getTotalExtrasAttribute();
    }
}
