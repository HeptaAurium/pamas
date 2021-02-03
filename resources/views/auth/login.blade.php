@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form method="POST" action="{{ route('login') }}" class="sign-in-form">
                    @csrf
                    <h2 class="title">Sign In</h2>
                    <div class="input-field">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <input id="email" type="email" 
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Email">

                        {{-- @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock" aria-hidden="true"></i>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password">
                        {{-- @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}
                    </div>
                    <input type="submit" value="Login" class="btn solid">

                    {{-- @if (Route::has('password.request'))
                    <a class="btn-link" href="{{ route('password.request') }}" style="margin-top: 16px;">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif --}}

                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>P@Mas Payroll Processing System</h3>
                    <p>
                        Powered By <a href="http://ichaelinc.co.ke" target="_blank" rel="noopener noreferrer">iChael
                            Systems</a>
                    </p>
                </div>
                <img src="{{ asset('svg/undraw_revenue_3osh.svg') }}" class="image" alt="">
            </div>
        </div>
    </div>
@endsection
