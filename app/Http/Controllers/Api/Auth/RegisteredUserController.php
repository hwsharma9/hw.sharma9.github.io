<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:tbl_users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'fk_designation_id' => 5
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'status' => 200,
            'data' => [
                'user' => $user,
                'token' => $token,
                'message' => 'Registered successfully!'
            ]
        ]);

        // event(new Registered($user));

        // Auth::guard('web')->login($user);

        // return redirect(RouteServiceProvider::HOME);
    }
}
