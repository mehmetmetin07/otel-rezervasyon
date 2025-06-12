<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HotelSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_name',
        'welcome_description',
        'goodbye_description',
        'hotel_website',
        'phone',
        'email',
        'address',
        'auto_send_welcome_email',
        'auto_send_goodbye_email',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'auto_send_welcome_email' => 'boolean',
        'auto_send_goodbye_email' => 'boolean',
    ];

    /**
     * Aktif hotel ayarlarını getir
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Varsayılan hotel ayarlarını getir veya oluştur
     */
    public static function getOrCreateDefault()
    {
        $setting = static::getActive();

        if (!$setting) {
            $setting = static::create([
                'hotel_name' => config('app.name', 'Otel Rezervasyon'),
                'welcome_description' => 'Otelimiize hoş geldiniz! Konforlu konaklamanız için buradayız.',
                'goodbye_description' => 'Otelimiizden ayrıldığınız için teşekkürler. Tekrar görüşmek üzere!',
                'is_active' => true
            ]);
        }

        return $setting;
    }
}
