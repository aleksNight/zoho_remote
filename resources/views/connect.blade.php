@extends('layouts.main')
@section('pageTitle')

@endsection
@section('content')
    <div class="content">
        @if ($active == 0)
            <h2 class="display-3" style="text-align:center; margin-top: 100px">Get Access Token</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('connect.createAction') }}">
                @csrf
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="clientId">Client Id</label>
                        <input type="text" class="form-control" id="clientId" name="clientId" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="secret">Client Secret</label>
                        <input type="text" class="form-control" id="secret" name="secret" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="code">Generated Code</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="redirectUrl">Url to redirect</label>
                        <input type="text" class="form-control" id="redirectUrl" name="redirectUrl">
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Submit form</button>
            </form>
            <form action="{{ route('connect.updateAction') }}">

            </form>
        @else
            <h2 class="display-3" style="text-align:center; margin-top: 100px">Access Granted</h2>
        @endif
    </div>
@endsection
