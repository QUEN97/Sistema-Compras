<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\FoliosHistorial;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotifiAcepRechaAlmacen extends Notification
{
    use Queueable;

    public $alma;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(FoliosHistorial $alma)
    {
        $this->alma = $alma;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //return ['mail'];
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'epId' => $this->alma->estacionproducto->id,
            'folio' => $this->alma->folio->folio,
            'entradaSalida' => $this->alma->folio->isentrada_issalida,
            'acepRecha' => $this->alma->status,
            'entrasalID' => $this->alma->id,
            'produc' => $this->alma->estacionproducto->producto->name,
            'userEs' => Auth::user()->name,
            'permiTie' => Auth::user()->permiso_id,
            'fecha' => Carbon::now()->diffForHumans(),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
