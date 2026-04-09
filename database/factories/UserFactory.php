<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        return [
            'fullname' => $this->faker->unique()->userName,
            'password' => bcrypt('password'), // Set a default password for testing
            'email' => $this->faker->unique()->safeEmail,
            'role' => $this->faker->randomElement(['admin', 'field_staff', 'hq_staff']),
            'location_id' => \App\Models\Location::factory(), // Create associated location
            'status' => 'active',
        ];
    }
}
