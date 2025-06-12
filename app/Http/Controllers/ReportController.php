<?php

namespace App\Http\Controllers;

use App\Models\CleaningTask;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Raporlama ana sayfasını göster
     */
    public function index(): View
    {
        return view('reports.index');
    }
    
    /**
     * Performans analizi sayfası
     */
    public function performance(): View
    {
        // Aylık doluluk oranı - son 30 gün
        $monthlyOccupancy = 75; // Örnek veri
        
        // Aylık gelir hedefi
        $revenueTarget = 82; // Örnek veri
        
        // Müşteri memnuniyeti
        $customerSatisfaction = 88; // Örnek veri
        
        // Temizlik performansı
        $cleaningPerformance = 92; // Örnek veri
        
        return view('reports.performance', compact(
            'monthlyOccupancy',
            'revenueTarget',
            'customerSatisfaction',
            'cleaningPerformance'
        ));
    }

    /**
     * Doluluk raporu
     */
    public function occupancy(Request $request): View
    {
        $start_date = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $end_date = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $start = Carbon::parse($start_date);
        $end = Carbon::parse($end_date);

        $period = CarbonPeriod::create($start, $end);
        $dates = [];
        $occupancyData = [];

        // Tarih aralığındaki her gün için doluluk hesapla
        foreach ($period as $date) {
            $dateStr = $date->format('Y-m-d');
            $dates[] = $date->format('d.m.Y');

            $totalRooms = Room::count();
            $occupiedRooms = Reservation::where('reservations.status', '!=', 'cancelled')
                ->where('reservations.check_in', '<=', $dateStr)
                ->where('reservations.check_out', '>', $dateStr)
                ->count();

            $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;
            $occupancyData[] = $occupancyRate;
        }

        // Özet istatistikler
        $avgOccupancy = count($occupancyData) > 0 ? round(array_sum($occupancyData) / count($occupancyData)) : 0;
        $maxOccupancy = count($occupancyData) > 0 ? max($occupancyData) : 0;
        $minOccupancy = count($occupancyData) > 0 ? min($occupancyData) : 0;

        return view('reports.occupancy', compact(
            'start_date',
            'end_date',
            'dates',
            'occupancyData',
            'avgOccupancy',
            'maxOccupancy',
            'minOccupancy'
        ));
    }

    /**
     * Gelir raporu
     */
    public function revenue(Request $request): View
    {
        $start_date = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $end_date = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $start = Carbon::parse($start_date);
        $end = Carbon::parse($end_date);

        // Oda tiplerine göre gelir dağılımı
        $roomTypeRevenue = Reservation::where('reservations.status', '!=', 'cancelled')
            ->whereDate('reservations.check_in', '>=', $start_date)
            ->whereDate('reservations.check_out', '<=', $end_date)
            ->join('rooms', 'reservations.room_id', '=', 'rooms.id')
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
            ->select('room_types.name', DB::raw('SUM(reservations.total_price) as total_revenue'))
            ->groupBy('room_types.name')
            ->get();

        // Günlük gelir
        $dailyRevenue = Reservation::where('reservations.status', '!=', 'cancelled')
            ->whereDate('reservations.check_in', '>=', $start_date)
            ->whereDate('reservations.check_out', '<=', $end_date)
            ->select(
                DB::raw('DATE(reservations.check_in) as date'),
                DB::raw('SUM(reservations.total_price) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->date => $item->total];
            });

        // Tarih aralığındaki her gün için
        $period = CarbonPeriod::create($start, $end);
        $dates = [];
        $revenueData = [];

        foreach ($period as $date) {
            $dateStr = $date->format('Y-m-d');
            $dates[] = $date->format('d.m.Y');
            $revenueData[] = $dailyRevenue[$dateStr] ?? 0;
        }

        // Toplam gelir
        $totalRevenue = array_sum($revenueData);

        return view('reports.revenue', compact(
            'start_date',
            'end_date',
            'dates',
            'revenueData',
            'totalRevenue',
            'roomTypeRevenue'
        ));
    }

    /**
     * Müşteri istatistikleri
     */
    public function customers(): View
    {
        // Toplam müşteri sayısı
        $totalCustomers = Customer::count();

        // En çok konaklayan müşteriler
        $topCustomers = Customer::withCount('reservations')
            ->orderBy('reservations_count', 'desc')
            ->limit(10)
            ->get();

        // Son 12 ayda kaydolan yeni müşteriler
        $lastYear = now()->subYear();
        $newCustomers = Customer::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', $lastYear)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $months = [];
        $newCustomerData = [];

        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths(11 - $i);
            $months[] = $date->format('M Y');

            $yearMonth = $newCustomers->first(function ($item) use ($date) {
                return $item->year == $date->year && $item->month == $date->month;
            });

            $newCustomerData[] = $yearMonth ? $yearMonth->total : 0;
        }

        return view('reports.customers', compact(
            'totalCustomers',
            'topCustomers',
            'months',
            'newCustomerData'
        ));
    }

    /**
     * Temizlik istatistikleri
     */
    public function cleaning(): View
    {
        // Son 30 gündeki temizlik görevleri
        $last30Days = now()->subDays(30);

        $cleaningStats = CleaningTask::where('created_at', '>=', $last30Days)
            ->select(
                'status',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('status')
            ->get();

        // Personele göre temizlik performansı
        $cleanerPerformance = CleaningTask::where('status', 'completed')
            ->where('created_at', '>=', $last30Days)
            ->whereNotNull('user_id')
            ->select(
                'user_id',
                DB::raw('COUNT(*) as tasks_completed')
            )
            ->with('user:id,name')
            ->groupBy('user_id')
            ->get();

        return view('reports.cleaning', compact('cleaningStats', 'cleanerPerformance'));
    }
}
