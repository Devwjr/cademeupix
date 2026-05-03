<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Cobranca;
use App\Models\Divida;
use App\Models\User;
use Illuminate\Database\Seeder;

class DividaSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $clientes = Cliente::all();

        foreach ($clientes as $cliente) {
            Divida::factory()->count(3)->create([
                'user_id' => $cliente->user_id,
                'cliente_id' => $cliente->id,
            ]);
        }

        $dividas = Divida::all();

        foreach ($dividas as $divida) {
            if (rand(0, 1)) {
                Cobranca::factory()->create([
                    'user_id' => $divida->user_id,
                    'divida_id' => $divida->id,
                    'valor' => $divida->valor,
                ]);
            }
        }
    }
}
