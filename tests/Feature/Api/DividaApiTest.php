<?php

namespace Tests\Feature\Api;

use App\Models\Cliente;
use App\Models\Divida;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DividaApiTest extends TestCase
{
    use DatabaseMigrations;

    protected User $user;

    protected Cliente $cliente;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->cliente = Cliente::factory()->create(['user_id' => $this->user->id]);
        Sanctum::actingAs($this->user);
    }

    public function test_pode_listar_dividas(): void
    {
        Divida::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'cliente_id' => $this->cliente->id,
        ]);

        $response = $this->getJson('/api/dividas');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_pode_criar_divida(): void
    {
        $data = [
            'cliente_id' => $this->cliente->id,
            'descricao' => 'Venda de mercadorias',
            'valor' => 150.50,
            'data_venda' => now()->toDateString(),
            'data_vencimento' => now()->addDays(30)->toDateString(),
        ];

        $response = $this->postJson('/api/dividas', $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.descricao', 'Venda de mercadorias');

        $this->assertDatabaseHas('dividas', ['descricao' => 'Venda de mercadorias']);
    }

    public function test_pode_ver_divida(): void
    {
        $divida = Divida::factory()->create([
            'user_id' => $this->user->id,
            'cliente_id' => $this->cliente->id,
        ]);

        $response = $this->getJson('/api/dividas/'.$divida->id);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $divida->id);
    }

    public function test_pode_atualizar_divida(): void
    {
        $divida = Divida::factory()->create([
            'user_id' => $this->user->id,
            'cliente_id' => $this->cliente->id,
        ]);

        $response = $this->putJson('/api/dividas/'.$divida->id, [
            'cliente_id' => $this->cliente->id,
            'descricao' => 'Descrição atualizada',
            'valor' => 200.00,
            'data_venda' => now()->toDateString(),
            'data_vencimento' => now()->addDays(30)->toDateString(),
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.descricao', 'Descrição atualizada');
    }

    public function test_pode_marcar_divida_como_paga(): void
    {
        $divida = Divida::factory()->create([
            'user_id' => $this->user->id,
            'cliente_id' => $this->cliente->id,
            'status' => 'pendente',
        ]);

        $response = $this->postJson('/api/dividas/'.$divida->id.'/marcar-pago');

        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'pago');
    }

    public function test_pode_gerar_cobranca(): void
    {
        $divida = Divida::factory()->create([
            'user_id' => $this->user->id,
            'cliente_id' => $this->cliente->id,
        ]);

        $response = $this->postJson('/api/dividas/'.$divida->id.'/gerar-cobranca');

        $response->assertStatus(201);
    }
}
