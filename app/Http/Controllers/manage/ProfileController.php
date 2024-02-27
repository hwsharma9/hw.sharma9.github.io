<?php

namespace App\Http\Controllers\manage;

use App\Events\SendOTPToVerifyAccountEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAdminProfileRequest;
use App\Http\Requests\Admin\UpdateProfileImageRequest;
use App\Http\traits\FileUpload;
use App\Mail\SendOTPToVerifyAccount;
use App\Models\Admin;
use App\Models\AdminUserDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $mobile_verification_code = $admin->verificationCode()
            ->where('for', 'mobile_verification')
            ->latest('id')
            ->first();
        $email_verification_code = $admin->verificationCode()
            ->where('for', 'email_verification')
            ->latest('id')
            ->first();
        return view('admin.profile.profile', compact('admin', 'mobile_verification_code', 'email_verification_code'));
    }

    public function sendOTP(Admin $admin, Request $request)
    {
        $otp = randomUniqueId();
        $message = '';
        if ($request->has('verifyotp')) {
            $for = $request->has('email') ? 'email_verification' : 'mobile_verification';
            $verification_code = $admin->verificationCode()
                ->where('for', $for)
                ->latest('id')
                ->first();
            if ($verification_code->otp == $request->otp) {
                if ($request->has('email')) {
                    $admin->email_verified_at = Carbon::now();
                    $message = 'Email verified successfully';
                } else {
                    $admin->mobile_verified_at = Carbon::now();
                    $message = 'Mobile number verified successfully';
                }
                $admin->save();
                $verification_code->delete();
            }
            return redirect()->to(URL::previous() . "#otp_verification")
                ->with('otp_verified', $message);
        } else {
            $type = 'email';
            if ($request->has('getmobileotp')) {
                $for = 'mobile_verification';
                $type = 'mobile';
            } else {
                $for = 'email_verification';
            };
            $otp_exist = $admin->verificationCode()->where('for', $for);
            if ($otp_exist->count()) {
                $otp = $otp_exist->first()->otp;
            } else {
                $admin->verificationCode()->create([
                    'otp' => $otp,
                    'expire_at' => Carbon::now()->addMinutes(10),
                    'for' => $for
                ]);
            }
            $message = '';
            if ($request->has('getmobileotp')) {
                $message = 'OTP sent to your mobile number. ' . ((config('app.env') == 'production') ? '' : $otp);
            } else {
                $message = 'OTP sent to your email. ' . ((config('app.env') == 'production') ? '' : $otp);
                Mail::to($admin->email)
                    ->send(new SendOTPToVerifyAccount($admin, $type, $otp));
            }
            return redirect()->to(URL::previous() . "#otp_verification")
                ->with('otp_verification', $message);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminProfileRequest $request, Admin $admin)
    {
        $validated = $request->validated();
        $validated['is_profile_updated'] = true;
        $admin->fill($validated);
        $admin->save();
        AdminUserDetail::where('fk_admin_id', $admin->id)->update(['employee_id' => $request->employee_id]);
        return back()->with('profile_updated', 'Profile updated Successfully');
    }

    public function uploadProfileImage(UpdateProfileImageRequest $request, Admin $admin)
    {
        // if file uploaded
        if ($request->hasFile('file')) {
            $image = $admin->upload;
            if ($image) {
                // delete the old image from storage and database.
                $image->delete();
            }

            $admin->uploadModelFile($admin);
        }
        return back()->with('image_uploaded', 'Profile Image Uploaded Successfully');
    }

    public function changePassword()
    {
        return view('admin.profile.change-password');
    }

    public function updatePassword(Request $request, Admin $admin)
    {
        // Validated the form details
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
            'captcha' => 'required|captcha'
        ]);

        // Password updated if valid
        $admin->update([
            'password' => Hash::make($validated['password']),
            'password_changed_at' => NOW()
        ]);

        // login user again after password change.
        // and change the session key name
        Auth::login($admin, !!$admin->getRememberToken());

        return back()->with('success', 'Password updated Successfully');
    }
}
