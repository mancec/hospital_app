<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PrescriptionResource;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrescriptionController extends Controller
{

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return PrescriptionResource::collection(Prescription::with('drugs')->get());
    }

    /**
     * @param Prescription $prescription
     * @return PrescriptionResource
     */
    public function show(Prescription $prescription)
    {
        return new PrescriptionResource($prescription);
    }

}
