<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserSallery extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $month;

    public function __construct($user, $month)
    {
        $this->user = $user;
        $this->month = $month;
    }

    public function build()
    {
        return $this->subject('Your Salary Details for ' . $this->month)
            ->view('emails.sallery');
    }
}
