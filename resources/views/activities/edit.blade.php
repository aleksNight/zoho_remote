@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="display-3" style="margin-top: 100px">Update Deal Task</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br />
            @endif
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="post" action="{{route('activities.update', $activity->id)}}">
                @method('PATCH')
                @csrf
                <div class="form-row">
                    <div class="col-md-12 mb-6">
                        <label for="owner">Owner</label>
                        <select id="owner" class="form-control" name="owner">
                            @foreach($users as $user)
                                <option value="{{$user->id}}" {{ ($user->id == $activity->user_id) ? 'selected' : '' }}>{{$user->first_name . ' ' . $user->last_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-6">
                        <label for="name">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required value="{{$activity->subject}}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-6">
                        <label for="status">Status</label>
                        <select id="status" class="form-control" name="status">
                            @foreach($fields as $field)
                                @if ($field->api_name == 'Status')
                                    @foreach($field->values as $value)
                                        <option value="{{$value->display_value}}" {{ ($value->display_value == $activity->status) ? 'selected' : '' }}>{{$value->display_value}}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-6">
                        <label for="record">Module</label>
                        <select id="record" class="form-control" name="record">
                            <option value="0">--NONE--</option>
                            @foreach($records as $record)
                                <option value="{{$record->id}}" {{($record->id == $activity->record_id) ? 'selected' : ''}}>{{$record->Deal_Name}}</option>
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
                                        <option value="{{$value->display_value}}"{{ ($value->display_value == $activity->priority) ? 'selected' : '' }}>{{$value->display_value}}</option>
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
                                <option value="{{$contact->id}}" {{ ($contact->id == $activity->contact_id) ? 'selected' : '' }}>{{$contact->First_Name . ' '. $contact->Last_Name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="form-row">
                        <div class="col-md-12 mb-6">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" >{{$activity->description}}</textarea>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Submit form</button>
            </form>
        </div>
    </div>
@endsection
