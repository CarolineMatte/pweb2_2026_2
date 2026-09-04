<?php

namespace Database\Factories;

use App\Models\Destino;
use Illuminate\Database\Eloquent\Factories\Factory;

class DestinoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome'       => fake()->city() . ' - ' . fake()->country(),
            'localizacao'=> fake()->country(),
            'preco'      => fake()->randomFloat(2, 500, 8000),
            'descricao'  => fake()->sentence(10),
        ];
    }
}
