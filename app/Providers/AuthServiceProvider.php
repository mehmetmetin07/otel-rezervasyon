<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\CleaningTask;
use App\Models\Reservation;
use App\Models\Room;
use App\Policies\CleaningTaskPolicy;
use App\Policies\ReservationPolicy;
use App\Policies\RoomPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Reservation::class => ReservationPolicy::class,
        Room::class => RoomPolicy::class,
        CleaningTask::class => CleaningTaskPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
