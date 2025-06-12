<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class MailSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'mail_port' => 'integer',
    ];

    /**
     * Aktif mail ayarlarını getir
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Mail konfigürasyonunu dinamik olarak ayarla
     */
    public function applyToConfig()
    {
        if ($this->is_active) {
            Config::set([
                'mail.default' => $this->mail_mailer,
                'mail.mailers.smtp.host' => $this->mail_host,
                'mail.mailers.smtp.port' => $this->mail_port,
                'mail.mailers.smtp.username' => $this->mail_username,
                'mail.mailers.smtp.password' => $this->mail_password,
                'mail.mailers.smtp.encryption' => $this->mail_encryption,
                'mail.from.address' => $this->mail_from_address,
                'mail.from.name' => $this->mail_from_name,
            ]);
        }
    }

    /**
     * Veritabanındaki aktif ayarları config'e uygula
     */
    public static function loadConfig()
    {
        $settings = static::getActive();
        if ($settings) {
            $settings->applyToConfig();
        }
    }
}
