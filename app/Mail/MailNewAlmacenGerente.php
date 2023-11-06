<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNewAlmacenGerente extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
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
        return $this->subject('Almacen - Nueva Solicitud de '.$this->mailData['entraSale'].' '.'de'.' '.$this->mailData['usuarioSolici'])
                    ->view('emails.NewAlmacenGerente')
                    ->attach(public_path('storage/entradas-salidas-pdfs/'.$this->mailData['nombrePdf']), [
                        'as' => $this->mailData['nombrePdf'],
                        'mime' => 'application/pdf',
                    ]);
    }
}
