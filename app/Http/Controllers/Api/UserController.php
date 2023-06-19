<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        if (!isset($user->id)) {
            return response()->json([
                "success" => false,
                "message" => "User has not been registered yet.",
            ],404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                "success" => false,
                "message" => "Incorrect data.",
            ],404);
        }
        $token = $user->createToken("auth_token")->plainTextToken;
        return response()->json([
            "success" => true,
            "message" => "Successfully logged in!",
            "access_token" => $token,
        ],200);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            "success" => true,
            "message" => "Successfully logged out.",
        ],200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->roles()->attach(Role::where('name','user')->first());
        $user->save();

        event(new Registered($user));
        Auth::login($user);

        return response()->json([
            "success" => true,
            'message' => 'Successfully signed up user!'
        ],200);
    }

    public function profile() {
        return response()->json([
            "success" => true,
            'message' => 'About user',
            'data' => Auth::user()->makeHidden(['email_verified_at']),
        ]);
    }

    public function profileUpdate(ProfileUpdateRequest $request) {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $request->user()->save();
        return response()->json([
            'success' => true,
            'message' => 'Successfully updated info!',
        ]);
    }

    public function profileDelete(Request $request) {
        $user = Auth::user();
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                "success" => false,
                "message" => "This action requires your password. Deleting your account is irreversible.",
            ],404);
        }
        //die(var_dump(!Hash::check($request->password, $user->password)));
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully deleted user.',
        ]);
    }

    public function show(Request $request, $id) {
        $user = User::find($id);
        if (!isset($user->id)) {
            return response()->json([
                "success" => false,
                "message" => "This user does not exist!",
            ],404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Found user.',
            'data' => $user->makeHidden(['email_verified_at']),
        ]);
    }

    public function update(ProfileUpdateRequest $request, $id) {
        $user = User::find($id);
        if (!isset($user->id)) {
            return response()->json([
                "success" => false,
                "message" => "This user does not exist!",
            ],404);
        }
        $user->fill($request->validated());
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Successfully updated info!',
        ]);
    }

    public function destroy(Request $request, $id) {
        $admin = Auth::user();
        $user = User::find($id);
        if (!isset($user->id)) {
            return response()->json([
                "success" => false,
                "message" => "This user does not exist!",
            ],404);
        }
        if (!Hash::check($request->password, $admin->password)) {
            return response()->json([
                "success" => false,
                "message" => "This action requires your password. Deleting an account is an irreversible action.",
            ],404);
        }
        //die(var_dump(!Hash::check($request->password, $user->password)));
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Successfully deleted user.',
        ]);
    }

    public function topup(Request $request, string $id = null) {
        $user = isset($id) ? User::find($id) : Auth::user();
        if (!isset($user)) {
            return response()->json([
                "success" => false,
                "message" => "This user does not exist!",
            ],404);
        }
        $validated = $request->validate([
            'topup' => 'required|numeric|min:0|max:1000',
            'ccc' => 'required|string',
        ]);
        $new_balance = $user->balance + $validated['topup'];
        $user->balance = $new_balance;
        $user->save();
        $user->update($validated);
        return response()->json([
            'success' => true,
            'message' => "Successfully updated ".(isset($id) ? ($user->name ."'s ") : 'your')." balance!",
            'balance' => $user->balance,
        ]);
    }

    public function cardCollection(Request $request, string $id = null) {
        $user = isset($id) ? User::find($id) : Auth::user();
        if (!isset($user)) {
            return response()->json([
                "success" => false,
                "message" => "This user does not exist!",
            ],404);
        }
        return response()->json([
            'success' => true,
            'data' => $user->cards_collected->toArray(),
        ]);
    }

    protected function resolveNewRoles(array $roles) {
        $new_role_ids = [];
        foreach ($roles as $rolename) {
            $role = Role::where('name', $rolename)->first();
            if ($role) {
                $new_role_ids[] = $role->id;
            }
        }
        return $new_role_ids;
    }

    public function showRoles(Request $request, string $user_id = null) {
        $user = isset($user_id) ? User::find($user_id) : Auth::user();
        if (!isset($user)) {
            return response()->json([
                "success" => false,
                "message" => "This user does not exist!",
            ],404);
        }
        return response()->json([
            'success' => true,
            "message" => "Successfully loaded user {$user->name}'s roles!",
            'data' => [
                'roles' =>
                Auth::user()->hasAnyRole(['admin']) ?
                $user->roles->toArray() :
                $user->roles()->pluck('name')
            ],
        ]);
    }
    public function assignRoles(Request $request, string $user_id = null) {
        $user = isset($user_id) ? User::find($user_id) : Auth::user();
        if (!isset($user)) {
            return response()->json([
                "success" => false,
                "message" => "This user does not exist!",
            ],404);
        }
        $validated=$request->validate([
            'roles'=>'required|string|max:255',
        ]);

        $roles = explode(',',$validated['roles']);
        $new_role_ids = $this->resolveNewRoles($roles);
        $user->roles()->syncWithoutDetaching($new_role_ids);

        return response()->json([
            'success' => true,
            "message" => "Successfully assigned roles to user {$user->name}!",
            'data' => [
                'roles' => $user->roles->toArray()
            ],
        ]);
    }
    public function takeAwayRoles(Request $request, string $user_id = null) {
        $user = isset($user_id) ? User::find($user_id) : Auth::user();
        if (!isset($user)) {
            return response()->json([
                "success" => false,
                "message" => "This user does not exist!",
            ],404);
        }
        $validated=$request->validate([
            'roles'=>'required|string|max:255',
        ]);

        $roles = explode(',',$validated['roles']);
        $new_role_ids = $this->resolveNewRoles($roles);
        $user->roles()->detach($new_role_ids);

        if (!$user->roles()->first()) {
            $user->roles()->attach(Role::where('name','user')->first());
        }

        return response()->json([
            'success' => true,
            "message" => "The chosen roles have been taken away from user {$user->name}!",
            'data' => [
                'roles' => $user->roles->toArray()
            ],
        ]);
    }
}
