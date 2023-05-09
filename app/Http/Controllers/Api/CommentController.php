<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Comment;
use App\Models\Planet;
use App\Models\User;

class CommentController extends Controller
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
    public function store(Request $request, string $planet_id)
    {
        $pl = Planet::find($planet_id);
        if (!$pl) {
            return response()->json([
                'success' => false,
                'message' => "Planet {$planet} not found",
            ], 404);
        }

        $author;
        if ($request->user()->hasAnyRole(['admin'])) {
            // if json field "user_id" in request body exists...
            if (isset($request->user_id)) {
                // the planet's new author will the User with id requested by admin (json field "user_id").
                $author = User::find($request->user_id);
            } else {
                $author = Auth::user();
            }
        } else {
            $author = Auth::user();
        }

        $validated = $request->validate([
            'message'=>'required|string|max:255',
        ]);
        /*
        $validated = $request->merge([
            'user_id' => $author->id,
        ]);
        */
        $comment = Comment::factory()->make($validated);
        $comment->planet()->associate($pl);
        $comment->user()->associate($author);
        $comment->save();

        return response()->json([
            'success' => true,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function showByUser(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User with id ' . $id . ' not found.'
            ], 404);
        }
        $comments = $user->comments()->get();
        return response()->json([
            'success' => true,
            'data' => $comments->toArray()
        ], 200);
    }
    public function showByPlanet(string $id)
    {
        $planet = Planet::find($id);
        if (!$planet) {
            return response()->json([
                'success' => false,
                'message' => 'Planet with id ' . $id . ' not found.'
            ], 404);
        }
        $comments = $planet->comments()->get();
        return response()->json([
            'success' => true,
            'data' => $comments->toArray()
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
        $comment = Comment::find($id);
        $author;
        if ($request->user()->hasAnyRole(['admin','loader'])) {
            // if json field "user_id" in request body exists...
            if (isset($request->user_id)) {
                // the planet's new author will the User with id requested by admin (json field "user_id").
                $author = User::find($request->user_id);
            } else {
                // the planet's author will not change.
                $author = User::find($comment->user_id);
            }
        } else {
            if ($comment->user_id <> $request->user()->id) {
                return response()->json([
                    "status" => 0,
                    "msg" => "You do not have permission to modify this comment!",
                ],404);
            }
            $author = Auth::user();
        }

        $validated = $request->validate([
            'message'=>'required|string|max:255',
        ]);
        $validated = $request->merge(['user_id' => $author->id]);
        $comment->fill($validated->toArray());
        $comment->save();

        return response()->json([
            'success' => true,
            'data' => $comment->toArray()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
