@extends('layouts.auth')

@section('title')Reset Password @endsection

@section('content')
    <div class="app-block">
        <div class="app-form">
            <div class="form-header">
                <div class="app-brand"><span class="highlight">Password</span> Reset</div>
            </div>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form role="form" method="POST" action="{{ url('/password/reset') }}">
                {{ csrf_field() }}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="input-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <span class="input-group-addon" id="basic-addon1">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </span>
                    <input type="text" name="email" class="form-control" placeholder="Email address"
                           aria-describedby="basic-addon1" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="input-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <span class="input-group-addon" id="basic-addon1">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                    <input type="password" name="password" class="form-control" placeholder="New password"
                           aria-describedby="basic-addon1" value="{{ old('password') }}" required autofocus>
                </div>

                <div class="input-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <span class="input-group-addon" id="basic-addon1">
                        <i class="fa fa-key" aria-hidden="true"></i>
                    </span>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password"
                           aria-describedby="basic-addon1" value="{{ old('password') }}" required autofocus>
                </div>

                <div class="text-center">
                    <input type="submit" class="btn btn-success btn-submit" value="Reset Password">
                </div>
            </form>

        </div>
    </div>
@endsection
