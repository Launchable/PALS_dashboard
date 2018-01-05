@extends('layouts.auth')

@section('title')Password Reset @endsection

@section('content')

    <div class="app-block">
        <div class="app-form">
            <div class="form-header">
                <div class="app-brand"><span class="highlight">Reset your password</span></div>
            </div>
            <form role="form" action="{{ url('/password/email') }}" method="POST">
                {{ csrf_field() }}

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="input-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <span class="input-group-addon" id="basic-addon1">
                                    <i class="fa fa-user" aria-hidden="true"></i></span>
                    <input type="text" name="email" class="form-control" placeholder="Email address"
                           aria-describedby="basic-addon1" value="{{ old('email') }}">
                </div>

                <div class="text-center">
                    <input type="submit" class="btn btn-success btn-submit" value="Send Password Reset Link">
                </div>
            </form>

            <div class="form-line">
                <div class="title">OR</div>
            </div>

            <div class="form-footer">
                <a href="{{ url('login') }}" type="button"
                   class="btn btn-primary btn-sm">
                    <div class="info">
                        <i class="icon fa fa-home" aria-hidden="true"></i>
                        <span class="title">Sign in</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

@endsection
