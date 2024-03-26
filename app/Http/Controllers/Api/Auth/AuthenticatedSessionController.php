<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        // $request->session()->regenerate();

        // Setting auth users token for login on react
        $token = auth()->user()->createToken('auth_token')->plainTextToken;
        // setcookie('token', $token, time() + (86400 * 30), "/");

        return response()->json([
            'status' => 200,
            'data' => [
                'user' => auth()->user(),
                'token' => $token,
                'message' => 'Login successfully!'
            ]
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        setcookie('token', "", time() - 3600, "/");

        return redirect()->to(route('login'));
    }
}
