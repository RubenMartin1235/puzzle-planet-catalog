<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Card;

class PurchaseController extends Controller
{
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
    protected function cardNotFoundJson(string $id) {
        return response()->json([
            'success' => false,
            'message' => "Card with id {$id} not found."
        ], 404);
    }
    protected function notFoundJson(string $id) {
        return response()->json([
            'success' => false,
            'message' => "Purchase with id {$id} not found."
        ], 404);
    }

    public function showItems(Request $request, string $id = null) {
        $purch = isset($id) ? Purchase::find($id) : $this->getLastPurchase();
        if (!isset($purch)) {
            return $this->notFoundJson($id);
        }
        $items = $purch->items;
        $price = $this->getTotalPrice($purch);
        return response()->json([
            'success' => true,
            'data' => [
                'price' => $price,
                'items' => $items->toArray(),
            ],
        ], 200);
    }

    public function addCard(Request $request, string $card_id) {
        $card = Card::find($card_id);
        if (!isset($card)) {
            return $this->cardNotFoundJson($card_id);
        }
        $lpurch = $this->getLastPurchase();
        if (!isset($lpurch)) {
            $lpurch = $this->startNewPurchase();
        }
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
        ]);
        $amount_added = $validated['amount'];
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
        return response()->json([
            'success' => true,
            'message' => "Successfully added {$amount_added} of card {$card->name} to purchase cart!",
            'data' => $lpurch->items->toArray()
        ], 200);
    }

    public function removeItem(Request $request, PurchaseItem $item) {
        if ($this->isAllowedToModify($item->purchase)) {
            $item->delete();
        }
        return response()->json([
            'success' => true,
            'message' => "Successfully removed item from purchase cart!",
            'data' => $item->purchase->items->toArray(),
        ], 200);
    }

    public function destroy(Request $request, string $id) {
        $purch = Purchase::find($id);
        if (!isset($purch)) {
            return $this->notFoundJson($id);
        }
        return response()->json([
            'success' => true,
            'message' => "Successfully deleted purchase!",
        ], 200);
    }

    public function confirm(Request $request) {
        $purchase = $this->getLastPurchase();
        $final_price = $this->getTotalPrice($purchase);
        $balance = Auth::user()->balance;
        if ($balance < $final_price) {
            return response()->json([
                'success' => false,
                'message' => "You don't have enough money!",
            ], 200);
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
        return response()->json([
            'success' => true,
            'message' => "The purchase was successful!",
            'data' => [
                'balance' => $balance,
                'final_price' => $final_price,
                'final_balance' => Auth::user()->balance,
            ],
        ], 200);
    }

    protected function isAllowedToModify(Purchase $purchase) {
        return (Auth::user()->hasAnyRole(['admin']) || $purchase->user->id == Auth::user()->id);
    }
}
