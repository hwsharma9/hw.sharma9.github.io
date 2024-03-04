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
        $otp = $admin->verificationCode()->latest('id')->first();
        if (!$otp) {
            return redirect()->route('manage.login');
        }
        return view('admin.auth.verify-otp', compact('admin', 'otp'));
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

        if (!$verificationCode) {
            return redirect()->back()->with('status', 'Your OTP is not correct');
        } elseif ($verificationCode && $verificationCode->isExpired()) {
            $verificationCode->delete();
            Auth::guard('admin')->logout();
            session('role_name', '');
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('manage.login')->with('status', 'Your OTP has been expired');
        }
        $verificationCode->delete();
        // $request->authenticate();
        // $request->session()->regenerate();

        // Create necessary session for user roles and permissions
        // PermissionSessions::setPermissionSessions();

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
