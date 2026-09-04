<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Destino;

class ReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = Cliente::all();
        $destinos = Destino::all();

        foreach ($clientes as $cliente) {
            Reserva::create([
                'data_reserva' => fake()->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
                'status'       => fake()->randomElement(['Confirmada', 'Pendente', 'Cancelada']),
                'observacao'   => fake()->sentence(8),
                'cliente_id'   => $cliente->id,
                'destino_id'   => $destinos->random()->id,
            ]);
        }
    }
}
