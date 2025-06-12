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
        Schema::table('hotel_settings', function (Blueprint $table) {
            $table->boolean('auto_send_welcome_email')->default(false)->after('address');
            $table->boolean('auto_send_goodbye_email')->default(false)->after('auto_send_welcome_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotel_settings', function (Blueprint $table) {
            $table->dropColumn(['auto_send_welcome_email', 'auto_send_goodbye_email']);
        });
    }
};
