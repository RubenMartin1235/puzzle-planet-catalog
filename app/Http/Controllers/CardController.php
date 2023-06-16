<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

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
        $cards = Card::latest()->paginate(15);
        return view('cards.index',compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(self::$validationRules);
        $card = Card::factory()->create($validated);
        $imgpath = $this->resolveCardImage($request, $card);
        $validated['image'] = $imgpath;
        $card->fill($validated);
        $card->save();
        return redirect(route('cards.show',$card));
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
    public function edit(Request $request, Card $card)
    {
        return view('cards.edit', [
            'cd' => $card,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Card $card)
    {
        $validated = $request->validate(self::$validationRules);
        $imgpath = $this->resolveCardImage($request, $card);
        if ($imgpath !== null) {
            $validated['image'] = $imgpath;
        }
        $card->update($validated);
        return redirect(route('cards.show', $card));
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
        return redirect(route('cards.index'));
    }

    protected function resolveCardImage(Request $request, Card $card) {
        $imgfile = $request->file('image');
        $path = ($imgfile) ? $imgfile->storeAs(
            'cards', $card->id . '.' . $imgfile->extension(),
            'public'
        ) : null;
        return $path;
    }
}
