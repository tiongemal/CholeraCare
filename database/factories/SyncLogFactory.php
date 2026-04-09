<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\SyncLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SyncLog>
 */
class SyncLogFactory extends Factory
{
    protected $model = SyncLog::class;

    public function definition()
    {
        return [
            'field_worker_id' => User::factory(),
            'last_sync' => $this->faker->dateTime,
        ];
    }
}
