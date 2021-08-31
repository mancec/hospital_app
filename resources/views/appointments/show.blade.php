@extends('layouts.default')
@section('content')
    <div class="content-table">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2> Appointment</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {{$appointment->patients->name}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Surname</strong>
                    {{$appointment->patients->surname}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Personal code</strong>
                    {{$appointment->patients->personal_code}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Date of birth</strong>
                    {{$appointment->patients->date_of_birth}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Reason for visit</strong>
                    {{$appointment->reason_for_visit}}
                </div>
            </div>
        </div>
        <div>
            <a href="{{ url()->previous() }}"  style="color: inherit;">
                <i class="fa fa-arrow-circle-o-left"></i>
                <span>Back to previous page</span>
            </a>
        </div>

    </div>
@stop
