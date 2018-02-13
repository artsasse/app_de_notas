<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ForgotPasswordMessage extends Notification
{
    use Queueable;

    protected $passcode;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($passcode)
    {
        $this->passcode = $passcode;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Notepad - Criar nova senha')
                    ->greeting('Olá!')
                    ->line('Você está recebendo essa mensagem porque solicitou a criação de uma nova senha.')
                    //->action('Crie sua nova senha', url('/'))
                    ->line('Copie o código a seguir e utilize-o no app para criar uma nova senha:')
                    ->line($this->passcode)
                    ->line('Se você não solicitou isso, apenas ignore a mensagem.')
                    ->salutation('Atenciosamente, Equipe Notepad');

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
