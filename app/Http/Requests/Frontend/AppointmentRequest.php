<?php

namespace App\Http\Requests\Frontend;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'timestamp' => now()
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch ($this->form_selected) {
            case 'existing_patient' :
                return [
                    'title' => 'required|max:60|alpha',
                    'reason_for_visit' => 'required||max:255',
                    'start' => 'required|date',
                    'end' => 'required|date',
                    'timestamp' => 'required|date',
                    'doctor_id' => 'required|exists:users,id',
                    'patient_id' => 'required|exists:patients,id'
                ];
            case 'new_patient' :
                return [
                    'title' => 'required|max:60|alpha',
                    'reason_for_visit' => 'required||max:255',
                    'start' => 'required|date',
                    'end' => 'required|date',
                    'timestamp' => 'required|date',
                    'doctor_id' => 'required|exists:users,id',
                    'name' => 'required|max:60|alpha',
                    'surname' => 'required|max:60|alpha',
                    'email' => 'required|email',
                    'personal_code' => 'required|numeric|digits:11',
                    'date_of_birth' => 'required|date',
                ];
        }
    }
}
