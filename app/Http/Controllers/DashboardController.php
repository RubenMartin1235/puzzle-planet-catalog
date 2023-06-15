<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Planet;
use App\Models\Role;
use App\Models\Block;

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
