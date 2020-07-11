@extends('layouts.main')
@section('pageTitle')
    <h2 class="display-3" style="text-align: center; margin-top: 100px">Create Deal Task</h2>
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="post" action="{{route('activities.store')}}">
        @csrf
        <div class="form-row">
            <div class="col-md-12 mb-6">
                <label for="owner">Owner</label>
                <select id="owner" class="form-control" name="owner">
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->first_name . ' ' . $user->last_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-6">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-6">
                <label for="status">Status</label>
                <select id="status" class="form-control" name="status">
                    @foreach($fields as $field)
                        @if ($field->api_name == 'Status')
                            @foreach($field->values as $value)
                                <option value="{{$value->display_value}}">{{$value->display_value}}</option>
                            @endforeach
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-6">
                <label for="record">Record</label>
                <select id="record" class="form-control" name="record">
                    <option value="0" selected>-NONE-</option>
                    @foreach($records as $record)
                        <option value="{{$record->id}}">{{$record->Deal_Name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-12 mb-6">
                <label for="priority">Priority</label>
                <select id="priority" class="form-control" name="priority">
                    @foreach($fields as $field)
                        @if ($field->api_name == 'Priority')
                            @foreach($field->values as $value)
                                <option value="{{$value->display_value}}">{{$value->display_value}}</option>
                            @endforeach
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-6">
                <label for="contact">Contact</label>
                <select id="contact" class="form-control" name="contact">
                    @foreach($contacts as $contact)
                        <option value="{{$contact->id}}">{{$contact->First_Name . ' '. $contact->Last_Name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group" >
            <div class="form-row">
                <div class="col-md-12 mb-6">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Submit form</button>
    </form>
@endsection
