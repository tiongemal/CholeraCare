<?php

namespace App\Http\Controllers;

use App\Models\CaseReport;
use App\Models\DailyReport;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class DataSyncController extends Controller
{

    public function index()
    {
        $syncLogs = SyncLog::with('fieldWorker')->get();
        return view('sync-logs.index', compact('syncLogs'));
    }

    /**
     * Perform synchronization using local storage data (today's data).
     */
    public function sync()
    {
        try {
            // Retrieve today's data from local storage
            $dailyReport = $this->getTodayDailyReport();
            $cases = $this->getTodayCaseReports();

            // Update today's daily report based on the case reports
            $this->updateDailyReport($dailyReport, $cases);

            // Log the synchronization
            $this->logSync();

            Log::info('Synchronization completed successfully using local storage.');
            return redirect('/home')->with('success', 'Synchronization completed successfully.');

        } catch (\Exception $e) {
            Log::error('Error during synchronization: ' . $e->getMessage());
            return redirect('/home')->with('error', 'Synchronization failed: ' . $e->getMessage());
        }
    }

    /**
     * Retrieve today's daily report or create a new one.
     *
     * @return DailyReport
     */
    private function getTodayDailyReport()
    {
        return DailyReport::firstOrCreate(
            ['report_date' => now()->toDateString()],
            ['suspected_cases' => 0, 'confirmed_cases' => 0]
        );
    }

    /**
     * Retrieve all case reports for today from local storage.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getTodayCaseReports()
    {
        return CaseReport::whereDate('reported_at', now()->toDateString())->get();
    }

    /**
     * Update the daily report based on today's case reports.
     *
     * @param DailyReport $dailyReport
     * @param \Illuminate\Database\Eloquent\Collection $cases
     */
    private function updateDailyReport(DailyReport $dailyReport, $cases)
    {
        $suspectedCount = 0;
        $confirmedCount = 0;

        // Count cases based on their type
        foreach ($cases as $case) {
            if ($case->case_status === 'suspected') {
                $suspectedCount++;
            } elseif ($case->case_status === 'confirmed') {
                $confirmedCount++;
            }
        }

        // Update the daily report with the counted values
        $dailyReport->update([
            'suspected_cases' => $suspectedCount,
            'confirmed_cases' => $confirmedCount,
        ]);

        Log::info('Daily report updated with today\'s case totals from local storage.');
    }

    /**
     * Log the synchronization in the SyncLog.
     */
    private function logSync()
    {
        $fieldWorkerId = auth()->id();

        SyncLog::create([
            'field_worker_id' => $fieldWorkerId,
            'last_sync' => now(),
        ]);

        Log::info("Synchronization logged for field worker ID: $fieldWorkerId.");
    }
}
