<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Solicitud;
use Carbon\Carbon;

class NotifiNewSolicitud extends Notification
{
    use Queueable;

    public $solicitud;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Solicitud $soli)
    {
        $this->solicitud = $soli;
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
            'soliciId' => $this->solicitud->id,
            'estacion' => $this->solicitud->estacion->name,
            'supervisor' => $this->solicitud->estacion->supervisor->name,
            'fecha' => Carbon::now()->diffForHumans(),
        ];
    }

}
