<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPatientController extends Controller
{
    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(User $user)
    {
        $patients = Patient::leftJoin('appointments','appointments.patient_id', '=', 'patients.id')
            ->where('doctor_id', $user->id)
            ->distinct()
            ->paginate(10, 'patients.*');

        return view('patients.index', ['patients' => $patients]);
    }
}
