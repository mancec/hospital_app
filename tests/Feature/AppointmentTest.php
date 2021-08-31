<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\PermissionsUsersSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_appointment_calendar_render_screen()
    {
        $this->seed(PermissionsUsersSeeder::class);
        $user = User::findOrFail(3);

        $response = $this->actingAs($user)->get('/appointments/calendar/1');

        $response->assertStatus(200);
    }

    public function test_appointment_calendar_create()
    {
        $this->seed(PermissionsUsersSeeder::class);
        $user = User::findOrFail(3);

        $response = $this->actingAs($user)->get('/appointments/calendar/1');

        $response->assertStatus(200);
    }
}
