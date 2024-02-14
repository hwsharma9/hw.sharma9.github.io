<?php

namespace App\Http\Controllers\User;

use App\Events\SendOTPToVerifyAccountEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAdminProfileRequest;
use App\Http\Requests\Admin\UpdateProfileImageRequest;
use App\Http\traits\FileUpload;
use App\Mail\SendOTPToVerifyAccount;
use App\Models\Admin;
use App\Models\AdminUserDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user): View
    {
        $mobile_verification_code = $user->verificationCode()
            ->where('for', 'mobile_verification')
            ->latest('id')
            ->first();
        $email_verification_code = $user->verificationCode()
            ->where('for', 'email_verification')
            ->latest('id')
            ->first();
        return view('user.profile.profile', compact('user', 'mobile_verification_code', 'email_verification_code'));
    }

    public function sendOTP(User $user, Request $request)
    {
        $otp = randomUniqueId();
        $message = '';
        if ($request->has('verifyotp')) {
            $for = $request->has('email') ? 'email_verification' : 'mobile_verification';
            $verification_code = $user->verificationCode()
                ->where('for', $for)
                ->latest('id')
                ->first();
            if ($verification_code->otp == $request->otp) {
                if ($request->has('email')) {
                    $user->email_verified_at = Carbon::now();
                    $message = 'Email verified successfully';
                } else {
                    $user->mobile_verified_at = Carbon::now();
                    $message = 'Mobile number verified successfully';
                }
                $user->save();
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
            $otp_exist = $user->verificationCode()->where('for', $for);
            if ($otp_exist->count()) {
                $otp = $otp_exist->first()->otp;
            } else {
                $user->verificationCode()->create([
                    'otp' => $otp,
                    'expire_at' => Carbon::now()->addMinutes(10),
                    'for' => $for
                ]);
            }
            if ($request->has('getmobileotp')) {
                $message = 'OTP sent to your mobile number ' . $otp;
            } else {
                $message = 'OTP sent to your email ' . $otp;
                Mail::to($user->email)
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
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminProfileRequest $request, User $user)
    {
        $validated = $request->validated();
        $validated['is_profile_updated'] = true;
        $user->fill($validated);
        $user->save();
        AdminUserDetail::where('fk_admin_id', $user->id)->update(['employee_id' => $request->employee_id]);
        return back()->with('profile_updated', 'Profile updated Successfully');
    }

    public function uploadProfileImage(UpdateProfileImageRequest $request, User $user)
    {
        // if file uploaded
        if ($request->hasFile('file')) {
            $image = $user->upload;
            if ($image) {
                // delete the old image from storage and database.
                $image->delete();
            }

            $user->uploadModelFile($admin);
        }
        return back()->with('image_uploaded', 'Profile Image Uploaded Successfully');
    }

    public function changePassword(): View
    {
        return view('user.profile.change-password');
    }

    public function updatePassword(Request $request, User $user)
    {
        // Validated the form details
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
            'captcha' => 'required|captcha'
        ]);

        // Password updated if valid
        $user->update([
            'password' => Hash::make($validated['password']),
            'password_changed_at' => NOW()
        ]);

        // login user again after password change.
        // and change the session key name
        Auth::login($user, !!$user->getRememberToken());

        return back()->with('success', 'Password updated Successfully');
    }
}
