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
        Schema::create('email_template_settings', function (Blueprint $table) {
            $table->id();

            // Sosyal Medya Linkleri
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();

            // Website ve Yorum Siteleri
            $table->string('hotel_website_url')->nullable();
            $table->string('review_site_1_url')->nullable();
            $table->string('review_site_1_name')->nullable();
            $table->string('review_site_2_url')->nullable();
            $table->string('review_site_2_name')->nullable();

            // Hoşgeldin mailinde gösterim ayarları
            $table->boolean('show_facebook_welcome')->default(true);
            $table->boolean('show_instagram_welcome')->default(true);
            $table->boolean('show_twitter_welcome')->default(true);
            $table->boolean('show_linkedin_welcome')->default(true);
            $table->boolean('show_youtube_welcome')->default(true);
            $table->boolean('show_website_welcome')->default(true);

            // Hoşçakal mailinde gösterim ayarları
            $table->boolean('show_facebook_goodbye')->default(true);
            $table->boolean('show_instagram_goodbye')->default(true);
            $table->boolean('show_twitter_goodbye')->default(true);
            $table->boolean('show_linkedin_goodbye')->default(true);
            $table->boolean('show_youtube_goodbye')->default(true);
            $table->boolean('show_website_goodbye')->default(true);
            $table->boolean('show_review_site_1_goodbye')->default(true);
            $table->boolean('show_review_site_2_goodbye')->default(true);

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_template_settings');
    }
};
