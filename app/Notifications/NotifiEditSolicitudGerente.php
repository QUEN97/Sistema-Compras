<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Solicitud;
use Carbon\Carbon;

class NotifiEditSolicitudGerente extends Notification
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    public function toDatabase($notifiable)
    {
        return [
            'estacion' => $this->solicitud->estacion->name,
            'gerente' => $this->solicitud->estacion->user->name,
            'soliNum' => $this->solicitud->id,
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
