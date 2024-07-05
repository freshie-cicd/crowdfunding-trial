<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable;
    use SerializesModels;


    public $code;

    /**
     * Create a new message instance.
     */
    public function __construct($code) {
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.booking_confirmation')->with('code', $this->code);
    }
}
