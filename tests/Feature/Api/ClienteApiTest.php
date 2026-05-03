<?php

namespace Tests\Feature\Api;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClienteApiTest extends TestCase
{
    use DatabaseMigrations;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function test_pode_listar_clientes(): void
    {
        Cliente::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->getJson('/api/clientes');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_pode_criar_cliente(): void
    {
        $data = [
            'nome' => 'João Silva',
            'telefone' => '11999999999',
            'cpf' => '12345678901',
        ];

        $response = $this->postJson('/api/clientes', $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.nome', 'João Silva');

        $this->assertDatabaseHas('clientes', ['nome' => 'João Silva']);
    }

    public function test_pode_ver_cliente(): void
    {
        $cliente = Cliente::factory()->create(['user_id' => $this->user->id]);

        $response = $this->getJson('/api/clientes/'.$cliente->id);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $cliente->id);
    }

    public function test_pode_atualizar_cliente(): void
    {
        $cliente = Cliente::factory()->create(['user_id' => $this->user->id]);

        $response = $this->putJson('/api/clientes/'.$cliente->id, [
            'nome' => 'João Atualizado',
            'telefone' => '11999999999',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.nome', 'João Atualizado');
    }

    public function test_pode_excluir_cliente(): void
    {
        $cliente = Cliente::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson('/api/clientes/'.$cliente->id);

        $response->assertStatus(200);

        $this->assertSoftDeleted('clientes', ['id' => $cliente->id]);
    }

    public function test_validacao_campos_obrigatorios(): void
    {
        $response = $this->postJson('/api/clientes', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome', 'telefone']);
    }
}
