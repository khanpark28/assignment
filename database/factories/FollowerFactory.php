<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follower>
 */
class FollowerFactory extends Factory
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
            'created_at' => $fake_date,
            'updated_at' => $fake_date,
        ];
    }
}
