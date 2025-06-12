<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temel roller
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Sistem yöneticisi, tüm yetkilere sahip'
            ],
            [
                'name' => 'Receptionist',
                'description' => 'Resepsiyonist, rezervasyon ve müşteri yönetimi yapabilir'
            ],
            [
                'name' => 'Cleaner',
                'description' => 'Temizlik personeli, temizlik görevlerini yönetebilir'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
