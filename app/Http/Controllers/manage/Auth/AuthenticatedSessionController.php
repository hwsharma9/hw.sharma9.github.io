<?php

namespace App\Http\Controllers\manage\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Traits\PermissionSessions;
use App\Models\Admin;
use App\Models\VerificationCode;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    use PermissionSessions;
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        # Generate An OTP
        $verificationCode = $this->generateOtp($request->email);
        // return $verificationCode->roles[0]->status;
        if ($verificationCode->roles[0]->status == 0) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'The Role ' . $verificationCode->roles[0]->name . ' has been deactivated. Contact Administrator.']);
        }
        if ($verificationCode->status == 0) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'You are not an activated User. Contact Administrator.']);
        }
        if (config('app.env') == 'production') {
            $message = "Your OTP To Login is - " . $verificationCode->otp;
            // $this->sendSMS($verificationCode->phone, $message);
        } else {
            $message = 'Your OTP sent to your mobile number.';
        }
        # Return With OTP

        return redirect()->route('manage.otp.verification', [
            'admin' => encrypt($verificationCode->id)
        ])->with('success', $message);
        // $request->authenticate();

        // $request->session()->regenerate();

        // // Create necessary session for user roles and permissions
        // PermissionSessions::setPermissionSessions();

        // return redirect()->intended(route('manage.home'));
    }

    public function generateOtp($email)
    {
        $otp = rand(123456, 999999);
        $admin = Admin::where('email', $email)->first();

        # Admin Does not Have Any Existing OTP
        $verificationCode = $admin->verificationCode;

        $now = Carbon::now();

        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) {
            $verificationCode->delete();
            // return $verificationCode;
        }

        // Create a New OTP
        $admin->verificationCode()->create([
            'otp' => rand(123456, 999999),
            'expire_at' => Carbon::now()->addMinutes(10),
            'for' => 'login'
        ]);
        return $admin;
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        // session('user_roles', '');
        session('role_name', '');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('manage.login');
    }
}
