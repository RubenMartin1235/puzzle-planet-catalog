<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Planet;
use App\Models\Block;

class PlanetController extends Controller
{
    public function index()
    {
        $planets = Planet::all();
        return view('planets.index',compact('planets'));
    }
}
