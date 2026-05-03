<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nome' => 'Test Cliente',
            'telefone' => '5511999999999',
            'cpf' => '12345678901',
        ];
    }
}
