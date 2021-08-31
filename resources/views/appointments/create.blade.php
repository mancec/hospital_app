@extends('layouts.default')
@section('content')
    <div class="content-table">
        <form method="POST" action="/appointments/timeslots/{{$timeslot}}" enctype="multipart/form-data" id="appointment-form">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{old('title')}}" >
            </div>

            <div>
                <select class="form-group" name="form_selected" id="patient_form" onChange='javascript:FormSelect();'>
                    <option value="existing_patient" selected="selected">Existing patient</option>
                    <option value="new_patient">New patient</option>
                </select>

                <div class="form-group"  id="existing_patient">
                    <div>
                        <label for="patient">Patient:</label>
                        <select class="form-group" name="patient_id" style="margin-bottom: 15px">

                            @if ($patients->count())

                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{old ('patient_id') == $patient ? 'selected' : ''}}>{{ $patient->name }}</option>
                                @endforeach
                            @endif

                        </select>
                    </div>
                </div>

                <div class="form-group" id="new_patient" style="display:none">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="testpatient">
                    </div>
                    <div class="form-group">
                        <label for="surname">Surname</label>
                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname" value="testsurname">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@test.com" value="test@test.com">
                    </div>
                    <div class="form-group">
                        <label for="personal_code">Personal code (11 numbers)</label>
                        <input type="text" class="form-control" id="personal_code" name="personal_code" placeholder="39540948432" value="39540941241">
                    </div>
                    <div class="form-group">
                        <label for="date_of_birth">Date of birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Title" value="test">
                    </div>
                </div>
            </div>
            <div>
                <label for="patient">Doctor: {{$doctor->name}}</label>
                <input type="hidden" name="doctor_id" value="{{$doctor->id}}" id="doctor_id">
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Reason for visit</label>
                <textarea class="form-control" id="reason_for_visit" name="reason_for_visit" rows="3">Formal check</textarea>
            </div>
            <div class="form-group">
                <label for="date">From : {{$timestamps['start']}}</label>
                <input type="hidden" name="start" value="{{$timestamps['start']}}" id="start">
            </div>
            <div class="form-group">
                <label for="time">To : {{ $timestamps['end'] }}</label>
                <input type="hidden" name="end" value="{{ $timestamps['end'] }}" id="end">
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@stop

@section('scripts')
    <script>
        function FormSelect(){
            var formSelected = document.getElementById("patient_form").value;
            document.getElementById('existing_patient').style.display = "none";
            document.getElementById('new_patient').style.display = "none";
            switch(formSelected)
            {
                case 'existing_patient':
                    document.getElementById('existing_patient').style.display = "block"; // or inline or none whatever
                    break;
                case 'new_patient':
                    document.getElementById('new_patient').style.display = "block"; // or inline or none whatever
                    break;

            }
        }
    </script>
@endsection
