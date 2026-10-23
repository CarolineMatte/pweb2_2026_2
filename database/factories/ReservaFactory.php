<?php

namespace Database\Factories;

use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Destino;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaFactory extends Factory
{
    public function definition(): array
    {
        $dataIda = fake()->dateTimeBetween('now', '+6 months');
        $dataVolta = (clone $dataIda)->modify('+' . fake()->numberBetween(3, 20) . ' days');

        return [
            'data_reserva' => $dataIda->format('Y-m-d'),
            'data_volta'   => $dataVolta->format('Y-m-d'),
            'status'       => fake()->randomElement(['Confirmada', 'Pendente', 'Cancelada']),
            'observacao'   => fake()->sentence(8),
            'cliente_id'   => Cliente::factory(),
            'destino_id'   => (Destino::all()->random())->id,
        ];
    }
}
