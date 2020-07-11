@extends('layouts.main')
@section('pageTitle')
    <h2 class="display-3" style="margin-top: 100px">Integration</h2>
@endsection
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="content">
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <a class="btn btn-primary btn-lg text-nowrap" href="{{ route('parse.allLookup') }}" style="width: 100%">Get Lookups</a>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <a class="btn btn-primary btn-lg text-nowrap" href="{{ route('parse.allRecords') }}" style="width: 100%">Get Records</a>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <a class="btn btn-primary btn-lg text-nowrap" href="{{ route('parse.fields') }}" style="width: 100%">Get Fields</a>
            </div>
        </div>
    </div>
@endsection
