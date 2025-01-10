<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chirp>
 */
class ChirpFactory extends Factory
{
    public function definition(): array
    {
        return [
            'message' => fake()->sentence(),
            'user_id' => User::factory()
        ];
    }
}
