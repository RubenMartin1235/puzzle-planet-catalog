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
        $planets = Planet::paginate(15);
        return view('planets.index',compact('planets'));
    }
    public function show(Request $request, Planet $planet)
    {
        $blocks = $planet->blocks;
        //dd($blocks);
        return view('planets.show',[
            'pl' => $planet,
            'blocks' => $blocks
        ]);
    }
    public function create(Request $request)
    {
        $allblocks = Block::all();
        return view('planets.create',[
            'pl' => Planet::find(1),
            'allblocks' => $allblocks,
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:24',
            'bio' => 'required|string|max:128',
            'description' => 'required|string|max:1000',
        ]);
        $planet = $request->user()->planets()->make($validated);
        $planet->save();
        for ($i=1; ($i < 10)&&($bl_name = $request->input("block-$i-type")); $i++) {
            $bl = Block::where('name',$bl_name)->first();
            $bl_rate = $request->input("block-$i-rate");
            $planet->blocks()->attach($bl, ['rate'=>$bl_rate]);
        }
        return redirect(route('planets.index'));
    }
}
