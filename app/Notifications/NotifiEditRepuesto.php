<?php

namespace App\Notifications;

use App\Models\Repuesto;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NotifiEditRepuesto extends Notification
{
    use Queueable;

    public $repuesto;

    /**
     * Create a new notification instance.
     */
    public function __construct(Repuesto $repues)
    {
        $this->repuesto = $repues;
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
            'produEs' => $this->repuesto->producto->name,
            'estacEs' => $this->repuesto->estacion->name,
            'esrepID' => $this->repuesto->id,
            'userEs' => Auth::user()->name,
            'permiTie' => Auth::user()->permiso_id,
            'fecha' => Carbon::now()->diffForHumans(),
        ];
    }
}
