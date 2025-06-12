<?php

namespace App\Http\Controllers;

use App\Models\CronJobSetting;
use App\Services\CronJobService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CronJobSettingsController extends Controller
{
    protected $cronJobService;

    public function __construct(CronJobService $cronJobService)
    {
        $this->cronJobService = $cronJobService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $settings = CronJobSetting::getOrCreateDefault();
        return view('cron-job-settings.index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'api_key' => 'required|string|max:255',
            'api_email' => 'required|email|max:255',
            'checkout_time' => ['required', 'string', 'regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'auto_checkout_enabled' => 'boolean'
        ]);

        // Mevcut aktif ayarları pasif yap
        CronJobSetting::where('is_active', true)->update(['is_active' => false]);

        // Yeni ayarları oluştur
        $settings = CronJobSetting::create([
            'api_key' => $request->api_key,
            'api_email' => $request->api_email,
            'checkout_time' => $request->checkout_time,
            'auto_checkout_enabled' => $request->has('auto_checkout_enabled'),
            'is_active' => true
        ]);

        // Aktivite logu oluştur
        try {
            $log = new \App\Models\ActivityLog();
            $log->user_id = Auth::id();
            $log->action = 'updated';
            $log->model_type = 'CronJobSetting';
            $log->model_id = $settings->id;
            $log->description = 'Cron job ayarları güncellendi. Günlük kontrol saati: ' . $request->checkout_time;
            $log->ip_address = $request->ip();
            $log->user_agent = $request->userAgent();
            $log->save();
        } catch (\Exception $e) {
            report($e);
        }

        return redirect()->back()->with('success', 'Cron job ayarları başarıyla güncellendi!');
    }

    /**
     * API bağlantısını test et
     */
    public function testConnection(): RedirectResponse
    {
        $result = $this->cronJobService->testConnection();

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Günlük rezervasyon kontrolü cron job'unu oluştur
     */
    public function createCronJob(): RedirectResponse
    {
        $result = $this->cronJobService->createDailyReservationJob();

        if ($result['success']) {
            // Aktivite logu oluştur
            try {
                $log = new \App\Models\ActivityLog();
                $log->user_id = Auth::id();
                $log->action = 'created';
                $log->model_type = 'CronJobSetting';
                $log->model_id = CronJobSetting::getActive()->id ?? null;
                $log->description = 'Günlük rezervasyon kontrolü cron job\'u oluşturuldu (check-in & check-out)';
                $log->ip_address = request()->ip();
                $log->user_agent = request()->userAgent();
                $log->save();
            } catch (\Exception $e) {
                report($e);
            }

            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Cron job'u güncelle
     */
    public function updateCronJob(): RedirectResponse
    {
        $result = $this->cronJobService->updateDailyReservationJob();

        if ($result['success']) {
            // Aktivite logu oluştur
            try {
                $log = new \App\Models\ActivityLog();
                $log->user_id = Auth::id();
                $log->action = 'updated';
                $log->model_type = 'CronJobSetting';
                $log->model_id = CronJobSetting::getActive()->id ?? null;
                $log->description = 'Günlük rezervasyon kontrolü cron job\'u güncellendi';
                $log->ip_address = request()->ip();
                $log->user_agent = request()->userAgent();
                $log->save();
            } catch (\Exception $e) {
                report($e);
            }

            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Cron job'u sil
     */
    public function deleteCronJob(): RedirectResponse
    {
        $result = $this->cronJobService->deleteAutoCheckoutJob();

        if ($result['success']) {
            // Aktivite logu oluştur
            try {
                $log = new \App\Models\ActivityLog();
                $log->user_id = Auth::id();
                $log->action = 'deleted';
                $log->model_type = 'CronJobSetting';
                $log->model_id = CronJobSetting::getActive()->id ?? null;
                $log->description = 'Günlük rezervasyon kontrolü cron job\'u silindi';
                $log->ip_address = request()->ip();
                $log->user_agent = request()->userAgent();
                $log->save();
            } catch (\Exception $e) {
                report($e);
            }

            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Cron job listesi
     */
    public function listJobs(): RedirectResponse
    {
        $result = $this->cronJobService->listJobs();

        if ($result['success']) {
            $jobs = $result['data']['jobs'] ?? [];
            return redirect()->back()->with('success', 'Toplam ' . count($jobs) . ' cron job bulundu.')->with('jobs', $jobs);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Manuel test - günlük rezervasyon kontrolü
     */
    public function testDailyCheck(): RedirectResponse
    {
        try {
            // Test endpoint'ini çağır
            $response = file_get_contents(url('/api/cron/test'));
            $result = json_decode($response, true);

            if ($result && $result['success']) {
                $message = sprintf(
                    'Test tamamlandı! Check-in: %d rezervasyon, Check-out: %d rezervasyon bulundu.',
                    $result['data']['checkin_count'] ?? 0,
                    $result['data']['checkout_count'] ?? 0
                );

                return redirect()->back()->with('success', $message);
            }

            return redirect()->back()->with('error', 'Test başarısız: ' . ($result['message'] ?? 'Bilinmeyen hata'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Test hatası: ' . $e->getMessage());
        }
    }
}
