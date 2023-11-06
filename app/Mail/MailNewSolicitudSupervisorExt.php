<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailNewSolicitudSupervisorExt extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

     /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Solicitudes - Nueva Solicitud de '.$this->mailData['solicitadopor'])
                    ->view('emails.NewSolicitudSupervisorExt')
                    ->attach(public_path('storage/solicitudes-pdfs/'.$this->mailData['nombrePdf']), [
                        'as' => $this->mailData['nombrePdf'],
                        'mime' => 'application/pdf',
                    ]);
    }
}
