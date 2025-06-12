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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action'); // create, update, delete, login, logout, vb.
            $table->string('model_type')->nullable(); // Hangi model üzerinde işlem yapıldı
            $table->unsignedBigInteger('model_id')->nullable(); // Model ID
            $table->text('description')->nullable(); // İşlem açıklaması
            $table->json('old_values')->nullable(); // Eski değerler
            $table->json('new_values')->nullable(); // Yeni değerler
            $table->string('ip_address')->nullable(); // İP adresi
            $table->string('user_agent')->nullable(); // Tarayıcı bilgisi
            $table->timestamps();
            
            // Model tipi ve ID için index
            $table->index(['model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
