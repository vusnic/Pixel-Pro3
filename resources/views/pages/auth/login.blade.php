@extends('layouts.guest')

@section('title', 'Login - Pxp3')

@section('content')
<h1>Log in to your account</h1>

<form class="row" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="col-12">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control form-control-lg bg-gray-800 border-dark @error('email') is-invalid @enderror" 
                id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control form-control-lg bg-gray-800 border-dark @error('password') is-invalid @enderror" 
                id="password" name="password" required>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>
        
        <button type="submit" class="btn btn-white btn-xl mb-3">Login</button>
        
        <div class="mt-3">
            <p>Don't have an account? Contact Engineering Team.</p>
        </div>
    </div>
</form>
@endsection 