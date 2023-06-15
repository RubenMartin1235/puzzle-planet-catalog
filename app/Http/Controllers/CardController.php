<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = Card::latest()->paginate(15);
        return view('cards.index',compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('cards.show', Card::find(1));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        $comments = $card->comments()->latest()->paginate(10);
        $commentable_type = 'cards';
        //dd($blocks);
        //dd($comments);
        return view('cards.show',[
            'cd' => $card,
            'comments' => $comments,
            'commentable' => $card,
            'commentable_type' => $commentable_type,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function restock(Request $request, Card $card)
    {
        $validated = $request->validate([
            'stock' => 'required|integer|min:1',
        ]);
        $card->update($validated);
        return redirect(route('cards.show', $card));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Card $card = null)
    {
        $cd = $card ?? Card::find($request->input('card_id'));
        $cd->delete();
        return redirect(url()->previous());
    }
}
