<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class UserController extends Controller
{
        public function RegisterPage(){
            // Get all locations from the database
            $locations = Location::all();

            // Return the registration form view and pass locations
            return view('auth.register', compact('locations'));
        }

    public function register(Request $request){
        $data = $request->validate([
            'fullname' => ['required', 'min:3', 'max:20', Rule::unique('users', 'fullname')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'in:field_staff,hq_staff'],
            'location_id' => ['required', 'exists:location,location_id'] // Add validation for location
        ]);

        // Hash the password
        $data['password'] = bcrypt($data['password']);

        // Create the user
        User::create($data);

        // Redirect after successful registration
        return redirect('/register')->with('success', 'Registered Successfully');
    }

    public function showSessionData()
{
    // Retrieve the user data array from the session
    $userData = session('user');

    // Check if the user data exists in the session
    if ($userData) {
        // Extract specific user details from the userData array
        $username = $userData['fullname']; // or use 'username' if that exists
        $email = $userData['email'];
        $location_id = $userData['location_id'];

        // Retrieve the location details from the Location model
        $location = Location::find($location_id);

        // Pass the data to the view
        return view('session', compact('username', 'email', 'location'));
    } else {
        // If no user data is found in the session, redirect to login or show an error
        return redirect('loginpage')->with('error', 'No session data available.');
    }
}




public function search(Request $request)
{
    $query = $request->input('search');
    $users = User::where('fullname', 'like', "%$query%")
                ->orWhere('email', 'like', "%$query%")
                ->paginate(6);

    // Return the partial view for AJAX requests
    if ($request->ajax()) {
        return view('admin.users.table', compact('users'))->render();
    }

    // For non-AJAX requests, return the full view
    return view('dashboards.admin_users_dash', compact('users'));
}




    public function login(Request $request)
{
    // Validate the incoming data
    $incomingdata = $request->validate([
        'email' => 'required|email', // Add email validation
        'password' => 'required'
    ]);

    // Attempt to authenticate the user
    if (auth()->attempt(['email' => $incomingdata['email'], 'password' => $incomingdata['password']])) {
        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        // Retrieve the authenticated user
        $user = auth()->user();

        // Manually create an array of user data to store in the session
        $userData = [
            'user_id' => $user->user_id,
            'fullname' => $user->fullname,
            'email' => $user->email,
            'role' => $user->role,
            'location_id' => $user->location_id,
            'status' => $user->status,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ];

        // Store the array in the session
        $request->session()->put('user', $userData);

        // Store specific attributes if needed (optional)
        $request->session()->put('location_id', $user->location_id);

        // Redirect to home page with a success message
        return redirect('home')->with('success', 'Login was successful');
    } else {
        // Redirect back to login page with a failure message
        return redirect('loginpage')->with('failed', 'Invalid user details');
    }
}


    public function logout(){
        auth()->logout();

        return redirect()->route('loginpage')->with('success', 'Logout successfull');

    }



    public function loggedin(){
        if(auth()->check()){
            return redirect('home');
        }else{
            return redirect('loginpage');
        }
    }


    public function profile(){
        $user = auth()->user(); // Get the logged-in user's data
        if ($user){
            if ($user['role'] === 'admin'){
                return redirect('/admindash', compact('user'));

            } elseif($user['role'] === 'hq_staff'){
                return redirect('/hqdash');
            } elseif($user['role'] === 'field_staff'){
                return view('dashboards.field_dash', compact('user'));
            }


            // return view('profile', compact('user'));
        }  else{
            return redirect()->route('login'); // Redirect to login if not authenticated
        }

    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status; // Toggle the status
        $user->save();

        return redirect()->route('dashboards.admin_dash')->with('success', 'User status updated successfully.');
    }

    public function index()
    {
        $users = User::all();


        return view('dashboards.admin_dash', compact('users', 'locations'));
    }

    // public function totalUsers(){
    //     $users = User::count();
    //     $reports = Report::count();
    //     return view('dashboards.admin_dash', compact('users', 'reports'));
    // }
}
