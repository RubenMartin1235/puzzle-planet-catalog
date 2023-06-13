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
        //dd($currentpurchase);
        return view('purchases.confirm', [
            'currentpurchase' => $currentpurchase,
            'total_price' => $total_price,
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

        $new_purchase_data = [
            'status' => 'finished',
            'final_price' => $final_price,
        ];
        $purchase->update($newdata);

        Auth::user()->balance = $balance - $final_price;
        return redirect(route('cards.index'));
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
    public function destroy(Purchase $purchase)
    {
        //
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
