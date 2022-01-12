@extends('templates.default')

@section('content')
    <h3 class="text-primary mt-5">Update Profile</h3>
    <div class="row mt-5">
        <div class="col-lg-6">
            <form action="{{ route('profile.edit') }}" method="post" role="form" class="form-vertical">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="first_name" class="control-label">First name</label>
                            <input type="text" name="first_name" id="first_name" value="{{ Request::old('first_name') ?: Auth::user()->first_name }}" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}">
                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="last_name" class="control-label">Last name</label>
                            <input type="text" name="last_name" id="last_name" value="{{ Request::old('last_name') ?: Auth::user()->last_name }}" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}">
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="location" class="control-label">Location</label>
                    <input type="text" name="location" id="location" value="{{ Request::old('location') ?: Auth::user()->location }}" class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}">
                    @if ($errors->has('location'))
                        <span class="invalid-feedback">{{ $errors->first('location') }}</span>
                    @endif
                </div>
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
    </div>

@stop