@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')

    <h3 class="title">Forgot Password?</h3>
    <p class="subtitle">Enter your email to get a password reset link</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="single-form-input">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @include('includes.input_error', ['field' => 'email'])
        </div>

        <div class="single-form-input">
            <button type="submit" class="submit-button">Reset Password</button>
        </div>

        <p class="mt-3 mb-0 text-center">Remember your password? <a href="{{ route('login') }}">Login</a></p>

    </form>

@endsection