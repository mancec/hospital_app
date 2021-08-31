@extends('layouts.default')
@section('content')

    <div class="content-table">
        <div class="row">
            <div class="col-lg-12 margin-tb" style="padding-bottom: 10px">
                <div class="pull-left">
                    <h2> Appointments</h2>
                </div>
            </div>
        </div>

        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Date of birth</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            @foreach($appointments as $appointment)
                <tr>
                    <td>{{$appointment->title}}</td>
                    <td>{{$appointment->patients->name}}</td>
                    <td>{{$appointment->patients->surname}}</td>
                    <td>{{$appointment->patients->date_of_birth}}</td>
                    <td>
                        <div>
                            <form action="/appointments/{{$appointment->id}}" method="POST">

                                <a href="/appointments/{{$appointment->id}}" title="show">
                                    <i class="fas fa-eye text-success  fa-lg">Show</i>
                                </a>

                                <a href="/appointments/{{$appointment->id}}/edit">
                                    <i class="fas fa-edit  fa-lg">Edit</i>
                                </a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" title="delete" style="border: none; background-color:transparent;">
                                    <i class="fas fa-trash fa-lg text-danger">Delete</i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {!! $appointments->links() !!}
    </div>

@stop
