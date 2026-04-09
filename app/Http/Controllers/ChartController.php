<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use App\Models\CaseReport;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{


    public function charts()
{
    // Confirmed Cases by Month from CaseReport
    $confirmedCasesByMonth = CaseReport::select(DB::raw('MONTH(reported_at) as month'), DB::raw('COUNT(case_id) as total_cases'))
        ->where('case_status', 'confirmed')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // Scaling factor
    $scalingFactor = 5; // Set the scaling factor to match y-axis increments

    $confirmedCasesByMonthData = [
        'labels' => $confirmedCasesByMonth->pluck('month')->map(function($month) {
            return date("F", mktime(0, 0, 0, $month, 1)); // Convert month number to month name
        }),
        // Scale the total_cases by the scaling factor
        'data' => $confirmedCasesByMonth->pluck('total_cases')->map(function($total) use ($scalingFactor) {
            return ceil($total / $scalingFactor) * $scalingFactor; // Scale to nearest increment of the scaling factor
        }),
    ];

    // Cases by Location using DailyReport
    $casesByLocation = DailyReport::select('location_id', DB::raw('COUNT(report_id) as total_cases'))
        ->groupBy('location_id')
        ->with('location') // Include related location data
        ->get();

    $casesByLocationData = [
        'labels' => $casesByLocation->pluck('location.location_id'), // Assuming 'location_name' is the field in the Location model
        'data' => $casesByLocation->pluck('total_cases'),
    ];

    // Suspected vs Confirmed Cases from CaseReport
    $suspectedVsConfirmedCases = CaseReport::select('case_status', DB::raw('COUNT(case_id) as total_cases'))
        ->groupBy('case_status')
        ->get();

    $suspectedVsConfirmedCasesData = [
        'labels' => $suspectedVsConfirmedCases->pluck('case_status'),
        'data' => $suspectedVsConfirmedCases->pluck('total_cases'),
    ];

    // Cases Over Time from DailyReport
    $casesOverTime = DailyReport::select(DB::raw('DATE(report_date) as date'), DB::raw('COUNT(report_id) as total_cases'))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    $casesOverTimeData = [
        'labels' => $casesOverTime->pluck('date'),
        'data' => $casesOverTime->pluck('total_cases'),
    ];

    // Confirmed Cases by Gender from CaseReport
    $casesByGender = CaseReport::select('patient_gender', DB::raw('COUNT(case_id) as total_cases'))
        ->where('case_status', 'confirmed')
        ->groupBy('patient_gender')
        ->get();

    $casesByGenderData = [
        'labels' => $casesByGender->pluck('patient_gender'), // Assuming 'gender' is the field for gender in the CaseReport model
        'data' => $casesByGender->pluck('total_cases'),
    ];

    // Confirmed Cases by Age from CaseReport
    $casesByAge = CaseReport::select(DB::raw('FLOOR(patient_age / 10) * 10 as age_group'), DB::raw('COUNT(case_id) as total_cases'))
        ->where('case_status', 'confirmed')
        ->groupBy('age_group')
        ->orderBy('age_group')
        ->get();

    $casesByAgeData = [
        'labels' => $casesByAge->pluck('age_group')->map(function($ageGroup) {
            return $ageGroup . ' - ' . ($ageGroup + 9); // Display age groups like "0 - 9", "10 - 19"
        }),
        'data' => $casesByAge->pluck('total_cases'),
    ];

    // Total Cases from CaseReport
    $totalCases = CaseReport::count();

    return view('dashboard.charts', compact(
        'confirmedCasesByMonthData',
        'casesByLocationData',
        'suspectedVsConfirmedCasesData',
        'casesOverTimeData',
        'casesByGenderData',  // New data for gender chart
        'casesByAgeData',     // New data for age chart
        'totalCases'
    ));
}


    public function barChart()
    {
        // Retrieve cholera report data: confirmed cases, grouped by month from CaseReport
        $choleraData = CaseReport::selectRaw('MONTH(reported_at) as month, SUM(patient_age) as total_cases')
                    ->where('case_status', 'confirmed')
                    ->groupByRaw('MONTH(reported_at)')
                    ->pluck('total_cases', 'month');

        // Prepare chart labels (months) and data
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $labels = [];
        $data = [];

        // Loop over all months and populate chart data
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = $months[$i - 1];
            $data[] = $choleraData->get($i, 0);  // Get cases for the month, or 0 if no cases
        }

        // Pass the data to the view
        return view('chart', compact('labels', 'data'));
    }
}
