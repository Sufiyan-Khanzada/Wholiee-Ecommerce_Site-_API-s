<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    protected $otp;
    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($otp, $user)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.passwordreset')->with([
            'otp' => $this->otp,
            'user' => $this->user
        ]);
    }
}
