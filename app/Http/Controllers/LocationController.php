<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function create()
    {

        return view('forms.location');
    }

    // Store the new location in the database
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'location_name' => 'required|string|max:255|unique:location,location_name',
            'region' => 'required|string|max:255',
        ]);

        // Create a new location
        Location::create([
            'location_name' => $request->input('location_name'),
            'region' => $request->input('region'),
        ]);

        // Redirect back with success message
        return redirect()->route('locations.create')->with('success', 'Location added successfully.');
    }
}
