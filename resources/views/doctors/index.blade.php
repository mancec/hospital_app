@extends('layouts.default')
@section('content')

    <div class="content-table">
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>

            @foreach($doctors as $doctor)
                <tr>
                    <td>{{$doctor->name}}</td>
                    <td>{{$doctor->email}}</td>
                    <td>  <div class="row">
                            <a href="/appointments/calendar/{{$doctor->id}}" title="Create Appointment">
                                <i class="text-success">Create Appointment</i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {!! $doctors->links() !!}

@stop
