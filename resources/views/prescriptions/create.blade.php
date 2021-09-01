@extends('layouts.default')
@section('content')
    <div class="content-table">
        <form method="POST" action="/patients/{{$patient->id}}/prescriptions" enctype="multipart/form-data" id="prescriptions-form">
            @csrf
            <div class="form-group">
                <label for="description">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="title" value="{{old('title')}}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="{{old('description')}}">
            </div>
            <div class="form-group">
                <label for="use_case">Use case</label>
                <input type="text" class="form-control" id="use_case" name="use_case" placeholder="Use case" value="{{old('use_case')}}">
            </div>
            <div class="form-group">
                <label for="notes">Additional notes</label>
                <input type="text" class="form-control" id="notes" name="notes" placeholder="notes" value="{{old('notes')}}">
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of prescription</label>
                <input type="datetime-local" class="form-control" id="date" name="date" placeholder="2021-11-11" value="{{old('date')}}">
            </div>
            <div>
                <label for="patient">Drug:</label>
                <select class="form-group" name="drug_id" style="margin-bottom: 30px">

                    @if ($drugs->count())

                        @foreach($drugs as $drug)
                            <option value="{{ $drug->id }}" >{{ $drug->title }}</option>
                        @endforeach
                    @endif

                </select>
            </div>
            <div class="form-group">
                <label for="amount">Drug amount:</label>
                <input type="number" class="form-control" id="amount" name="amount" value="{{old('amount')}}">
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

