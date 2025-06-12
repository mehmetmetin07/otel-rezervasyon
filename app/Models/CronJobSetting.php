<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CronJobSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_key',
        'api_email',
        'auto_checkout_enabled',
        'checkout_time',
        'cron_job_id',
        'webhook_url',
        'is_active',
        'last_run_at',
        'settings'
    ];

    protected $casts = [
        'auto_checkout_enabled' => 'boolean',
        'is_active' => 'boolean',
        'last_run_at' => 'datetime',
        'settings' => 'array'
    ];

    /**
     * Aktif cron job ayarlarını getir
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Varsayılan cron job ayarlarını getir veya oluştur
     */
    public static function getOrCreateDefault()
    {
        $setting = static::getActive();

        if (!$setting) {
            $setting = static::create([
                'is_active' => true,
                'checkout_time' => '11:00',
                'auto_checkout_enabled' => false
            ]);
        }

        return $setting;
    }

    /**
     * API key şifrelenmiş mi kontrol et
     */
    public function hasValidApiKey(): bool
    {
        return !empty($this->api_key) && !empty($this->api_email);
    }

    /**
     * Cron job aktif mi
     */
    public function isConfigured(): bool
    {
        return $this->hasValidApiKey() && $this->auto_checkout_enabled;
    }

    /**
     * Webhook URL'sini oluştur
     */
    public function generateWebhookUrl(): string
    {
        return url('/api/cron/auto-checkout');
    }
}
