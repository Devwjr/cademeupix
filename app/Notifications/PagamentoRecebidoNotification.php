<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PagamentoRecebidoNotification extends Notification
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
            ->subject('Pagamento recebido - CadêMeuPix')
            ->greeting("Olá, {$notifiable->name}!")
            ->success()
            ->line("O pagamento da dívida do cliente *{$cliente->nome}* foi registrado!")
            ->line("**Descrição:** {$this->divida->descricao}")
            ->line("**Valor:** R$ " . number_format($this->divida->valor, 2, ',', '.'))
            ->action('Ver detalhes', url(route('dividas.show', $this->divida)))
            ->line('Parabéns! Mais uma conta receber quitada.');
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
