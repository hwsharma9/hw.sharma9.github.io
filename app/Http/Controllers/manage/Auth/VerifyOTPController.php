<?php

namespace App\Http\Controllers\manage\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Traits\PermissionSessions;
use Illuminate\Support\Facades\Auth;

class VerifyOTPController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Admin $admin)
    {
        return view('admin.auth.verify-otp', compact('admin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Admin $admin, LoginRequest $request)
    {
        $verificationCode = $admin->verificationCode->where(['otp' => $request->otp, 'for' => 'login'])->latest('id')->first();

        $now = Carbon::now();
        if (!$verificationCode) {
            return redirect()->back()->with('status', 'Your OTP is not correct');
        } elseif ($verificationCode && $now->isAfter($verificationCode->expire_at)) {
            return redirect()->route('manage.login')->with('status', 'Your OTP has been expired');
        }

        $request->authenticate();
        $request->session()->regenerate();

        // Create necessary session for user roles and permissions
        PermissionSessions::setPermissionSessions();
        $verificationCode->delete();

        // $this->authenticated($request);
        return redirect()->route('manage.home');
    }

    /**
     * Function Authenticated users
     * @param request
     */
    protected function authenticated(Request $request)
    {
        $result = Auth::logoutOtherDevices($request->password);
        info('Session deleted for password =>' . $request->password);
        info($result);
    }
}
