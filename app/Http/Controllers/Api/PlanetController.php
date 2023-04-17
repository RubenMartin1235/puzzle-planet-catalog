<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Planet;

class PlanetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $planet = Planet::factory()->create([
            'name' => 'Lastar',
            'user_id' => $request->user()->id,
            'bio' => "The planet of Lastar is full of light, and the light destroys all shadows.",
            'description' => fake()->text(32)
        ]);
        $planet->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $planet = Planet::where('id', $id)->get();
        if (!$planet) {
            return response()->json([
                'success' => false,
                'message' => 'Planet with id ' . $id . ' not found.'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $planet->toArray()
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Planet::where('id', $id)->delete();
    }
}
