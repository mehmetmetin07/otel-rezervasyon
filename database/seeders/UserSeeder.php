<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Rolleri al
        $adminRole = Role::where('name', 'Admin')->first();
        $receptionistRole = Role::where('name', 'Receptionist')->first();
        $cleanerRole = Role::where('name', 'Cleaner')->first();

        // Admin kullanıcısı
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'email_verified_at' => now()
        ]);

        // Resepsiyonist
        User::create([
            'name' => 'Resepsiyonist',
            'email' => 'reception@example.com',
            'password' => Hash::make('password'),
            'role_id' => $receptionistRole->id,
            'email_verified_at' => now()
        ]);

        // Temizlik görevlisi
        User::create([
            'name' => 'Temizlik Görevlisi',
            'email' => 'cleaner@example.com',
            'password' => Hash::make('password'),
            'role_id' => $cleanerRole->id,
            'email_verified_at' => now()
        ]);
    }
}
