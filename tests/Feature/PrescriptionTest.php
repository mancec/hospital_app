<?php

namespace Tests\Feature;

use App\Mail\PatientRegistration;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\User;
use Database\Factories\PatientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PrescriptionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_prescription_render_screen()
    {
        $patient = Patient::factory()->create();
        $user = User::findOrFail(1);
        $response = $this->actingAs($user)->get('/patients/'.$patient->id.'/prescriptions/create');

        $response->assertStatus(200);
    }

    public function test_prescription_post_delete_routes()
    {
        Queue::fake();
        Notification::fake();

        $patient = Patient::factory()->create();
        $user = User::findOrFail(1);
        $response = $this->actingAs($user)->post('/patients/'.$patient->id.'/prescriptions',  [
            "title" => "test",
            "description" => "text about patient",
            "use_case" => "1 dose per day",
            "notes" => "see expiration date",
            "date" => "2021-09-01",
            "drug_id" => "1",
            "amount" => "5",
        ]);
        $response->assertStatus(302);
//        dump(Queue::pushedJobs());
        Queue::assertPushed(\App\Jobs\ProcessPrescription::class);
        $prescription = Prescription::first();

        $this->assertEquals("test", $prescription->title);
        $this->assertEquals("text about patient", $prescription->description);
        $this->assertEquals("1 dose per day", $prescription->use_case);
        $this->assertEquals("see expiration date", $prescription->notes);
        $this->assertEquals("2021-09-01 00:00:00", $prescription->date);


        $response = $this->actingAs($user)->delete('/patients/'.$patient->id.'/prescriptions/'.$prescription->id);
        $response->assertStatus(302);
    }

    public function test_prescription_job_dispatch()
    {
        Queue::fake();
        Notification::fake();

        $patient = Patient::factory()->create();
        $user = User::findOrFail(1);
        $response = $this->actingAs($user)->post('/patients/' . $patient->id . '/prescriptions', [
            "title" => "test",
            "description" => "text about patient",
            "use_case" => "1 dose per day",
            "notes" => "see expiration date",
            "date" => "2021-09-01",
            "drug_id" => "1",
            "amount" => "5",
        ]);
        $response->assertStatus(302);
//        dump(Queue::pushedJobs());
        Queue::assertPushed(\App\Jobs\ProcessPrescription::class);
    }

    public function test_prescription_notification_is_queued()
    {
        Mail::fake();
        Queue::fake();
        Notification::fake();

        $patient = Patient::factory()->create();
        $user = User::findOrFail(1);
        $response = $this->actingAs($user)->post('/patients/' . $patient->id . '/prescriptions', [
            "title" => "test",
            "description" => "text about patient",
            "use_case" => "1 dose per day",
            "notes" => "see expiration date",
            "date" => "2021-09-01",
            "drug_id" => "1",
            "amount" => "5",
        ]);
        $response->assertStatus(302);
        Mail::assertQueued(PatientRegistration::class);
    }
}
