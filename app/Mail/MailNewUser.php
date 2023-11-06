<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailNewUser extends Mailable
{
    use Queueable, SerializesModels;
    public $mailDataU;

    /**
     * Create a new message instance.
     */
    public function __construct($mailDataU)
    {
        $this->mailDataU = $mailDataU;
    }

   /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Usuarios - Nuevo Usuario '.$this->mailDataU['usuarioname'])
                    ->view('emails.NewUser');
    }
}
