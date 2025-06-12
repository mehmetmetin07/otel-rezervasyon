<?php

namespace App\Http\Controllers;

use App\Models\CleaningTask;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Kullanıcı rolüne göre dashboard sayfasını göster
     */
    public function index(): View
    {
        $user = Auth::user();

        // Admin ve resepsiyonist için
        if ($user->isAdmin() || $user->isReceptionist()) {
            // Oda istatistikleri
            $totalRooms = Room::count();
            $availableRooms = Room::where('status', 'available')->count();
            $occupiedRooms = Room::where('status', 'occupied')->count();
            $reservedRooms = Room::where('status', 'reserved')->count();
            $cleaningRooms = Room::where('status', 'cleaning')->count();
            $maintenanceRooms = Room::where('status', 'maintenance')->count();

            // Doluluk oranı
            $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

            // Günlük check-in/check-out
            $today = Carbon::today();
            $checkInsToday = Reservation::whereDate('check_in', $today)
                ->where('status', '!=', 'cancelled')
                ->with(['customer', 'room'])
                ->get();

            $checkOutsToday = Reservation::whereDate('check_out', $today)
                ->where('status', '!=', 'cancelled')
                ->with(['customer', 'room'])
                ->get();

            // Bugünkü temizlik görevleri
            $cleaningTasksToday = CleaningTask::whereDate('scheduled_at', $today)
                ->where('status', '!=', 'cancelled')
                ->with(['room', 'user'])
                ->get();

            // Yaklaşan rezervasyonlar
            $upcomingReservations = Reservation::where('status', 'confirmed')
                ->whereDate('check_in', '>=', now()->toDateString())
                ->whereDate('check_in', '<=', now()->addDays(7)->toDateString())
                ->with(['customer', 'room', 'room.roomType'])
                ->orderBy('check_in')
                ->limit(5)
                ->get();

            return view('dashboard', compact(
                'totalRooms',
                'availableRooms',
                'occupiedRooms',
                'reservedRooms',
                'cleaningRooms',
                'maintenanceRooms',
                'occupancyRate',
                'checkInsToday',
                'checkOutsToday',
                'cleaningTasksToday',
                'upcomingReservations'
            ));
        }

        // Temizlik görevlisi için
        if ($user->isCleaner()) {
            // Kendisine atanmış görevler
            $pendingTasks = CleaningTask::where('user_id', $user->id)
                ->where('status', 'pending')
                ->with('room')
                ->orderBy('scheduled_at')
                ->get();

            // Devam eden görevler
            $inProgressTasks = CleaningTask::where('user_id', $user->id)
                ->where('status', 'in_progress')
                ->with('room')
                ->orderBy('scheduled_at')
                ->get();

            // Bugün tamamladığı görevler
            $completedTasks = CleaningTask::where('user_id', $user->id)
                ->where('status', 'completed')
                ->whereDate('completed_at', now()->toDateString())
                ->with('room')
                ->get();

            return view('dashboard', compact('pendingTasks', 'inProgressTasks', 'completedTasks'));
        }

        // Varsayılan dashboard
        return view('dashboard');
    }
}
