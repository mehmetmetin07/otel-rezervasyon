<?php

namespace App\Services;

use App\Models\CronJobSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CronJobService
{
    protected $baseUrl = 'https://api.cron-job.org';
    protected $setting;

    public function __construct()
    {
        $this->setting = CronJobSetting::getOrCreateDefault();
    }

    /**
     * API ile bağlantıyı test et
     */
    public function testConnection(): array
    {
        try {
            // Debug info
            Log::info('Testing connection to cron-job.org API', [
                'url' => $this->baseUrl . '/jobs',
                'api_key_length' => strlen($this->setting->api_key),
                'api_email' => $this->setting->api_email
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->setting->api_key,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/jobs');

            // Debug response
            Log::info('Connection test response:', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'API bağlantısı başarılı',
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => 'API bağlantısı başarısız (Status: ' . $response->status() . '): ' . $response->body(),
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('Connection test exception:', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Bağlantı hatası: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Günlük rezervasyon kontrolü için cron job oluştur (check-in ve check-out)
     */
    public function createDailyReservationJob(): array
    {
        try {
            $webhookUrl = url('/api/cron/daily-check');

            // Günlük kontrol saatini cron formatına çevir
            [$hour, $minute] = explode(':', $this->setting->checkout_time);

            $requestData = [
                'job' => [
                    'url' => $webhookUrl,
                    'title' => 'Günlük Rezervasyon Kontrolü - ' . config('app.name'),
                    'description' => 'Günlük otomatik check-in ve check-out işlemleri',
                    'enabled' => true,
                    'schedule' => [
                        'timezone' => 'Europe/Istanbul',
                        'expiresAt' => 0, // Süresiz
                        'hours' => [(int)$hour],
                        'mdays' => [-1], // Her gün
                        'minutes' => [(int)$minute],
                        'months' => [-1], // Her ay
                        'wdays' => [-1] // Haftanın her günü
                    ],
                    'requestMethod' => 0, // GET
                    'requestTimeout' => 60, // Daha uzun timeout
                    'redirectSuccess' => false,
                    'folderId' => 0,
                    'requestHeaders' => []
                ]
            ];

            // Debug için request data'yı logla
            Log::info('CronJob creation request data:', $requestData);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->setting->api_key,
                'Content-Type' => 'application/json'
            ])->put($this->baseUrl . '/jobs', $requestData);

            // Debug için response'u logla
            Log::info('CronJob creation response:', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $jobData = $response->json();

                // Job ID'sini kaydet
                if (isset($jobData['jobId'])) {
                    $this->setting->update([
                        'cron_job_id' => $jobData['jobId'],
                        'webhook_url' => $webhookUrl,
                        'auto_checkout_enabled' => true,
                        'settings' => json_encode([
                            'job_type' => 'daily_reservation_check',
                            'created_at' => now()->toDateTimeString()
                        ])
                    ]);
                }

                return [
                    'success' => true,
                    'message' => 'Günlük rezervasyon kontrolü cron job\'u başarıyla oluşturuldu',
                    'data' => $jobData
                ];
            }

            return [
                'success' => false,
                'message' => 'Cron job oluşturulamadı (Status: ' . $response->status() . '): ' . $response->body(),
                'status' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('CronJob oluşturma hatası: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Cron job oluşturma hatası: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Otomatik checkout için cron job oluştur (eski metot - geriye uyumluluk için)
     */
    public function createAutoCheckoutJob(): array
    {
        // Yeni günlük kontrol metodunu kullan
        return $this->createDailyReservationJob();
    }

    /**
     * Mevcut cron job'u güncelle
     */
    public function updateDailyReservationJob(): array
    {
        if (!$this->setting->cron_job_id) {
            return $this->createDailyReservationJob();
        }

        try {
            [$hour, $minute] = explode(':', $this->setting->checkout_time);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->setting->api_key,
                'Content-Type' => 'application/json'
            ])->patch($this->baseUrl . '/jobs/' . $this->setting->cron_job_id, [
                'job' => [
                    'enabled' => $this->setting->auto_checkout_enabled,
                    'schedule' => [
                        'timezone' => 'Europe/Istanbul',
                        'hours' => [(int)$hour],
                        'minutes' => [(int)$minute],
                        'mdays' => [-1],
                        'months' => [-1],
                        'wdays' => [-1]
                    ],
                    'requestTimeout' => 60
                ]
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Günlük rezervasyon kontrolü cron job\'u başarıyla güncellendi',
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => 'Cron job güncellenemedi: ' . $response->body()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Güncelleme hatası: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Eski metot - geriye uyumluluk için
     */
    public function updateAutoCheckoutJob(): array
    {
        return $this->updateDailyReservationJob();
    }

    /**
     * Cron job'u sil
     */
    public function deleteAutoCheckoutJob(): array
    {
        if (!$this->setting->cron_job_id) {
            return ['success' => true, 'message' => 'Silinecek cron job bulunamadı'];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->setting->api_key,
                'Content-Type' => 'application/json'
            ])->delete($this->baseUrl . '/jobs/' . $this->setting->cron_job_id);

            if ($response->successful()) {
                $this->setting->update([
                    'cron_job_id' => null,
                    'auto_checkout_enabled' => false,
                    'settings' => null
                ]);

                return [
                    'success' => true,
                    'message' => 'Cron job başarıyla silindi'
                ];
            }

            return [
                'success' => false,
                'message' => 'Cron job silinemedi: ' . $response->body()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Silme hatası: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Tüm cron job'ları listele
     */
    public function listJobs(): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->setting->api_key,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/jobs');

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => 'Job listesi alınamadı: ' . $response->body()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Liste alma hatası: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Belirli bir job'ın detaylarını al
     */
    public function getJobDetails($jobId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->setting->api_key,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/jobs/' . $jobId);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => 'Job detayları alınamadı: ' . $response->body()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Detay alma hatası: ' . $e->getMessage()
            ];
        }
    }
}
