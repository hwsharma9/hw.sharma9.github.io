<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOTPToVerifyAccount extends Mailable
{
    use Queueable;
    use SerializesModels;
    public $admin;
    public $type;
    public $otp;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admin, $type, $otp)
    {
        $this->admin = $admin;
        $this->type = $type;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Get OTP to verify your " . ucfirst($this->type))
            ->markdown('mail.send-otp-to-verify-account');
    }
}
