<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Cobranca;
use App\Models\Divida;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ModeloTest extends TestCase
{
    use DatabaseMigrations;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_cliente_pode_ter_multiplas_dividas(): void
    {
        $cliente = Cliente::factory()->create(['user_id' => $this->user->id]);

        Divida::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'cliente_id' => $cliente->id,
        ]);

        $this->assertEquals(3, $cliente->dividas()->count());
    }

    public function test_divida_pode_ter_cobranca(): void
    {
        $cliente = Cliente::factory()->create(['user_id' => $this->user->id]);
        $divida = Divida::factory()->create([
            'user_id' => $this->user->id,
            'cliente_id' => $cliente->id,
        ]);

        $cobranca = Cobranca::factory()->create([
            'user_id' => $this->user->id,
            'divida_id' => $divida->id,
            'valor' => $divida->valor,
        ]);

        $this->assertEquals($divida->id, $cobranca->divida->id);
    }

    public function test_divida_calcula_total_pendente(): void
    {
        $cliente = Cliente::factory()->create(['user_id' => $this->user->id]);

        Divida::factory()->create([
            'user_id' => $this->user->id,
            'cliente_id' => $cliente->id,
            'valor' => 100.00,
            'status' => 'pendente',
        ]);

        Divida::factory()->create([
            'user_id' => $this->user->id,
            'cliente_id' => $cliente->id,
            'valor' => 200.00,
            'status' => 'vencido',
        ]);

        Divida::factory()->create([
            'user_id' => $this->user->id,
            'cliente_id' => $cliente->id,
            'valor' => 50.00,
            'status' => 'pago',
        ]);

        $total = $cliente->total_dividas;

        $this->assertEquals(300.00, $total);
    }

    public function test_divida_status_vencido(): void
    {
        $divida = Divida::factory()->create([
            'status' => 'pendente',
            'data_vencimento' => now()->subDay(),
        ]);

        $this->assertTrue($divida->isVencido());
    }
}
