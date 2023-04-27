<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Planet;
use App\Models\Block;
use Closure;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blocks = Block::all();
        return response()->json($blocks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    function validateReq($request, $unique = false) {
        $validated = $request->validate([
            'name' => 'required|string|max:16' . (($unique) ? '|unique:blocks' : ''),
            'color' => function (string $attribute, mixed $value, Closure $fail) {
                $regex = "/#[0-9a-f]{6}/i";
                if (preg_match($regex, $value) <> 1) {
                    $fail("The {$attribute} is invalid.");
                }
            },
        ]);
        if (!isset($validated->color)) {
            $validated = $request->merge(['color' => '#787878']);
        }
        return $validated;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateReq($request, true);
        $block = Block::factory()->create($validated->toArray());
        $block->save();
        return response()->json([
            'status' => 1,
            'msg' => 'Successfully created block!'
        ]);
    }

    function getBlockByIDorName(string $id) {
        return (is_numeric($id) ? Block::where('id',intval($id)) : Block::where('name', $id))->first();
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $block = $this->getBlockByIDorName($id);
        if (!$block) {
            $msg = "Block {$id} not found";
            return response()->json([
                'success' => false,
                'message' => $msg,
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $block->toArray(),
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
        $block = Block::find($id);
        if (!isset($block->id)) {
            return response()->json([
                "status" => 0,
                "msg" => "Block with id {$id} does not exist!",
            ],404);
        }
        $validated = $this->validateReq($request);
        $block->fill($validated->toArray());
        $block->save();
        return response()->json([
            'success' => true,
            'message' => "Successfully updated block!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $block = $this->getBlockByIDorName($id);
        if (!$block) {
            return response()->json([
                'success' => false,
                'message' => 'Block ' . $id . ' not found.'
            ], 404);
        }
        $block->delete();
        return response()->json([
            'status' => 1,
            'msg' => 'Successfully deleted block.',
        ]);
    }
}
