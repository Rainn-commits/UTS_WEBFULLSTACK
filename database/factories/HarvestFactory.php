<?php

namespace Database\Factories;

use App\Models\Harvest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Harvest>
 */
class HarvestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'petani_id' => $this->faker->numberBetween(1, 5),
            'berat_kg' => $this->faker->randomFloat(2, 10, 50),
            'jenis_biji' => $this->faker->randomElement(['fermentasi', 'non-fermentasi']),
            'total_bayar' => $this->faker->numberBetween(350000, 1500000),
            'tanggal_setor' => now(),
        ];
    }
}
