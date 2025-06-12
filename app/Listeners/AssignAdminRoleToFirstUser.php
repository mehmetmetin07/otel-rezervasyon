<?php

namespace App\Listeners;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class AssignAdminRoleToFirstUser
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        // Kullanıcı sayısını kontrol et
        $userCount = User::count();
        
        // Eğer bu ilk kullanıcı ise
        if ($userCount === 1) {
            $user = $event->user;
            
            // Admin rolünü bul
            $adminRole = Role::where('name', 'Admin')->first();
            
            if ($adminRole) {
                // Kullanıcıya admin rolünü ata
                $user->role_id = $adminRole->id;
                $user->save();
                
                // Aktivite loguna kaydet
                if (class_exists('App\Models\ActivityLog')) {
                    \App\Models\ActivityLog::create([
                        'user_id' => $user->id,
                        'action' => 'İlk kullanıcı olduğu için otomatik olarak Admin rolü atandı',
                        'model_type' => 'User',
                        'model_id' => $user->id,
                    ]);
                }
            }
        }
    }
}
