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
        Schema::create('room_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('request_content'); // İstek içeriği
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending'); // Durum: bekliyor, işlemde, tamamlandı
            $table->text('notes')->nullable(); // Notlar
            $table->timestamp('completed_at')->nullable(); // Tamamlanma tarihi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_requests');
    }
};
