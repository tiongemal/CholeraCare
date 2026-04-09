<?php

namespace Database\Factories;

use App\Models\Supply;
use App\Models\SupplyUsed;
use App\Models\DailyReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupplyUsed>
 */
class SupplyUsedFactory extends Factory
{
    protected $model = SupplyUsed::class;

    public function definition()
    {
        return [
            'report_id' => DailyReport::factory(),
            'supply_id' => Supply::factory(),
            'quantity_used' => $this->faker->numberBetween(1, 50),
        ];
    }
}
