<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\MailSetting;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pagination için Bootstrap 5 stilini kullan
        Paginator::useBootstrapFive();

        // Mail ayarlarını veritabanından yükle
        if (Schema::hasTable('mail_settings')) {
            try {
                MailSetting::loadConfig();
            } catch (\Exception $e) {
                // Veritabanı bağlantısı yoksa ya da tablo boşsa sessizce geç
            }
        }
    }
}
