<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Comment;
use App\Models\Planet;
use App\Models\Card;
use App\Models\User;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return response()->json([
            'success' => true,
            'data' => $comments->toArray()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    protected function resolveAuthor(Request $request) {
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
        return $author;
    }
    /**
     * Store a newly created resource in storage.
     */
    protected function store(Request $request, $commentable) {
        $author = $this->resolveAuthor($request);
        $validated = $request->validate([
            'message'=>'required|string|max:255',
        ]);
        /*
        $validated = $request->merge([
            'user_id' => $author->id,
        ]);
        */
        $comment = Comment::factory()->make($validated);
        $comment->commentable()->associate($commentable);
        $comment->user()->associate($author);
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => "Comment successfully made!",
        ], 200);
    }
    public function storeOnPlanet(Request $request, string $planet_id)
    {
        $pl = Planet::find($planet_id);
        if (!$pl) {
            return response()->json([
                'success' => false,
                'message' => "Planet with id {$planet_id} not found",
            ], 404);
        }
        return $this->store($request, $pl);
    }
    public function storeOnCard(Request $request, string $card_id)
    {
        $cd = Card::find($card_id);
        if (!$cd) {
            return response()->json([
                'success' => false,
                'message' => "Card with id {$card_id} not found",
            ], 404);
        }
        return $this->store($request, $cd);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => "Comment with id {$id} not found."
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $comment->toArray()
        ], 200);
    }
    public function showOwn()
    {
        $comments = Auth::user()->comments()->get();
        return response()->json([
            'success' => true,
            'data' => $comments->toArray()
        ], 200);
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

    protected function showByCommentable(Request $request, $commentable) {
        $comments = $commentable->comments()->get();
        return response()->json([
            'success' => true,
            'data' => $comments->toArray()
        ], 200);
    }
    public function showByPlanet(Request $request, string $id)
    {
        $planet = Planet::find($id);
        if (!$planet) {
            return response()->json([
                'success' => false,
                'message' => 'Planet with id ' . $id . ' not found.'
            ], 404);
        }
        return $this->showByCommentable($request, $planet);
    }
    public function showByCard(Request $request, string $id)
    {
        $card = Card::find($id);
        if (!$card) {
            return response()->json([
                'success' => false,
                'message' => 'Card with id ' . $id . ' not found.'
            ], 404);
        }
        return $this->showByCommentable($request, $card);
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
                    "success" => false,
                    "message" => "You do not have permission to modify this comment!",
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
    public function destroy(Request $request, string $id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Comment with id ' . $id . ' not found.'
            ], 404);
        }
        if ($request->user()->hasAnyRole(['admin','loader']) || $comment->user->id == $request->user()->id) {
            $comment->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted comment.',
            ]);
        }
        return response()->json([
            "success" => false,
            "message" => "You do not have permission to delete this comment!",
        ],404);
    }
}
