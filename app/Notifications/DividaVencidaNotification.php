<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DividaVencidaNotification extends Notification
{
    public $divida;

    public function __construct($divida)
    {
        $this->divida = $divida;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $cliente = $this->divida->cliente;

        return (new MailMessage)
            ->subject('Dívida vencida - CadêMeuPix')
            ->greeting("Olá, {$notifiable->name}!")
            ->line("A dívida do cliente *{$cliente->nome}* está vencida.")
            ->line("**Descrição:** {$this->divida->descricao}")
            ->line("**Valor:** R$ " . number_format($this->divida->valor, 2, ',', '.'))
            ->line("**Data de vencimento:** {$this->divida->data_vencimento->format('d/m/Y')}")
            ->action('Ver detalhes', url(route('dividas.show', $this->divida)))
            ->line('Acesse o sistema para tomar as providências necessárias.');
    }

    public function toArray($notifiable): array
    {
        return [
            'divida_id' => $this->divida->id,
            'cliente_nome' => $this->divida->cliente->nome,
            'valor' => $this->divida->valor,
        ];
    }
}
