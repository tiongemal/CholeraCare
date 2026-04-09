<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Location;
use App\Models\DailyReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyReport>
 */
class DailyReportFactory extends Factory
{
    protected $model = DailyReport::class;

    public function definition()
    {
        return [
            'field_worker_id' => User::factory(),
            'location_id' => Location::factory(),
            'report_date' => $this->faker->date(),
            'suspected_cases' => $this->faker->numberBetween(0, 100),
            'confirmed_cases' => $this->faker->numberBetween(0, 50),
        ];
    }
}
