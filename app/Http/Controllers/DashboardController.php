<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Planet;
use App\Models\Role;
use App\Models\Block;
use App\Models\User;
use App\Models\Comment;
use App\Models\Card;
use App\Models\Purchase;

class DashboardController extends Controller
{
    public function index()
    {
        $planets = Auth::user()->planets()->latest()->paginate(4);
        $comments = Auth::user()->comments()->latest()->paginate(5);
        $role = Auth::user()->roles()->orderBy('id','DESC')->first() ?? Role::where('name','user')->first();
        return view('dashboard.index',[
            'planets' => $planets,
            'comments' => $comments,
            'balance' => Auth::user()->balance,
            'role' => $role,
        ]);
    }

    public function planets()
    {
        $planets = Auth::user()->planets()->paginate(15);
        return view('dashboard.planets',[
            'planets' => $planets,
        ]);
    }
    public function comments()
    {
        $comments = Auth::user()->comments()->latest()->paginate(10);
        return view('dashboard.comments',[
            'comments' => $comments,
        ]);
    }
    public function cards() {
        $cards = Auth::user()->cards_collected()->latest()->paginate(15);
        return view('dashboard.cards',[
            'cards' => $cards,
        ]);
    }
    public function cardsAdmin() {
        $cards = Card::latest()->paginate(15);
        return view('dashboard.cards.privileged',[
            'cards' => $cards,
        ]);
    }

    public function purchases()
    {
        $purchases = Purchase::latest()->paginate(20);
        return view('dashboard.purchases.index',[
            'purchases' => $purchases,
        ]);
    }
    public function purchaseShow(Request $request, Purchase $purchase)
    {
        $items = $purchase->items;
        return view('dashboard.purchases.show',[
            'purchase' => $purchase,
            'items' => $items,
        ]);
    }

    public function users() {
        $users = User::latest()->paginate(15);
        return view('dashboard.users.index',[
            'users' => $users,
        ]);
    }
    public function userPurchases(Request $request, User $user) {
        $purchases = $user->purchases()->latest()->paginate(20);
        return view('dashboard.users.purchases',[
            'purchases' => $purchases,
            'user' => $user,
        ]);
    }
    public function userCards(Request $request, User $user) {
        $cards = $user->cards_collected()->latest()->paginate(20);
        return view('dashboard.users.cards',[
            'cards' => $cards,
            'user' => $user,
        ]);
    }

    public function userDestroy(Request $request, User $user) {
        $user->delete();
        return redirect(route('dashboard.users'));
    }

    public function userEdit(Request $request, User $user) {
        return view('dashboard.users.edit',[
            'user' => $user,
        ]);
    }
    public function userUpdate(Request $request, User $user) {
        $user->save();
        $validated=$request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255',
            'balance'=>'required|numeric|min:0',
        ]);
        $user->update($validated);
        $roles = explode(',',$request->input('roles'));
        $new_role_ids = [];
        foreach ($roles as $rolename) {
            $role = Role::where('name', $rolename)->first();
            if ($role) {
                $new_role_ids[] = $role->id;
            }
        }
        $user->roles()->sync($new_role_ids);
        return redirect(route('dashboard.users'));
    }

    public function topup() {
        return view('dashboard.topup',[
            'balance' => Auth::user()->balance,
        ]);
    }
    public function topupAction(Request $request) {
        $validated = $request->validate([
            'topup' => 'required|numeric|min:0|max:1000',
            'ccc' => 'required|string',
        ]);
        $new_balance = Auth::user()->balance + $validated['topup'];
        Auth::user()->balance = $new_balance;
        Auth::user()->save();
        return redirect(route('dashboard.topup'));
    }
}
