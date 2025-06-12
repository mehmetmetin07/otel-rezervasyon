<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\CronJobSetting;
use App\Mail\GoodbyeCheckout;
use App\Mail\WelcomeCheckin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CronJobController extends Controller
{
    /**
     * Otomatik check-in işlemi
     * Bu endpoint cron-job.org tarafından günlük olarak çağrılacak
     */
    public function autoCheckin(Request $request): JsonResponse
    {
        try {
            $setting = CronJobSetting::getOrCreateDefault();

            // Bugün check-in yapması gereken rezervasyonları bul
            $today = Carbon::today();
            $reservations = Reservation::with(['customer', 'room', 'room.roomType'])
                ->where('check_in', '<=', $today)
                ->where('status', 'confirmed')
                ->get();

            $processedCount = 0;
            $emailsSentCount = 0;
            $errors = [];

            foreach ($reservations as $reservation) {
                try {
                    // Check-in işlemi yap
                    $reservation->updateStatus('checked_in');
                    $processedCount++;

                    // Hoşgeldin e-postası gönder
                    if ($reservation->customer && $reservation->customer->email && config('mail.mailers.smtp.host')) {
                        Mail::to($reservation->customer->email)->send(new WelcomeCheckin($reservation));
                        $emailsSentCount++;
                    }

                    // Aktivite logu oluştur
                    try {
                        $log = new \App\Models\ActivityLog();
                        $log->user_id = null; // Sistem tarafından
                        $log->action = 'auto_checkin';
                        $log->model_type = 'Reservation';
                        $log->model_id = $reservation->id;
                        $log->description = 'Rezervasyon #' . $reservation->id . ' için otomatik check-in yapıldı (CronJob). Müşteri: ' . $reservation->customer->name;
                        $log->ip_address = $request->ip();
                        $log->user_agent = 'CronJob-AutoCheckin';
                        $log->save();
                    } catch (\Exception $e) {
                        Log::error('Auto checkin activity log error: ' . $e->getMessage());
                    }

                } catch (\Exception $e) {
                    $errors[] = "Rezervasyon #{$reservation->id} check-in hatası: " . $e->getMessage();
                    Log::error("Auto checkin error for reservation {$reservation->id}: " . $e->getMessage());
                }
            }

            $response = [
                'success' => true,
                'message' => 'Otomatik check-in işlemi tamamlandı',
                'data' => [
                    'processed_reservations' => $processedCount,
                    'emails_sent' => $emailsSentCount,
                    'total_found' => $reservations->count(),
                    'errors_count' => count($errors),
                    'run_time' => now()->toDateTimeString()
                ]
            ];

            if (!empty($errors)) {
                $response['errors'] = $errors;
            }

            Log::info('Auto checkin completed', $response['data']);

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Auto checkin general error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Otomatik check-in sırasında hata oluştu: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Otomatik checkout işlemi
     * Bu endpoint cron-job.org tarafından günlük olarak çağrılacak
     */
    public function autoCheckout(Request $request): JsonResponse
    {
        try {
            $setting = CronJobSetting::getOrCreateDefault();

            // Son çalışma zamanını güncelle
            $setting->update(['last_run_at' => now()]);

            // Bugün check-out yapması gereken rezervasyonları bul
            $today = Carbon::today();
            $reservations = Reservation::with(['customer', 'room', 'room.roomType'])
                ->whereDate('check_out', '<=', $today)
                ->where('status', 'checked_in')
                ->get();

            $processedCount = 0;
            $emailsSentCount = 0;
            $errors = [];

            foreach ($reservations as $reservation) {
                try {
                    // Checkout işlemi yap
                    $reservation->updateStatus('checked_out');
                    $processedCount++;

                    // Hoşçakal e-postası gönder
                    if ($reservation->customer && $reservation->customer->email && config('mail.mailers.smtp.host')) {
                        Mail::to($reservation->customer->email)->send(new GoodbyeCheckout($reservation));
                        $emailsSentCount++;
                    }

                    // Aktivite logu oluştur
                    try {
                        $log = new \App\Models\ActivityLog();
                        $log->user_id = null; // Sistem tarafından
                        $log->action = 'auto_checkout';
                        $log->model_type = 'Reservation';
                        $log->model_id = $reservation->id;
                        $log->description = 'Rezervasyon #' . $reservation->id . ' için otomatik check-out yapıldı (CronJob). Müşteri: ' . $reservation->customer->name;
                        $log->ip_address = $request->ip();
                        $log->user_agent = 'CronJob-AutoCheckout';
                        $log->save();
                    } catch (\Exception $e) {
                        Log::error('Auto checkout activity log error: ' . $e->getMessage());
                    }

                } catch (\Exception $e) {
                    $errors[] = "Rezervasyon #{$reservation->id} checkout hatası: " . $e->getMessage();
                    Log::error("Auto checkout error for reservation {$reservation->id}: " . $e->getMessage());
                }
            }

            $response = [
                'success' => true,
                'message' => 'Otomatik checkout işlemi tamamlandı',
                'data' => [
                    'processed_reservations' => $processedCount,
                    'emails_sent' => $emailsSentCount,
                    'total_found' => $reservations->count(),
                    'errors_count' => count($errors),
                    'run_time' => now()->toDateTimeString()
                ]
            ];

            if (!empty($errors)) {
                $response['errors'] = $errors;
            }

            Log::info('Auto checkout completed', $response['data']);

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Auto checkout general error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Otomatik checkout sırasında hata oluştu: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Günlük rezervasyon kontrol işlemi (check-in ve check-out)
     * Bu endpoint hem check-in hem check-out işlemlerini birlikte yapar
     */
    public function dailyReservationCheck(Request $request): JsonResponse
    {
        try {
            $setting = CronJobSetting::getOrCreateDefault();
            $setting->update(['last_run_at' => now()]);

            $today = Carbon::today();
            $checkinResults = [];
            $checkoutResults = [];

            // 1. Check-in işlemleri
            $checkinReservations = Reservation::with(['customer', 'room', 'room.roomType'])
                ->whereDate('check_in', '<=', $today)
                ->where('status', 'confirmed')
                ->get();

            foreach ($checkinReservations as $reservation) {
                try {
                    $reservation->updateStatus('checked_in');

                    if ($reservation->customer && $reservation->customer->email && config('mail.mailers.smtp.host')) {
                        Mail::to($reservation->customer->email)->send(new WelcomeCheckin($reservation));
                    }

                    $log = new \App\Models\ActivityLog();
                    $log->user_id = null;
                    $log->action = 'auto_checkin';
                    $log->model_type = 'Reservation';
                    $log->model_id = $reservation->id;
                    $log->description = 'Rezervasyon #' . $reservation->id . ' için otomatik check-in yapıldı (DailyCheck). Müşteri: ' . $reservation->customer->name;
                    $log->ip_address = $request->ip();
                    $log->user_agent = 'CronJob-DailyCheck';
                    $log->save();

                    $checkinResults[] = $reservation->id;
                } catch (\Exception $e) {
                    Log::error("Daily checkin error for reservation {$reservation->id}: " . $e->getMessage());
                }
            }

            // 2. Check-out işlemleri
            $checkoutReservations = Reservation::with(['customer', 'room', 'room.roomType'])
                ->whereDate('check_out', '<=', $today)
                ->where('status', 'checked_in')
                ->get();

            foreach ($checkoutReservations as $reservation) {
                try {
                    $reservation->updateStatus('checked_out');

                    if ($reservation->customer && $reservation->customer->email && config('mail.mailers.smtp.host')) {
                        Mail::to($reservation->customer->email)->send(new GoodbyeCheckout($reservation));
                    }

                    $log = new \App\Models\ActivityLog();
                    $log->user_id = null;
                    $log->action = 'auto_checkout';
                    $log->model_type = 'Reservation';
                    $log->model_id = $reservation->id;
                    $log->description = 'Rezervasyon #' . $reservation->id . ' için otomatik check-out yapıldı (DailyCheck). Müşteri: ' . $reservation->customer->name;
                    $log->ip_address = $request->ip();
                    $log->user_agent = 'CronJob-DailyCheck';
                    $log->save();

                    $checkoutResults[] = $reservation->id;
                } catch (\Exception $e) {
                    Log::error("Daily checkout error for reservation {$reservation->id}: " . $e->getMessage());
                }
            }

            $response = [
                'success' => true,
                'message' => 'Günlük rezervasyon kontrolü tamamlandı',
                'data' => [
                    'checkin_processed' => count($checkinResults),
                    'checkout_processed' => count($checkoutResults),
                    'checkin_total_found' => $checkinReservations->count(),
                    'checkout_total_found' => $checkoutReservations->count(),
                    'checkin_reservations' => $checkinResults,
                    'checkout_reservations' => $checkoutResults,
                    'run_time' => now()->toDateTimeString()
                ]
            ];

            Log::info('Daily reservation check completed', $response['data']);

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Daily reservation check general error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Günlük rezervasyon kontrolü sırasında hata oluştu: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cron job durumunu kontrol et
     */
    public function status(): JsonResponse
    {
        try {
            $setting = CronJobSetting::getOrCreateDefault();
            $today = Carbon::today();

            // Bugün işlem yapılacak rezervasyonları say
            $checkinCount = Reservation::whereDate('check_in', '<=', $today)
                ->where('status', 'confirmed')
                ->count();

            $checkoutCount = Reservation::whereDate('check_out', '<=', $today)
                ->where('status', 'checked_in')
                ->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'auto_checkout_enabled' => $setting->auto_checkout_enabled,
                    'checkout_time' => $setting->checkout_time,
                    'last_run_at' => $setting->last_run_at,
                    'webhook_url' => $setting->webhook_url,
                    'cron_job_id' => $setting->cron_job_id,
                    'is_configured' => $setting->isConfigured(),
                    'pending_checkins' => $checkinCount,
                    'pending_checkouts' => $checkoutCount,
                    'current_time' => now()->toDateTimeString()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Durum bilgisi alınamadı: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test endpoint - Manuel test
     */
    public function testReservationCheck(): JsonResponse
    {
        try {
            $today = Carbon::today();

            $checkinReservations = Reservation::with(['customer', 'room'])
                ->whereDate('check_in', '<=', $today)
                ->where('status', 'confirmed')
                ->get(['id', 'customer_id', 'room_id', 'check_in', 'status']);

            $checkoutReservations = Reservation::with(['customer', 'room'])
                ->whereDate('check_out', '<=', $today)
                ->where('status', 'checked_in')
                ->get(['id', 'customer_id', 'room_id', 'check_out', 'status']);

            return response()->json([
                'success' => true,
                'message' => 'Test completed',
                'data' => [
                    'checkin_reservations' => $checkinReservations,
                    'checkout_reservations' => $checkoutReservations,
                    'checkin_count' => $checkinReservations->count(),
                    'checkout_count' => $checkoutReservations->count(),
                    'test_time' => now()->toDateTimeString(),
                    'today' => $today->toDateString()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Test hatası: ' . $e->getMessage()
            ], 500);
        }
    }
}
