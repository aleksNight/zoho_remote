@extends('layouts.main')
@section('pageTitle')
    <h2 class="display-3" style="margin-top: 100px">Deals</h2>
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
                <a style="margin: 19px;" href="{{ route('deals.create')}}" class="btn btn-primary">Add new</a>
            </div>
            {{$deals->render()}}
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Name</td>
                    <td>Account</td>
                    <td>Contact</td>
                    <td>Type</td>
                    <td>Amount</td>
                    <td>Revenue</td>
                    <td>Source</td>
                    <td>Stage</td>
                    <td colspan = 2>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($deals as $deal)
                    <tr>
                        <td>{{$deal->Deal_Name}}</td>
                        <td>{{$accounts[$deal->account_id]}}</td>
                        <td>{{$contacts[$deal->contact_id]}}</td>
                        <td>{{$deal->Type}}</td>
                        <td>{{$deal->Amount}}</td>
                        <td>{{$deal->Expected_Revenue}}</td>
                        <td>{{$deal->Lead_Source}}</td>
                        <td>{{$deal->Stage}}</td>

                        <td>
                            <a href="{{ route('deals.edit',$deal->id)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('deals.destroy', $deal->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$deals->render()}}
        </div>
    </div>

@endsection
