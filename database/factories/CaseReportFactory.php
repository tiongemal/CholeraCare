<?php

namespace Database\Factories;

use App\Models\CaseReport;
use App\Models\DailyReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CaseReport>
 */
class CaseReportFactory extends Factory
{
    protected $model = CaseReport::class;

    public function definition()
    {
        return [
            'report_id' => DailyReport::factory(),
            'case_status' => $this->faker->randomElement(['suspected', 'confirmed']),
            'patient_age' => $this->faker->numberBetween(1, 90),
            'patient_gender' => $this->faker->randomElement(['Male', 'Female']),
            'reported_at' => $this->faker->date(),
        ];
}
}
