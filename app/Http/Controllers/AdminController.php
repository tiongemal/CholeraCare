<?php

namespace App\Http\Controllers;

use App\Models\CaseReport;
use App\Models\Location;
use App\Models\SyncLog;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    //

    public function dashboardchart()
    {
        // Dummy data for charts
        $data = [
            'users' => 150,
            'sales' => 120,
            'revenue' => 3000,
            'growth' => 12
        ];

        return view('ad', compact('data'));
    }

    public function index()
{
    // Fetch all users from the database and sort them alphabetically by fullname
    $users = User::paginate(8);

    // Return the view with the list of users
    return view('dashboards.admin_users_dash', compact('users')); // Ensure 'users' is passed
}


    // Toggle the user's status (active/inactive)
    public function toggleStatus(Request $request, $id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Toggle the status
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        // Return a success message (you might want to use session flash messages instead)
        return redirect()->back()->with('success', 'User status updated successfully.');
    }


    public function dashboard()
    {
        // Count all users
        $userCount = User::count();

        $syncLogs = SyncLog::paginate(6);

        // Count all reports
        $reportCount = CaseReport::count();

        // Count all data syncs
        $syncCount = SyncLog::count();

        $reports = CaseReport::paginate(5);

        // Get all active users
        $activeUsers = User::where('status', true)->paginate(5);
                // Fetch locations alphabetically with pagination (10 items per page)
        $locations = Location::orderBy('location_name', 'asc')->paginate(6);

        return view('dashboards.admin_dash', compact('userCount', 'reportCount', 'syncCount', 'activeUsers', 'reports', 'locations', 'syncLogs'));
    }



}
