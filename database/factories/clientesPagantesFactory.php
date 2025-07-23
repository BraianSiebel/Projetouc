<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\clientesPagantes>
 */
class clientesPagantesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nome" => fake()->sentence(),
            "valor_contrato" =>fake()->numberBetween(10000,20000),
            "UC_existente" => fake()->numberBetween(0,1),
        ];
    }
}
