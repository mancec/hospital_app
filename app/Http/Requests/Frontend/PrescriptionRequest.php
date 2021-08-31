<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:60|alpha',
            'description'  => 'required|max:255',
            'use_case'  => 'required|max:255',
            'notes'  => 'required|max:255',
            'drug_id'  => 'required|exists:drugs,id',
            'amount'  => 'required|numeric',
            'date' => 'required|date'
        ];
    }
}
