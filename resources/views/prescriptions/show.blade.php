@extends('layouts.default')
@section('content')
    <div class="content-table">
        <div class="row">

            <div class="col">
                <h2>Patient:</h2>
                <div>
                    <div class="form-group">
                        <strong>Name</strong>
                        {{$patient->name}}
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <strong>Surname:</strong>
                        {{$patient->surname}}
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <strong>Email address</strong>
                        {{$patient->email}}
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <strong>Personal code</strong>
                        {{$patient->personal_code}}
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <strong>Date of birth</strong>
                        {{$patient->date_of_birth}}
                    </div>
                </div>

            </div>
            <div class="col">
                <h2>Prescription:</h2>
                <div>
                    <div class="form-group">
                        <strong>Notes</strong>
                        {{$prescription->notes}}
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <strong>Description:</strong>
                        {{$prescription->description}}
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <strong>Use case</strong>
                        {{$prescription->use_case}}
                    </div>
                </div>
                <div>
                    <div>
                        <strong>Notes</strong>
                        {{$prescription->notes}}
                    </div>
                </div>
            </div>
            <div class="col">
                <h2>Prescribed drug list:</h2>
                @if ($drugs->count())

                    @foreach($drugs as $drug)
                        <div>
                            <strong>Title:</strong>
                            {{$drug->title}}
                        </div>
                        <div>
                            <strong>Description:</strong>
                            {{$drug->description}}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@stop
