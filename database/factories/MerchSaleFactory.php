<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MerchSale>
 */
class MerchSaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fake_date = $this->faker->dateTimeBetween($startDate='-3 months', $endDate='now');

        return [
            'user_name' => $this->faker->userName,
            'item_name' => $this->faker->randomElement(['fancy pants', 'pen', 'hat','book', 'shirts', 'gloves', 'muffler']),
            'count' => $this->faker->numberBetween($min = 1, $max = 100),
            'price' => $this->faker->numberBetween($min = 10, $max = 500),
            'currency' => 'CAD',
            'created_at' => $fake_date,
            'updated_at' => $fake_date,
        ];
    }
}
