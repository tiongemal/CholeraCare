<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Supply;
use App\Models\SyncLog;
use App\Models\Location;
use App\Models\CaseReport;
use App\Models\SupplyUsed;
use App\Models\DailyReport;
use App\Models\CommunicationLog;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_and_retrieve_user_with_location()
    {
        $location = Location::create([
            'location_name' => 'Lilongwe',
            'region' => 'Central',
            'latitude' => -13.9631,
            'longitude' => 33.7741,
        ]);

        $user = User::create([
            'fullname' => 'fieldstaff1',
            'password' => bcrypt('password'),
            'email' => 'fs1@cholera.com',
            'role' => 'field_staff',
            'location_id' => $location->location_id,
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('users', ['fullname' => 'fieldstaff1']);
        $this->assertEquals('Lilongwe', $user->location->location_name);
    }

    /** @test */
    public function it_can_create_and_retrieve_daily_report()
    {
        $user = User::factory()->create(['role' => 'field_staff']);
        $location = Location::factory()->create();

        $report = DailyReport::create([
            'field_worker_id' => $user->user_id,
            'location_id' => $location->location_id,
            'report_date' => now(),
            'suspected_cases' => 5,
            'confirmed_cases' => 3,
        ]);

        $this->assertDatabaseHas('daily_reports', ['report_id' => $report->report_id]);
        $this->assertEquals($user->user_id, $report->fieldWorker->user_id);
        $this->assertEquals($location->location_id, $report->location->location_id);
    }

    /** @test */
    public function it_can_create_and_retrieve_supplies_and_supplies_used()
    {
        $supply = Supply::create(['supply_name' => 'IV Fluids', 'total_quantity' => 100]);
        $report = DailyReport::factory()->create();

        $supplyUsed = SupplyUsed::create([
            'report_id' => $report->report_id,
            'supply_id' => $supply->supply_id,
            'quantity_used' => 20,
        ]);

        $this->assertDatabaseHas('supplies_used', ['supply_use_id' => $supplyUsed->supply_use_id]);
        $this->assertEquals('IV Fluids', $supplyUsed->supply->supply_name);
    }

    /** @test */
    public function it_can_create_and_retrieve_case_reports()
    {
        $report = DailyReport::factory()->create();

        $case = CaseReport::create([
            'report_id' => $report->report_id,
            'case_status' => 'confirmed',
            'patient_age' => 30,
            'patient_gender' => 'Female',
            'reported_at' => now(),
        ]);

        $this->assertDatabaseHas('cases', ['case_id' => $case->case_id]);
        $this->assertEquals('confirmed', $case->case_status);
    }

    /** @test */
    public function it_can_create_and_retrieve_sync_logs()
    {
        $user = User::factory()->create(['role' => 'field_staff']);

        $syncLog = SyncLog::create([
            'field_worker_id' => $user->user_id,
            'last_sync' => now(),
        ]);

        $this->assertDatabaseHas('sync_logs', ['sync_id' => $syncLog->sync_id]);
        $this->assertEquals($user->user_id, $syncLog->fieldWorker->user_id);
    }

    /** @test */
    public function it_can_create_and_retrieve_communication_logs()
    {
        $sender = User::factory()->create(['role' => 'field_staff']);
        $receiver = User::factory()->create(['role' => 'hq_staff']);

        $communicationLog = CommunicationLog::create([
            'sender_id' => $sender->user_id,
            'receiver_id' => $receiver->user_id,
            'message_type' => 'alert',
            'content' => 'Suspected cholera case reported.',
            'sent_at' => now(),
        ]);

        $this->assertDatabaseHas('communication_logs', ['communication_id' => $communicationLog->communication_id]);
        $this->assertEquals($sender->user_id, $communicationLog->sender_id);
        $this->assertEquals($receiver->user_id, $communicationLog->receiver_id);
    }
}
