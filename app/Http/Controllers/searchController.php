<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class searchController extends Controller
{
    public function search(Request $request){
        $data = $request->validate([
            'search' => 'required|string|max:25'
        ]);
        User::all();
    }
}
