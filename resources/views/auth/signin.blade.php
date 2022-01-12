@extends('templates.default')

@section('content')
    <h1 class="mt-5 text-primary">Sign In</h1>
    <form class="mt-5 col-5" role="form" method="post" action="{{ route('auth.signin') }}">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" aria-describedby="emailHelp" value="{{ Request::old('email') ?: '' }}">
            @if ($errors->has('email'))
                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
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
            <input type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label" for="exampleCheck1">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary">Sign In</button>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
    </form>
@stop