<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destino;

class DestinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Destino::factory()->count(4)->create();
    }
}
