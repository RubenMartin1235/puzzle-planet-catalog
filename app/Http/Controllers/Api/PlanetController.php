<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Planet;
use App\Models\Block;

class PlanetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planets = Planet::all();
        return response()->json($planets);
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
        $author = Auth::user();
        if (Auth::user()->hasAnyRole(['admin','loader']) && isset($request->user_id)) {
            $author = User::find($request->user_id);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:24',
            'bio' => 'required|string',
            'description' => 'required|string',
        ]);
        $validated = $request->merge(['user_id' => $author->id]);
        $planet = Planet::factory()->create($validated->toArray());
        $planet->save();

        return response()->json([
            'success' => false,
            'message' => 'Successfully created planet!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $planet = Planet::find($id);
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

    public function showBlocks(string $id)
    {
        $planet = Planet::find($id);
        if (!$planet) {
            return response()->json([
                'success' => false,
                'message' => 'Planet with id ' . $id . ' not found.'
            ], 404);
        }
        $blocks = $planet->blocks()->get(['name','rate'])->makeHidden('pivot');
        return response()->json([
            'success' => true,
            'data' => $blocks->toArray()
        ], 200);
    }
    /**
     * Display a listing of the resource by user
     */
    public function showByUser(Request $request, $user_id)
    {
        $planets = Planet::where('user_id', $user_id);
        return response()->json($planets);
    }
    public function showOwn(Request $request)
    {
        $planets = Planet::where('user_id', Auth::user()->id);
        return response()->json($planets);
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
        $planet = Planet::find($id);
        if (!isset($planet->id)) {
            return response()->json([
                "status" => 0,
                "msg" => "Planet with id {$id} does not exist!",
            ],404);
        }

        $author;
        if ($request->user()->hasAnyRole(['admin','loader'])) {
            // if json field "user_id" in request body exists...
            if (isset($request->user_id)) {
                // the planet's new author will the User with id requested by admin (json field "user_id").
                $author = User::find($request->user_id);
            } else {
                // the planet's author will not change.
                $author = User::find($planet->user_id);
            }
        } else {
            if ($planet->user_id <> $request->user()->id) {
                return response()->json([
                    "status" => 0,
                    "msg" => "You do not have permission to modify this planet!",
                ],404);
            }
            $author = Auth::user();
        }

        $validated = $request->validate([
            'name' => 'string|max:24|min:2',
            'bio' => 'string',
            'description' => 'string',
        ]);
        $validated = $request->merge(['user_id' => $author->id]);
        $planet->fill($validated->toArray());
        $planet->save();

        $successresult_array = [
            'status' => 1,
            'msg' => 'Successfully updated planet info!',
        ];

        $blocks = $request->blocks;
        if (isset($blocks)) {
            foreach ($blocks as $block_type => $rate) {
                $block = Block::where('name', $block_type)->first();
                if ($block <> null && is_numeric($rate)) {
                    if ($rate <= 0) {
                        $planet->blocks()->detach($block);
                    } else {
                        $pivotdata = ['rate' => $rate];
                        if ($planet->hasBlock($block->name)) {
                            $planet->blocks()->updateExistingPivot($block->id, $pivotdata);
                        } else {
                            $planet->blocks()->attach($block, $pivotdata);
                        }
                    }
                }
            }
            $successresult_array['data_blocks'] = $planet->blocks()->get(['name','rate'])->makeHidden('pivot');
        }

        return response()->json($successresult_array);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $planet = Planet::find($id);
        if (!$planet) {
            return response()->json([
                'success' => false,
                'message' => 'Planet with id ' . $id . ' not found.'
            ], 404);
        }
        if ($request->user()->hasAnyRole(['admin','loader']) || $planet->user_id == $request->user()->id) {
            $planet->delete();
            return response()->json([
                'status' => 1,
                'msg' => 'Successfully deleted planet.',
            ]);
        }
        return response()->json([
            "status" => 0,
            "msg" => "You do not have permission to delete this planet!",
        ],404);
    }
}
