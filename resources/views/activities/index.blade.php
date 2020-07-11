@extends('layouts.main')
@section('pageTitle')
    <h2 class="display-3" style="margin-top: 100px">All Activities</h2>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">

            <div class="col-sm-12">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
            </div>
            <div>
                <a style="margin: 19px;" href="{{ route('activities.create')}}" class="btn btn-primary">Add new</a>
            </div>
            {{$activities->render()}}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>Subject</td>
                        <td>Type</td>
                        <td>Module</td>
                        <td>Created</td>
                        <td>Owner</td>
                        <td>Contact</td>
                        <td>Priority</td>
                        <td>Status</td>
                        <td>Record</td>
                        <td>Actions</td>

                    </tr>
                </thead>
                <tbody>
                @foreach($activities as $activity)
                    <tr>
                        <td>{{$activity->subject}}</td>
                        <td>{{$activity->type}}</td>
                        <td>{{$activity->module}}</td>
                        <td>{{$activity->created}}</td>
                        <td>{{$users[$activity->user_id]}}</td>
                        <td>{{($activity->contact_id != 0) ? $contacts[$activity->contact_id] : ''}}</td>
                        <td>{{$activity->priority}}</td>
                        <td>{{$activity->status}}</td>
                        <td>{{ (!is_null($activity->record_id)) ? $records[$activity->record_id] : ''}}</td>
                        @if ($activity->type == 'Tasks')
                        <td>
                            <a href="{{ route('activities.edit',$activity->id)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('activities.destroy', $activity->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$activities->render()}}
        </div>
    </div>
@endsection
