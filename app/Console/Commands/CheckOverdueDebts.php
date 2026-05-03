<?php

namespace App\Console\Commands;

use App\Models\Divida;
use App\Notifications\DividaVencidaNotification;
use Illuminate\Console\Command;

class CheckOverdueDebts extends Command
{
    protected $signature = 'dividas:check-overdue';

    protected $description = 'Check for overdue debts and send notifications';

    public function handle(): int
    {
        $dividas = Divida::where('status', Divida::STATUS_PENDENTE)
            ->where('data_vencimento', '<', now())
            ->with('user')
            ->get();

        $count = 0;

        foreach ($dividas as $divida) {
            $divida->update(['status' => Divida::STATUS_VENCIDO]);
            $divida->user->notify(new DividaVencidaNotification($divida));
            $count++;
        }

        $this->info("{$count} dívida(s) marcada(s) como vencida(s) e notificação(ões) enviada(s).");

        return Command::SUCCESS;
    }
}
