<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PurchaseController extends Controller
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

    protected function getLastPurchase(){
        return Auth::user()->current_purchases->first();
    }
    protected function startNewPurchase(){
        $purchase = Purchase::factory()->make(['status' => 'started']);
        $purchase->user()->associate(Auth::user());
        $purchase->save();
        return $purchase;
    }
    protected function getTotalPrice(Purchase $purchase){
        $items = $purchase->items;
        $total_price = 0;
        foreach ($items as $item) {
            $total_price += $item->card->price * $item->amount;
        }
        return $total_price;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect(url()->previous());
    }

    public function addCard(Request $request, Card $card) {
        $lpurch = $this->getLastPurchase();
        if (!isset($lpurch)) {
            $lpurch = $this->startNewPurchase();
        }
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
        ]);
        if ($olditem = $lpurch->items()->where('card_id', $card->id)->first()) {
            $amount_new = min([
                $validated['amount'] + $olditem->amount,
                $card->stock
            ]);
            $validated['amount'] = $amount_new;
            $olditem->update($validated);
        } else {
            $newitem = PurchaseItem::factory()->make($validated);
            $newitem->purchase()->associate($lpurch);
            $newitem->card()->associate($card);
            $newitem->save();
        }
        return redirect(url()->previous());
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    public function showConfirmation()
    {
        $currentpurchase = $this->getLastPurchase();
        $total_price = $this->getTotalPrice($currentpurchase);
        $current_balance = Auth::user()->balance;
        $final_balance = $current_balance - $total_price;
        //dd($currentpurchase);
        return view('purchases.confirm', [
            'currentpurchase' => $currentpurchase,
            'total_price' => $total_price,
            'current_balance' => $current_balance,
            'final_balance' => $final_balance,
        ]);
    }
    public function confirm(Request $request){
        $purchase = $this->getLastPurchase();
        $final_price = $this->getTotalPrice($purchase);
        $balance = Auth::user()->balance;
        if ($balance < $final_price) {
            return redirect(route('purchases.confirm.show'))
                ->withErrors([
                    'message' => "You don't have enough money!"
                ]);
        }
        //dd($purchase->items);
        $items = $purchase->items;
        foreach ($items as $item) {
            $card = $item->card;
            $pivotdata;
            $user_had_card = Auth::user()->cards_collected()->find($card->id);
            if (isset($user_had_card)) {
                $user_had_cards_amount = $user_had_card->pivot->amount;
                $pivotdata = ['amount' => ($item->amount + $user_had_cards_amount)];
                Auth::user()->cards_collected()->updateExistingPivot($card->id, $pivotdata);
            } else {
                $pivotdata = ['amount' => $item->amount];
                Auth::user()->cards_collected()->attach($card, $pivotdata);
            }
            $card->stock -= $item->amount;
            $card->save();
        }

        $new_purchase_data = [
            'status' => 'finished',
            'final_price' => $final_price,
        ];
        $purchase->update($new_purchase_data);

        Auth::user()->balance = $balance - $final_price;
        Auth::user()->save();
        //Auth::user()->cards()->attach();
        return redirect(route('cards.index'))
            ->with('purchase_result','The purchase was successful!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Purchase $purchase = null)
    {
        $prch = $purchase ?? Purchase::find($request->input('purchase_id'));
        $prch->delete();
        return redirect(url()->previous());
    }

    public function removeItem(Request $request, PurchaseItem $item) {
        if ($this->isAllowedToModify($item->purchase)) {
            $item->delete();
        }
        return redirect(url()->previous());
    }

    protected function isAllowedToModify(Purchase $purchase) {
        return (Auth::user()->hasAnyRole(['admin']) || $purchase->user->id == Auth::user()->id);
    }
}
