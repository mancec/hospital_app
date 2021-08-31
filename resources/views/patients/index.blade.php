@extends('layouts.default')
@section('content')

    <div class="content-table">
        <div class="row" style="padding-bottom: 10px">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2> Patients list</h2>
                </div>
                <div class="row" style="padding-bottom: 20px; width: 600px">
                    <div class="col">
                        <form method="GET" action="/patients">
                            @csrf
                            <button class="btn btn-primary" type="submit">
                                All patients
                            </button>
                        </form>
                    </div>
                    <div class="col">
                        <form method="GET" action="/users/{{auth()->id()}}/patients">
                            @csrf
                            <button class="btn btn-primary" type="submit">
                                Patients with appointment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Date of birth</th>
                <th scope="col">Prescription</th>
            </tr>
            </thead>
            <tbody>

        @foreach($patients as $patient)
                <tr>
                    <td>{{$patient->name}}</td>
                    <td>{{$patient->surname}}</td>
                    <td>{{$patient->date_of_birth}}</td>
                    <td>
                        <div>
                            <a href="/patients/{{$patient->id}}/prescriptions" title="show">
                                <i class="fas fa-eye text-success  fa-lg">Show</i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $patients->links() !!}
    </div>

@stop
