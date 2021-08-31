<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\PrescriptionRequest;
use App\Http\Requests\Frontend\PrescriptionUpdateRequest;
use App\Jobs\ProcessPrescription;
use App\Mail\PatientRegistration;
use App\Models\Drug;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class PatientPrescriptionController extends Controller
{
    /**
     * @param Patient $patient
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Patient $patient)
    {
        $prescriptions = $patient->prescriptions()->paginate(10);

        return view('prescriptions.index', ['prescriptions' => $prescriptions, 'patient' => $patient]);
    }

    /**
     * @param Patient $patient
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Patient $patient)
    {
        $drugs = Drug::get();

        return view('prescriptions.create', ['drugs' => $drugs, 'patient' => $patient]);
    }

    /**
     * @param Patient $patient
     * @param PrescriptionRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Patient $patient, PrescriptionRequest  $request)
    {
        $validated = $request->validated();

        $prescription = $patient->prescriptions()->create($validated);
        $prescription->drugs()->sync([$validated['drug_id'] => array('amount' => $request->amount, 'created_at' => $validated['date'])]);

        Mail::to($patient->email)
            ->queue(new PatientRegistration($prescription));
        ProcessPrescription::dispatch($prescription)
            ->onQueue('reservations');

        return redirect('/patients/' . $patient->id . '/prescriptions');
    }

    /**
     * @param Patient $patient
     * @param Prescription $prescription
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Patient $patient, Prescription $prescription)
    {
        $drugs = $prescription->drugs()->get();

        return view('prescriptions.show', ['prescription' => $prescription, 'patient' => $patient, 'drugs' => $drugs]);
    }

    /**
     * @param Patient $patient
     * @param Prescription $prescription
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Patient $patient, Prescription $prescription)
    {
        if ($prescription->status === config('enums.prescription_status.NEW'))
        {
            $prescription->drugs()->detach();
            $prescription->delete();
            return redirect('/patients/' . $patient->id . '/prescriptions');
        }
        else {
            return redirect('/patients/' . $patient->id . '/prescriptions')->with('alert-failed', 'Prescription is already confirmed');;
        }
    }
}
