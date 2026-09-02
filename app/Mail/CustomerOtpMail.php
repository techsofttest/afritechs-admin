<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function build(): static
    {
        return $this
            ->subject('Code de réinitialisation de mot de passe - Afri-Techs')
            ->view('emails.customer-otp');
    }
}
