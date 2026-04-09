<?php

namespace App\Services;

use App\Models\DailyReport;
use App\Models\CaseReport;
use Illuminate\Support\Facades\Log;

class DataSyncService
{
    public function sync()
    {
        try {
            // Get all daily reports with their associated cases
            $dailyReports = DailyReport::with('cases')->first();

            foreach ($dailyReports as $dailyReport) {
                // Sync case reports with daily reports
                $this->syncCaseReports($dailyReport);
            }

            // Log success
            Log::info('Data synchronization between DailyReport and CaseReport completed successfully.');
            return ['success' => true, 'message' => 'Synchronization completed successfully.'];
        } catch (\Exception $e) {
            // Log any errors that occur during sync
            Log::error('Error during data synchronization: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Synchronization failed.', 'error' => $e->getMessage()];
        }
    }

    private function syncCaseReports(DailyReport $dailyReport)
    {
        // Iterate over the case reports associated with the daily report
        foreach ($dailyReport->cases as $case) {
            $this->updateOrCreateCaseReport($case, $dailyReport);
        }
    }

    private function updateOrCreateCaseReport(CaseReport $case, DailyReport $dailyReport)
    {
        CaseReport::updateOrCreate(
            [
                'case_id' => $case->case_id, // Use the case_id as a unique identifier
            ],
            [
                'case_status' => $case->case_status,
                'patient_age' => $case->patient_age,
                'patient_gender' => $case->patient_gender,
                'supplies_used' => $case->supplies_used,
                'reported_at' => now(), // Set the current time as reported_at
                'report_id' => $dailyReport->report_id, // Associate with the daily report
            ]
        );
    }
}
