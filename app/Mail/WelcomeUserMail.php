<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeUserMail extends Mailable
{
    use Queueable, SerializesModels;
   
    public $name;
    public $password;

    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Bienvenue sur SGAE')
            ->view('emails.welcomeuser')
            ->with([
                'name' => $this->name,
                'password' => $this->password,
                'url' => 'https://sgae-1.onrender.com/',
            ]);
    }
}
