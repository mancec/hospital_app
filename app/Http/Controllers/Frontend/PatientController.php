<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::paginate(10);

        return view('patients.index', ['patients' => $patients]);
    }
}
