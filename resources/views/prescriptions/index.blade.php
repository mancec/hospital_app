@extends('layouts.default')
@section('content')

    <div class="content-table">
        <div class="row" style="padding-bottom: 10px">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2> Prescriptions</h2>
                </div>
                <form method="GET" action="/patients/{{ $patient->id }}/prescriptions/create">
                    @csrf
                    <button class="btn btn-primary" type="submit">
                        Create Prescription
                    </button>
                </form>
            </div>
        </div>
        @if(session()->has('alert-failed'))
            <div class="alert alert-success">
                {{ session()->get('alert-failed') }}
            </div>
        @endif
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            @foreach($prescriptions as $prescription)
                <tr>
                    <td>{{$prescription->title}}</td>
                    <td>{{$prescription->date}}</td>
                    <td>
                        <div class="row">
                            <form action="/patients/{{ $patient->id }}/prescriptions/{{$prescription->id}}" method="POST">

                                <a href="/patients/{{ $patient->id }}/prescriptions/{{$prescription->id}}" title="show">
                                    <i class="fas fa-eye text-success  fa-lg">Show</i>
                                </a>
                                @csrf
                                @method('DELETE')
                                @if($prescription->status === config('enums.prescription_status.NEW'))
                                <button type="submit" title="delete" style="border: none; background-color:transparent;">
                                    <i class="fas fa-trash fa-lg text-danger">Delete</i>
                                </button>
                                @endif
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $prescriptions->links() !!}
    </div>

@stop
