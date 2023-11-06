<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Repuesto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotifiAcepRechaRepuesto extends Notification
{
    use Queueable;

    public $repuesto;

    /**
     * Create a new notification instance.
     *
     * @return void
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
            'acepRecha' => $this->repuesto->status,
            'repuesID' => $this->repuesto->id,
            'produEs' => $this->repuesto->producto->name,
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
