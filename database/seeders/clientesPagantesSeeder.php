<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\clientesPagantes;

class ClientesPagantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        clientesPagantes::factory()->count(10)->create();
    }
}
