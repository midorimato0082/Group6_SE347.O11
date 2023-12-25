<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $splitName = explode(' ', fake()->name(), 2); 
        return [
            'last_name' => $splitName[1],
            'first_name' => $splitName[0],
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
            'avatar' => null
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}