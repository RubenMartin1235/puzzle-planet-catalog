<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Planet;
use App\Models\Block;

class DashboardController extends Controller
{
    public function index()
    {
        $planets = Auth::user()->planets()->paginate(15);
        return view('dashboard',[
            'planets' => $planets,
        ]);
    }
}
