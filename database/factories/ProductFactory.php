<?php

namespace Database\Factories;

use App\Models\product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_varian' => $this->faker->randomElement(['Datu Cokelat Dark ', 'Datu 
Cokelat Milk ', 'Datu Cokelat White ']) . 
                            $this->faker->randomElement(['Mete', 'Kurma', 'Original']) . ' 
' . 
                             $this->faker->randomElement([50, 100]) . 'g',
            'stok' => $this->faker->numberBetween(10, 100),
            'harga' => $this->faker->numberBetween(15, 35) * 1000,
        ];
    }
}
