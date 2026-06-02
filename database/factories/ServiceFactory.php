<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['account_type' => 'profissional']),
            'name' => fake()->words(2, true),
            'duration_minutes' => fake()->randomElement([15, 30, 45, 60, 90]),
            'description' => fake()->optional()->sentence(),
            'price' => fake()->optional()->randomFloat(2, 20, 200),
        ];
    }
}
