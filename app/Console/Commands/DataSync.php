<?php

namespace App\Console\Commands;

use App\Models\DailyReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Services\DataSyncService;
use Illuminate\Support\Facades\Log;

class DataSync extends Command
{
   /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:data-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data with headquarters server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting data synchronization...');
        $today = now()->toDateString();

        try {
            // Retrieve today's daily report with cases.
            $dailyReport = DailyReport::with('cases')
                ->whereDate('report_date', $today)
                ->first();

            if (!$dailyReport) {
                $this->warn('No daily report found for today.');
                return;
            }

            // Perform synchronization with the server.
            $response = $this->syncWithServer($dailyReport);

            if ($response->successful()) {
                $this->logSync();
                $this->info('Data synchronization completed successfully.');
            } else {
                $this->error('Data synchronization failed: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Error during data synchronization: ' . $e->getMessage());
            $this->error('Error during synchronization: ' . $e->getMessage());
        }
    }

    /**
     * Sync data with the headquarters server.
     *
     * @param DailyReport $dailyReport
     * @return \Illuminate\Http\Client\Response
     */
    private function syncWithServer(DailyReport $dailyReport)
    {
        // Example: Sending HTTP POST request with report data.
        return Http::withOptions(['verify' => false])
        ->post('https://example.com/api/sync', $dailyReport->toArray());
    }

    /**
     * Log the synchronization operation.
     */
    private function logSync()
    {
        Log::info('Data synchronization completed for ' . now()->toDateString());
    }
}


