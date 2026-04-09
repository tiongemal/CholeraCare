<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\CommunicationLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommunicationLog>
 */
class CommunicationLogFactory extends Factory
{
    protected $model = CommunicationLog::class;

    public function definition()
    {
        return [
            'sender_id' => User::factory(),
            'receiver_id' => User::factory(),
            'message_type' => $this->faker->randomElement(['alert', 'message']),
            'content' => $this->faker->sentence,
            'sent_at' => $this->faker->dateTime,
        ];
    }
}
