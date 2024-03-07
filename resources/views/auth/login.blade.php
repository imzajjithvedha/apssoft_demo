@extends('layouts.guest')

@section('title', 'Login')

@section('content')

    <h3 class="title">Login</h3>
    <p class="subtitle">Access to our dashboard</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="single-form-input">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @include('includes.input_error', ['field' => 'login_failed'])
        </div>

        <div class="single-form-input position-relative">
            <label for="password" class="form-label">Password</label>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password-text">Forgot password?</a>
            @endif
            <input type="password" class="form-control" id="password" name="password" required>
            <span class="bi bi-eye-slash-fill" id="toggle-password"></span>
            @include('includes.input_error', ['field' => 'login_failed'])
        </div>

        <div class="single-form-input">
            <button type="submit" class="submit-button">Login</button>
        </div>
    </form>

@endsection