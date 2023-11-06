<?php

namespace App\Notifications;

use App\Models\Solicitud;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NotifiEditAdminSoli extends Notification
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
            'estacion' => $this->solicitud->estacion->name,
            'userEs' => Auth::user()->name,
            'fecha' => Carbon::now()->diffForHumans(),
            'soliNum' => $this->solicitud->id,
        ];
    }

}
