@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="display-3" style="margin-top: 100px">Update Deal</h1>

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

            <form method="post" action="{{route('deals.update', $deal->id)}}">
                @method('PATCH')
                @csrf
                <div class="form-row">
                    <div class="col-md-12 mb-6">
                        <label for="owner">Owner</label>
                        <select id="owner" class="form-control" name="owner">
                            @foreach($users as $user)
                                <option value="{{$user->id}}" {{ ($user->id == $deal->user_id) ? 'selected' : '' }}>{{$user->first_name . ' ' . $user->last_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-6">
                        <label for="name">Deal name</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{$deal->Deal_Name}}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-6">
                        <label for="account">Account</label>
                        <select id="account" class="form-control" name="account">
                            @foreach($accounts as $account)
                                <option value="{{$account->id}}" {{ ($account->id == $deal->account_id) ? 'selected' : '' }}>{{$account->Account_Name}}</option>
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
                                        <option value="{{$value->display_value}}" {{ ($value->display_value == $deal->Type) ? 'selected' : '' }}>{{$value->display_value}}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="amount">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" value="{{$deal->Amount}}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="probability">Probability</label>
                        <input type="text" class="form-control" id="probability" name="probability" value="{{$deal->Probability}}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-6">
                        <label for="source">Source</label>
                        <select id="source" class="form-control" name="source">
                            @foreach($fields as $field)
                                @if ($field->api_name == 'Lead_Source')
                                    @foreach($field->values as $value)
                                        <option value="{{$value->display_value}}"{{ ($value->display_value == $deal->Lead_Source) ? 'selected' : '' }}>{{$value->display_value}}</option>
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
                                <option value="{{$contact->id}}" {{ ($contact->id == $deal->contact_id) ? 'selected' : '' }}>{{$contact->First_Name . ' '. $contact->Last_Name}}</option>
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
                                        <option value="{{$value->display_value}}" {{ ($value->display_value == $deal->Stage) ? 'selected' : '' }}>{{$value->display_value}}</option>
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
                            <textarea class="form-control" id="description" name="description" >{{$deal->Description}}</textarea>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Submit form</button>
            </form>
        </div>
    </div>
@endsection
