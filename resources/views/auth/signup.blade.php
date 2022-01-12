@extends('templates.default')

@section('content')
    <h1 class="mt-5 text-primary">Sign Up</h1>
    <form class="mt-5 col-5" role="form" method="post" action="{{ route('auth.signup') }}">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" aria-describedby="emailHelp" value="{{ Request::old('email') ?: '' }}">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else. - Mark</div>
            @if ($errors->has('email'))
                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" name="username" aria-describedby="emailHelp" value="{{ Request::old('username') ?: '' }}">
            </div>
            @if ($errors->has('username'))
                <span class="invalid-feedback" style="display:block;">{{ $errors->first('username') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" value="{{ Request::old('password') ?: '' }}">
            @if ($errors->has('password'))
                <span class="invalid-feedback">{{ $errors->first('password') }}</span>
            @endif
        </div>
        <div class="mb-3 form-check">
            <!-- <input type="checkbox" class="form-check-input" id="exampleCheck1"> -->
            <label class="form-check-label" for="exampleCheck1">By signing up you agree to the <a href="#">Terms of Service</a>.</label>
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
    </form>
@stop