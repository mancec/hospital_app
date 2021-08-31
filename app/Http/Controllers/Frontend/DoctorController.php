<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $doctors = User::whereHas("roles", function($q){ $q->where("name", "doctor"); })->paginate(10);

        return view('doctors.index', ['doctors' => $doctors]);
    }
}
