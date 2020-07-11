@extends('layouts.main')
@section('pageTitle')
    <h2 class="display-3" style="text-align: center; margin-top: 100px">Create Deal</h2>
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

    <form method="post" action="{{route('deals.store')}}">
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
                <label for="name">Deal name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-6">
                <label for="account">Account</label>
                <select id="account" class="form-control" name="account">
                    @foreach($accounts as $account)
                        <option value="{{$account->id}}">{{$account->Account_Name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-6">
                <label for="type">Type</label>
                <select id="type" class="form-control" name="type">
                    @foreach($fields as $field)
                        @if ($field->api_name == 'Type')
                            @foreach($field->values as $value)
                                <option value="{{$value->display_value}}">{{$value->display_value}}</option>
                            @endforeach
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="amount">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="probability">Probability</label>
                <input type="text" class="form-control" id="probability" name="probability" required>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-12 mb-6">
                <label for="source">Source</label>
                <select id="source" class="form-control" name="source">
                    @foreach($fields as $field)
                        @if ($field->api_name == 'Lead_Source')
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
        <div class="form-row">
            <div class="col-md-12 mb-6">
                <label for="stage">Stage</label>
                <select id="stage" class="form-control" name="stage">
                    @foreach($fields as $field)
                        @if ($field->api_name == 'Stage')
                            @foreach($field->values as $value)
                                <option value="{{$value->display_value}}">{{$value->display_value}}</option>
                            @endforeach
                        @endif
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
