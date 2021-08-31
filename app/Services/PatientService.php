<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientService
{
    public function createOrFindUser(Request  $request)
    {
        switch ($request->form_selected) {
            case 'new_patient' :
                $patient = Patient::create([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $request->email,
                    'personal_code' => $request->personal_code,
                    'date_of_birth' => $request->date_of_birth,
                ]);
                return $patient;
            case 'existing_patient' :
                $patient = Patient::findOrFail($request->patient_id);
                return $patient;
        }

    }
}
