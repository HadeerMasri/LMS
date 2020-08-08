@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div id="loading" class="js-page-loader preloader-wrap">
        <div class="spinner">
            <div class="spinner--bar"></div>
            <div class="spinner--bar"></div>
            <div class="spinner--bar"></div>
        </div>
    </div>
    <div class="content py-0">
        <div class="session-wrap signup-2-wrap d-flex align-items-center justify-content-center">
            <div class="session-content contact-form-wrap text-center card shadow-box">
                <div class="sec-tilte">
                    <h3 class="title font-2x mb-7">{{ __('Register') }}</h3>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group text-left">
                        <input  name="name" class="form-control @error('name') is-invalid @enderror" type="text" value="{{ old('name') }}" placeholder="{{ __('Name') }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group text-left">
                        <input name="email" class="form-control @error('email') is-invalid @enderror " type="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group text-left">
                        <input name="password" class="form-control  @error('password') is-invalid @enderror" type="password" value="" placeholder="{{ __('Password') }}">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group text-left">
                        <input name="password_confirmation" class="form-control" type="password" value="" placeholder="{{ __('Confirm Password') }}">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-7 text-left">
                        <button type="submit" class="btn btn-primary d-block">
                            {{ __('Register') }}
                        </button>
                    </div>
                    <div class="form-group text-center mb-0">
                        <div class="mb-0 text-muted font-size-sm">Already Member ?<a class="text-primary ml-1 font-size-sm" href="login.html">Login</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
 </div>
@endsection
