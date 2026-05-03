<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject(Lang::get('Recuperar senha - CadêMeuPix'))
            ->line(Lang::get('Você está recebendo este e-mail porque recebemos uma solicitação de recuperação de senha para sua conta.'))
            ->action(Lang::get('Recuperar Senha'), $url)
            ->line(Lang::get('Este link de recuperação expira em :count minutos.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('Se você não solicitou a recuperação de senha, nenhuma ação é necessária.'));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
