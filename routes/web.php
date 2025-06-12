<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CleaningTaskController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomRequestController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\EmailTemplateSettingsController;
use App\Http\Controllers\HotelSettingsController;
use App\Http\Controllers\CronJobSettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Basit bir merhaba dünya sayfası
Route::get('/', function () {
    return '<h1>Merhaba Dünya!</h1><p>Otel Rezervasyon Sistemi çalışıyor.</p>';
});

// Debug route for testing
Route::get('/debug-users', function () {
    $users = \App\Models\User::with('role')->get();
    $roles = \App\Models\Role::all();

    $html = '<h2>Users:</h2>';
    foreach ($users as $user) {
        $html .= '<p>ID: ' . $user->id . ', Email: ' . $user->email . ', Role ID: ' . $user->role_id . ', Role: ' . ($user->role ? $user->role->name : 'null') . '</p>';
    }

    $html .= '<h2>Roles:</h2>';
    foreach ($roles as $role) {
        $html .= '<p>ID: ' . $role->id . ', Name: ' . $role->name . '</p>';
    }

    return $html;
})->name('debug.users');

// Auth gerektiren rotalar
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil sayfaları
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/smtp', [ProfileController::class, 'updateSmtp'])->name('profile.smtp.update')->middleware('admin');
    Route::post('/profile/send-test-email', [ProfileController::class, 'sendTestEmail'])->name('profile.send-test-email')->middleware('admin');

    // Oda Tipleri (Admin ve Resepsiyonist)
    Route::middleware('permission:Admin,Receptionist')->group(function() {
        Route::resource('room-types', RoomTypeController::class);

        // Odalar
        Route::resource('rooms', RoomController::class);
        Route::get('/rooms/calendar', [RoomController::class, 'calendar'])->name('rooms.calendar');
        Route::get('/rooms/calendar/data', [RoomController::class, 'calendarData'])->name('rooms.calendar.data');
        Route::patch('/rooms/{room}/status', [RoomController::class, 'updateStatus'])->name('rooms.update-status');

        // Müşteriler
        Route::resource('customers', CustomerController::class);

        // Rezervasyonlar
        Route::resource('reservations', ReservationController::class);
        Route::patch('/reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
        Route::patch('/reservations/{reservation}/check-in', [ReservationController::class, 'checkIn'])->name('reservations.check-in');
        Route::patch('/reservations/{reservation}/check-out', [ReservationController::class, 'checkOut'])->name('reservations.check-out');
        Route::get('/reservations/{reservation}/invoice', [ReservationController::class, 'generateInvoice'])->name('reservations.invoice');
    });

    // Temizlik Görevleri (Herkese açık - her rol kendi yetkisi dahilinde görebilir)
    Route::resource('cleaning-tasks', CleaningTaskController::class);
    Route::patch('/cleaning-tasks/{cleaningTask}/complete', [CleaningTaskController::class, 'complete'])->name('cleaning-tasks.complete');
    Route::patch('/cleaning-tasks/{cleaningTask}/in-progress', [CleaningTaskController::class, 'inProgress'])->name('cleaning-tasks.in-progress');
    Route::patch('/cleaning-tasks/{cleaningTask}/start', [CleaningTaskController::class, 'inProgress'])->name('cleaning-tasks.start'); // Başlat butonu için alias

    // Temizlik Görevlerini Atama (Sadece Admin ve Resepsiyonist)
    Route::middleware('permission:Admin,Receptionist')->group(function() {
        Route::patch('/cleaning-tasks/{cleaningTask}/assign', [CleaningTaskController::class, 'assign'])->name('cleaning-tasks.assign');
        Route::patch('/cleaning-tasks/{cleaningTask}/verify-room', [CleaningTaskController::class, 'verifyRoom'])->name('cleaning-tasks.verify-room');
    });

    // Oda İstek Listesi (Admin ve Resepsiyonist)
    Route::middleware('permission:Admin,Receptionist')->group(function() {
        Route::resource('room-requests', RoomRequestController::class);
        Route::patch('/room-requests/{roomRequest}/update-status', [RoomRequestController::class, 'updateStatus'])->name('room-requests.update-status');
        Route::get('/rooms/{room}/requests', [RoomRequestController::class, 'roomRequests'])->name('rooms.requests');
    });

    // Raporlar (Admin ve Resepsiyonist)
    Route::middleware('permission:Admin,Receptionist')->group(function() {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/performance', [ReportController::class, 'performance'])->name('reports.performance');
        Route::get('/reports/occupancy', [ReportController::class, 'occupancy'])->name('reports.occupancy');
        Route::get('/reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
        Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
        Route::get('/reports/cleaning', [ReportController::class, 'cleaning'])->name('reports.cleaning');
    });

        // Kullanıcı Yönetimi (Sadece Admin için)
        Route::middleware('role:Admin')->group(function() {
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

        // Aktivite Logları (Sadece Admin için)
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::get('/activity-logs/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
        Route::delete('/activity-logs/{activityLog}', [ActivityLogController::class, 'destroy'])->name('activity-logs.destroy');
        Route::post('/activity-logs/clear', [ActivityLogController::class, 'clear'])->name('activity-logs.clear');

        // Email Template Ayarları (Sadece Admin için)
        Route::get('/email-template-settings', [EmailTemplateSettingsController::class, 'index'])->name('email-template-settings.index');
Route::patch('/email-template-settings', [EmailTemplateSettingsController::class, 'update'])->name('email-template-settings.update');

// Cron Job Settings Routes (Admin only)
Route::get('/cron-job-settings', [CronJobSettingsController::class, 'index'])->name('cron-job-settings.index');
Route::patch('/cron-job-settings', [CronJobSettingsController::class, 'update'])->name('cron-job-settings.update');
Route::post('/cron-job-settings/test-connection', [CronJobSettingsController::class, 'testConnection'])->name('cron-job-settings.test-connection');
Route::post('/cron-job-settings/create-cron-job', [CronJobSettingsController::class, 'createCronJob'])->name('cron-job-settings.create-cron-job');
Route::post('/cron-job-settings/update-cron-job', [CronJobSettingsController::class, 'updateCronJob'])->name('cron-job-settings.update-cron-job');
Route::delete('/cron-job-settings/delete-cron-job', [CronJobSettingsController::class, 'deleteCronJob'])->name('cron-job-settings.delete-cron-job');
Route::get('/cron-job-settings/list-jobs', [CronJobSettingsController::class, 'listJobs'])->name('cron-job-settings.list-jobs');
Route::post('/cron-job-settings/test-daily-check', [CronJobSettingsController::class, 'testDailyCheck'])->name('cron-job-settings.test-daily-check');
// Alias routes for JavaScript functions
Route::post('/cron-job-settings/create-job', [CronJobSettingsController::class, 'createCronJob'])->name('cron-job-settings.create-job');
Route::post('/cron-job-settings/update-job', [CronJobSettingsController::class, 'updateCronJob'])->name('cron-job-settings.update-job');
Route::post('/cron-job-settings/delete-job', [CronJobSettingsController::class, 'deleteCronJob'])->name('cron-job-settings.delete-job');

        // Hotel Ayarları (Sadece Admin için)
        Route::get('/hotel-settings', [HotelSettingsController::class, 'index'])->name('hotel-settings.index');
        Route::patch('/hotel-settings', [HotelSettingsController::class, 'update'])->name('hotel-settings.update');

        // Debug route for cron job creation
        Route::get('/debug-cron-create', function() {
            $service = new \App\Services\CronJobService();
            $result = $service->createDailyReservationJob();
            return response()->json($result);
        })->name('debug.cron.create');
    });
});

// Auth gerektirmeyen rotalar buraya eklenebilir

require __DIR__.'/auth.php';
