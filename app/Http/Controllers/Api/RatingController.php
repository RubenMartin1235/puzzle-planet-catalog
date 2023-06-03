<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Rating;
use App\Models\Planet;
use App\Models\User;

class RatingController extends Controller
{
    protected $validationRules = [
        'score'=>'required|integer|min:1|max:5',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ratings = Rating::all();
        return response()->json([
            'success' => true,
            'data' => $ratings->toArray()
        ], 200);
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
                'message' => "Planet with id {$planet_id} not found",
            ], 404);
        }
        $author;
        if ($request->user()->hasAnyRole(['admin'])) {
            // if json field "user_id" in request body exists...
            if (isset($request->user_id)) {
                // the rating's new author will the User with id requested by admin (json field "user_id").
                $author = User::find($request->user_id);
            } else {
                $author = Auth::user();
            }
        } else {
            $author = Auth::user();
        }
        if ($author->id == $pl->user->id) {
            return response()->json([
                'success' => false,
                'message' => "You cannot rate your own planets!",
            ], 404);
        }
        $rating_old = $pl->ratings()->where('user_id',Auth::user()->id)->first();
        if ($rating_old !== null) {
            return $this->update($request, $rating_old->id);
        }

        $validated = $request->validate($this->validationRules);
        $rating = Rating::factory()->make($validated);
        $rating->rateable()->associate($pl);
        $rating->user()->associate($author);
        $rating->save();
        return response()->json([
            'success' => true,
            'message' => "Successfully rated planet {$pl->name}!",
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function showOwn()
    {
        $ratings = Auth::user()->ratings()->get();
        return response()->json([
            'success' => true,
            'data' => $ratings->toArray()
        ], 200);
    }
    public function showByUser(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "User with id {$id} not found",
            ], 404);
        }
        $ratings = $user->ratings()->get();
        return response()->json([
            'success' => true,
            'data' => $ratings->toArray()
        ], 200);
    }
    public function showByPlanet(string $id)
    {
        $planet = Planet::find($id);
        if (!$planet) {
            return response()->json([
                'success' => false,
                'message' => "Planet with id {$id} not found",
            ], 404);
        }
        $ratings = $planet->ratings()->get();
        return response()->json([
            'success' => true,
            'data' => $ratings->toArray()
        ], 200);
    }
    public function showAvgOfPlanet(string $id)
    {
        $planet = Planet::find($id);
        if (!$planet) {
            return response()->json([
                'success' => false,
                'message' => "Planet with id {$id} not found",
            ], 404);
        }
        $ratings = $planet->ratings()->avg('score');
        return response()->json([
            'success' => true,
            'data' => [
                'avg_score' => $ratings,
                'planet' => $planet->toArray(),
            ]
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
        $rating = Rating::find($id);
        $validated = $request->validate($this->validationRules);
        if ($request->user()->hasAnyRole(['admin','loader']) || $rating->user->id == Auth::user()->id) {
            $rating->update($validated);
            return response()->json([
                'success' => true,
                'message' => 'Successfully updated your rating!',
            ], 200);
        }
        return response()->json([
            "success" => false,
            "message" => "You do not have permission to update this rating!",
        ],404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $rating = Rating::find($id);
        if (!$rating) {
            return response()->json([
                'success' => false,
                'message' => 'Rating with id ' . $id . ' not found.'
            ], 404);
        }
        if ($request->user()->hasAnyRole(['admin','loader']) || $rating->user->id == Auth::user()->id) {
            $rating->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted rating.',
            ]);
        }
        return response()->json([
            "success" => false,
            "message" => "You do not have permission to delete this rating!",
        ],404);
    }
}
