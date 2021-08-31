<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\AppointmentRequest;
use App\Jobs\ProcessReservation;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\PatientService;
use App\Http\Controllers\Controller;


class AppointmentController extends Controller
{
    private $patient_service;

    /**
     * @param PatientService $patient_service
     */
    public function __construct(PatientService $patient_service)
    {
        $this->patient_service = $patient_service;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $appointments = Appointment::with('patients')->paginate(10);

        return view('appointments.index', [ 'appointments' => $appointments]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request  $request)
    {
        $timestamps = $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
            'doctor_id' => 'required|exists:users,id',
        ]);
        $timeslot = TimeSlot::firstOrCreate([
            'start' => $request->start,
            'end' => $request->end,
            'status' => config('enums.time_slot_status.PENDING'),
            'doctor_id' => $request->doctor_id,
        ]);
        if ($timeslot->wasRecentlyCreated) {
            ProcessReservation::dispatch($timeslot)
                ->onQueue('reservations')
                ->delay(now()->addMinutes(10));
        }
        $patients = Patient::get();
        $doctor = User::findOrFail($request->doctor_id);

        return view('appointments.create',['doctor' => $doctor, 'patients' => $patients, 'timestamps' => $timestamps, 'timeslot' => $timeslot->id]);
    }

    /**
     * @param AppointmentRequest $request
     * @param TimeSlot $timeSlot
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(AppointmentRequest $request, TimeSlot $timeSlot)
    {
        $validated = $request->validated();
        $validated['patient_id']= $this->patient_service->createOrFindUser($request)->id;

        $timeSlot->update(['status' => config('enums.time_slot_status.COMPLETED')]);
        $timeSlot->appointments()->save(new Appointment($validated));

        return redirect('/appointments');
    }

    /**
     * @param Appointment $appointment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Appointment  $appointment)
    {
        return view('appointments.show',['appointment' => $appointment]);
    }

    /**
     * @param Appointment $appointment
     * @return \Illuminate\Routing\Redirector
     */
    public function edit(Appointment  $appointment)
    {
        return redirect('/appointments/calendar/'.$appointment->doctor_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Contracts\View\View
     */
    public function update(AppointmentRequest $request, Appointment  $appointment)
    {
        $validated = $request->validated();
        $appointment->update($validated);
        return view('appointments.show',['appointment' => $appointment]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->timeSlots()->delete();
        $appointment->delete();

        return redirect('/appointments');
    }
}
