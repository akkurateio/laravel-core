<?php

namespace Akkurate\LaravelCore\Notifications\Me;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitationNotification extends Notification
{
    use Queueable;

    public $token;

    public $user;
    public $from;

    /**
     * @var Carbon
     */
    public $now;

    /**
     * Create a new notification instance.
     * @param $token
     * @param $user
     * @param $from
     */
    public function __construct($token, $user, $from)
    {
        $this->now = Carbon::now();
        $this->user = $user;
        $this->token = $token;
        $this->from = $from;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Invitation d’accès à la plateforme ' . config('app.name'))
            ->view('me::emails.invitation', [
                'subject' => 'Invitation d’accès à la plateforme ' . config('app.name'),
                'token' => $this->token,
                'user' => $this->user,
                'from' => $this->from,
                'now' => $this->now
            ]);
    }
}
