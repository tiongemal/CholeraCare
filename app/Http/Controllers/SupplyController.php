<?php

namespace App\Http\Controllers;

use App\Models\RestockRequest;
use App\Models\Supply;
use Illuminate\Http\Request;

class SupplyController extends Controller
{

    public function edit($id)
{
    $supply = Supply::findOrFail($id);
    return view('supplies.edit', compact('supply'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'supply_name' => 'required|string|max:255',
        'total_quantity' => 'required|integer|min:0',
    ]);

    $supply = Supply::findOrFail($id);
    $supply->update($request->only('supply_name', 'total_quantity'));

    return redirect()->route('supplies.index')->with('success', 'Supply updated successfully.');
}

    //// Show the form for creating a new supply
    public function create()
    {
        return view('supplies.create');
    }

    // Store a newly created supply in storage
    public function store(Request $request)
    {
        $request->validate([
            'supply_name' => 'required|string|max:255',
            'total_quantity' => 'required|integer|min:0',
        ]);

        Supply::create($request->all());

        return redirect()->route('supplies.index')->with('success', 'Supply added successfully.');
    }

    // Display a listing of the supplies
    public function index()
    {
        $supplies = Supply::paginate(5);
        return view('supplies.index', compact('supplies'));
    }
    public function destroy($id)
{
    $supply = Supply::findOrFail($id);
    $supply->delete();

    return redirect()->route('supplies.index')->with('success', 'Supply removed successfully.');
}

public function RestockRequest(Request $request)
{
    $request->validate([
        'supply_id' => 'required|exists:supplies,supply_id',
    ]);

    $supply = Supply::findOrFail($request->supply_id);
    $quantityLeft = $supply->total_quantity;

    // Get the logged-in user's location
    $locationId = auth()->user()->location_id; // Ensure your User model has a location_id



    RestockRequest::create([
        'supply_id' => $request->supply_id,
        'user_id' => auth()->id(),
        'quantity_left' => $quantityLeft, // Store the quantity left in stock
        'location_id' => $locationId, // Set the location from the user's data
    ]);

    return redirect()->back()->with('success', 'Restock request submitted successfully!');
}

public function RestockRequestNotifications(Request $request)
{
     // Fetch all restock requests
     $restockRequests = RestockRequest::paginate(5);

     return view('restock_requests.index', compact('restockRequests'));
}



}

