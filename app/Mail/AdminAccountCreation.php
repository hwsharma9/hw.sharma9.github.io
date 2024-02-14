<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminAccountCreation extends Mailable
{
    use Queueable;
    use SerializesModels;
    public $user;
    public $password;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password, $subject)
    {
        $this->user = $user;
        $this->password = $password;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view('mail.admin-account-creation');
    }
}
