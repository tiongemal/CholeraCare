<?php

namespace Database\Factories;

use App\Models\Supply;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supply>
 */
class SupplyFactory extends Factory
{
    protected $model = Supply::class;

    public function definition()
    {
        return [
            'supply_name' => $this->faker->word,
            'total_quantity' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
