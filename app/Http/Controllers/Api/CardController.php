<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CardController as WebCardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Card;

class CardController extends Controller
{
    protected static $validationRules = [
        'name' => 'required|string|max:40',
        'price' => 'required|numeric|min:0.49|max:999.99',
        'stock' => 'required|integer|min:1',
        'description' => 'required|string|max:1000',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = Card::all();
        return response()->json($cards);
    }

    protected function notFoundJson(string $id) {
        return response()->json([
            'success' => false,
            'message' => "Card with id {$id} not found."
        ], 404);
    }
    protected function resultJson(Card $card) {
        return response()->json([
            'success' => true,
            'data' => $card->toArray()
        ], 200);
    }

    public function show(Request $request, string $id)
    {
        $cd = Card::find($id);
        if (!$cd) {
            return $this->notFoundJson($id);
        }
        return $this->resultJson($cd);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::$validationRules);
        $card = Card::factory()->create($validated);
        $card->fill($validated);
        $card->save();
        return $this->resultJson($card);
    }

    public function update(Request $request, string $id)
    {
        $card = Card::find($id);
        if (!$card) {
            return $this->notFoundJson($id);
        }
        $validated = $request->validate(self::$validationRules);
        $card->update($validated);
        return $this->resultJson($card);
    }
    public function restock(Request $request, string $id)
    {
        $card = Card::find($id);
        if (!$card) {
            return $this->notFoundJson($id);
        }
        $validated = $request->validate([
            'stock' => 'required|integer|min:1',
        ]);
        $card->update($validated);
        return $this->resultJson($card);
    }

    public function destroy(Request $request, string $id)
    {
        $card = Card::find($id);
        if (!$card) {
            return $this->notFoundJson($id);
        }
        $card->delete();
        return response()->json([
            'success' => true,
            'message' => 'Successfully deleted card.',
        ]);
    }
}
