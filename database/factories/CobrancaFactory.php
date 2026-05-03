<?php

namespace Database\Factories;

use App\Models\Divida;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CobrancaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'divida_id' => Divida::factory(),
            'chave_pix' => Str::uuid()->toString(),
            'valor' => fake()->randomFloat(2, 10, 1000),
            'status' => 'pendente',
            'link_pagamento' => null,
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
