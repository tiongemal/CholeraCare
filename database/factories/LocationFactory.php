<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    protected $model = \App\Models\Location::class;

    public function definition()
    {
        return [
            'location_name' => $this->faker->city,
            'region' => $this->faker->state,
        ];
    }
}
