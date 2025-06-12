<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CronJobService;

class TestCronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:test-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test cron job creation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing cron job service...');

        $service = new CronJobService();

        // Debug: Show current settings
        $settings = \App\Models\CronJobSetting::getActive();
        $this->info('Settings found:');
        $this->info('- API Key length: ' . strlen($settings->api_key));
        $this->info('- API Email: ' . $settings->api_email);
        $this->info('- Checkout time: ' . $settings->checkout_time);
        $this->info('- Base URL: https://api.cron-job.org');
        $this->info('- Full URL: https://api.cron-job.org/jobs');

        // Test connection first
        $this->info('1. Testing API connection...');
        $connectionResult = $service->testConnection();

        if ($connectionResult['success']) {
            $this->info('✅ Connection test successful: ' . $connectionResult['message']);
        } else {
            $this->error('❌ Connection test failed: ' . $connectionResult['message']);
            if (isset($connectionResult['status'])) {
                $this->error('Status code: ' . $connectionResult['status']);
            }
            return 1;
        }

        // Test job creation
        $this->info('2. Testing cron job creation...');
        $result = $service->createDailyReservationJob();

        if ($result['success']) {
            $this->info('✅ Job creation successful: ' . $result['message']);
            if (isset($result['data'])) {
                $this->info('Data: ' . json_encode($result['data'], JSON_PRETTY_PRINT));
            }
        } else {
            $this->error('❌ Job creation failed: ' . $result['message']);
            if (isset($result['status'])) {
                $this->error('Status: ' . $result['status']);
            }
        }

        return $result['success'] ? 0 : 1;
    }
}
