<?php

namespace Illuminate\Auth\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //     ->line('لاستعادة كلمة المرور اضغط على الرابط التالى ')
        //     ->action('استعادة كلمة المرور', url(Request()->root().route('password.reset', $this->token, false)))
        //     ->line('');
        
        return (new MailMessage)
            ->line('لاستعادة كلمة المرور اضغط على الرابط التالى ')
            ->action('استعادة كلمة المرور', url(Request()->root().'/administrator'.route('password.reset', $this->token, false)))
            ->line('');
    }
}
