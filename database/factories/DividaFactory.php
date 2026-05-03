<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DividaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'cliente_id' => Cliente::factory(),
            'descricao' => fake()->sentence(3),
            'valor' => fake()->randomFloat(2, 10, 1000),
            'data_venda' => fake()->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'data_vencimento' => fake()->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'status' => 'pendente',
        ];
    }

    public function pendente(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'pendente']);
    }

    public function pago(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'pago']);
    }

    public function vencido(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'vencido']);
    }
}
