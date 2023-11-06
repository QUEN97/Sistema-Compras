<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Solicitud;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotifiAcepRechaSolicitud extends Notification
{
    use Queueable;
    
    public $solicitud;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Solicitud $solici)
    {
        $this->solicitud = $solici;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'acepRecha' => $this->solicitud->status,
            'soliciID' => $this->solicitud->id,
            'userEs' => Auth::user()->name,
            'permiTie' => Auth::user()->permiso_id,
            'fecha' => Carbon::now()->diffForHumans(),
        ];
    }

}
