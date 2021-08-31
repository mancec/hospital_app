@extends('layouts.default')
@section('content')

    <div class="content-table">
        <div class="row" style="padding-bottom: 10px">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2> Statistics about prescribed drugs</h2>
                </div>
                <div>
                    <form method="GET" action="/drugs">
                        @csrf
                        <div class="row" style="padding-bottom: 20px">
                            <div class="col">
                                <label for="Date_from">Date from</label>
                                <input type="date" class="form-control" id="date_from" name="date_from" value="{{$date['date_from']}}">
                            </div>
                            <div class="col">
                                <label for="Date_to">Date to</label>
                                <input type="date" class="form-control" id="date_to" name="date_to" value="{{$date['date_to']}}">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">
                            Create Prescription
                        </button>
                    </form>
                </div>
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
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
            </tr>
            </thead>
            <tbody>

            @foreach($drugs as $drug)
                <tr>
                    <td>{{$drug->title}}</td>
                    <td>{{$drug->total}}</td>
                    <td>{{$drug->date}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {!! $drugs->links() !!}

@stop
