<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome'     => fake()->name(),
            'cpf'      => fake()->numerify('###.###.###-##'),
            'telefone' => fake()->phoneNumber(),
            'email'    => fake()->safeEmail(),
        ];
    }
}
