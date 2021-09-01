<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\TimeSlot;
use App\Models\User;
use Database\Seeders\PermissionsUsersSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
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
        $user = User::findOrFail(2);
        $response = $this->actingAs($user)->get('/appointments/calendar/1');

        $response->assertStatus(200);
    }

    public function test_appointment_calendar_create()
    {
        $user = User::findOrFail(2);
        $timeslot = TimeSlot::create([
            'start' => '2021-08-31 09:30:00',
            'end' => '2021-08-31 11:30:00',
            'status' => 'Pending',
            'doctor_id' => 1,
        ]);

        $response = $this->actingAs($user)->post('/appointments/timeslots/'.$timeslot->id,
            [
                "title" => "Development",
                "form_selected" => "new_patient",
                "patient_id" => "1",
                "name" => "test",
                "surname" => "test",
                "email" => "test@example.com",
                "personal_code" => "99999999980",
                "date_of_birth" => "2021-07-13",
                "doctor_id" => "1",
                "reason_for_visit" => "ererer",
                 "start" => "2021-09-01 10:30:00",
                 "end" => "2021-09-01 12:00:00"
            ]);
        $appointment = Appointment::first();
        $this->assertEquals("Development", $appointment->title);
        $this->assertEquals("ererer", $appointment->reason_for_visit);
        $this->assertEquals("1", $appointment->patient_id);
        $this->assertEquals("1", $appointment->doctor_id);
    }
}
