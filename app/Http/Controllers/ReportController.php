<?php

namespace App\Http\Controllers;

use App\Events\CholeraReportSubmitted;
use App\Models\CaseReport;
use App\Models\Report;
use App\Models\Location;
use App\Models\DailyReport;
use App\Models\Supply;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function test(Request $request){

        $data = $request->all();
        return $data;

    }
    public function view(){
        $supplies = Supply::all();
        return view('report', compact('supplies'));
    }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'location' => 'required|string',
    //         'case_type' => 'required|in:suspected,confirmed',
    //         'num_cases' => 'required|integer',
    //         'treatment_administered' => 'nullable|string',
    //     ]);

    //     // Create a new report with the authenticated user as the creator
    //     DailyReport::create([
    //         'user_id' => auth()->id(),
    //         'location' => $request->input('location'),
    //         'case_type' => $request->input('case_type'),
    //         'num_cases' => $request->input('num_cases'),
    //         'treatment_administered' => $request->input('treatment_administered')
    //     ]);

    //     return redirect()->route('home')->with('success', 'Report created successfully.');
    // }

//     public function store(Request $request)
// {
//     // Validate the incoming request data
//     $request->validate([
//         'case_status' => 'required|in:suspected,confirmed',
//         'patient_age' => 'required|integer|min:0',
//         'patient_gender' => 'required|in:male,female',
//         'reported_at' => 'required|date',
//     ]);

//     $currentDate = now()->toDateString();

//     $dailyReport = DailyReport::where('report_date', $currentDate)
//         ->where('field_worker_id', auth()->id())
//         ->first();

//     $location_id = session('user.location_id');

//     if ($dailyReport) {
//         if ($request->input('case_status') === 'suspected') {
//             $dailyReport->increment('suspected_cases');
//         } elseif ($request->input('case_status') === 'confirmed') {
//             $dailyReport->increment('confirmed_cases');
//         }
//     } else {
//         $dailyReport = DailyReport::create([
//             'field_worker_id' => auth()->id(),
//             'location_id' => $location_id,
//             'report_date' => $currentDate,
//             'suspected_cases' => $request->input('case_status') === 'suspected' ? 1 : 0,
//             'confirmed_cases' => $request->input('case_status') === 'confirmed' ? 1 : 0,
//         ]);
//     }

//     CaseReport::create([
//         'case_status' => $request->input('case_status'),
//         'patient_age' => $request->input('patient_age'),
//         'patient_gender' => $request->input('patient_gender'),
//         'reported_at' => $request->input('reported_at'),
//         'location_id' => $location_id,
//     ]);

//     // Prepare the report data for the event
//     $reportData = [
//         'report_id' => $dailyReport->report_id,
//         'confirmed_cases' => $dailyReport->confirmed_cases,
//         'suspected_cases' => $dailyReport->suspected_cases,
//     ];

//     // Dispatch the event with the correct data type
//     event(new CholeraReportSubmitted($reportData));

//     return redirect()->route('report')->with('success', 'Case report created successfully.');
// }


public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'case_status' => 'required|in:suspected,confirmed',
        'patient_age' => 'required|integer|min:0',
        'patient_gender' => 'required|in:male,female',
        'reported_at' => 'required|date',
    ]);

    $currentDate = now()->toDateString();
    $location_id = session('user.location_id');

    // Retrieve or create a daily report for the current user and date
    $dailyReport = DailyReport::firstOrCreate(
        [
            'report_date' => $currentDate,
            'field_worker_id' => auth()->id(),
        ],
        [
            'location_id' => $location_id,
            'suspected_cases' => 0,
            'confirmed_cases' => 0,
        ]
    );

    // Increment case counts based on the status
    if ($request->input('case_status') === 'suspected') {
        $dailyReport->increment('suspected_cases');
    } else {
        $dailyReport->increment('confirmed_cases');
    }

    // Create a new case report
    CaseReport::create([
        'case_status' => $request->input('case_status'),
        'patient_age' => $request->input('patient_age'),
        'patient_gender' => $request->input('patient_gender'),
        'reported_at' => $request->input('reported_at'),
        'location_id' => $location_id,
    ]);

    // Deduct supplies based on case status
    $this->deductSupplies($request->input('case_status'));

    // Prepare the report data for the event
    $reportData = [
        'report_id' => $dailyReport->report_id,
        'confirmed_cases' => $dailyReport->confirmed_cases,
        'suspected_cases' => $dailyReport->suspected_cases,
    ];

    // Dispatch the event with the report data
    event(new CholeraReportSubmitted($reportData));

    return redirect()->route('report')->with('success', 'Case report created successfully.');
}

/**
 * Deduct supplies based on the reported case status.
 *
 * @param string $caseStatus
 * @return void
 */
private function deductSupplies($caseStatus)
{
    $suppliesNeeded = $this->getSuppliesRequired($caseStatus);

    foreach ($suppliesNeeded as $supplyName => $quantity) {
        $supply = Supply::where('supply_name', $supplyName)->first();

        if ($supply && $supply->total_quantity >= $quantity) {
            $supply->decrement('total_quantity', $quantity);
        } else {
            // Handle case when supply is insufficient (optional: log or notify admin)
            Log::warning("Insufficient $supplyName stock for a $caseStatus case.");
        }
    }
}

/**
 * Get the required supplies and quantities for each case status.
 *
 * @param string $caseStatus
 * @return array
 */
private function getSuppliesRequired($caseStatus)
{
    if ($caseStatus === 'suspected') {
        return [
            'Oral Rehydration Solution(ORS)' => 8,
            'Zinc Supplements' => 2,
            'Soap' => 1,
            'Disinfectants' => 3,
            'Disposable Gloves' => 4,
            'Water Purification Tablets' => 5,
        ];
    } elseif ($caseStatus === 'confirmed') {
        return [
            'IV Fluids' => 5,
            'Antibiotics' => 1,
            'Disposable Gloves' => 4,
            'Medical Gowns' => 1,
            'Face Masks' => 2,
            'Disinfectants' => 3,
        ];
    }

    return [];
}











    // public function reportTable()
    //     {
    //         $reports = DailyReport::with('fieldWorker', 'location', 'cases')->paginate(10);
    //         return view('reportTables', compact('reports'));
    //     }



    public function reportTable(Request $request)
    {
        // Fetch all locations for the filter dropdown (for admins)
        $locations = Location::all();

        // Initialize the query for DailyReports
        $query = DailyReport::query();

        // Apply location filter based on authenticated user's role
        if (auth()->user()->role === 'field_staff') {
            // Automatically filter by the field worker's assigned location
            $query->where('location_id', auth()->user()->location_id);
        } elseif ($request->has('location') && !empty($request->location)) {
            // If admin, allow filtering by location via request
            $query->where('location_id', $request->location);
        }

        // Apply case type filter (suspected or confirmed)
        if ($request->has('case_filter') && !empty($request->case_filter)) {
            if ($request->case_filter == 'suspected') {
                $query->where('suspected_cases', '>', 0);
            } elseif ($request->case_filter == 'confirmed') {
                $query->where('confirmed_cases', '>', 0);
            }
        }

        // Apply date filter if selected
        if ($request->has('report_date') && !empty($request->report_date)) {
            $query->whereDate('report_date', '=', $request->report_date);
        }

        // Apply sorting (default: by report date descending)
        $sortField = $request->get('sort_field', 'report_date');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        // Paginate the results (6 per page)
        $reports = $query->paginate(6);

        // Return the view with the reports and locations
        return view('reportTables', compact('reports', 'locations'));
    }



}
