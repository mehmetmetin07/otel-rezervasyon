<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cron_job_settings', function (Blueprint $table) {
            $table->id();
            $table->string('api_key')->nullable()->comment('cron-job.org API anahtarı');
            $table->string('api_email')->nullable()->comment('cron-job.org hesap email\'i');
            $table->boolean('auto_checkout_enabled')->default(false)->comment('Otomatik checkout aktif mi');
            $table->string('checkout_time')->default('11:00')->comment('Checkout zamanı (HH:MM)');
            $table->integer('cron_job_id')->nullable()->comment('cron-job.org\'daki job ID\'si');
            $table->string('webhook_url')->nullable()->comment('Otomatik oluşturulan webhook URL\'si');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_run_at')->nullable()->comment('Son çalıştırıldığı zaman');
            $table->json('settings')->nullable()->comment('Ek ayarlar JSON formatında');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cron_job_settings');
    }
};
