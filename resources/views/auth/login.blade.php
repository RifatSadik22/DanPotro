@extends('layouts.app')

@section('title', 'Login - DanPotro')

@section('content')
<div class="card" style="max-width: 400px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">Login</h2>
    </div>
    
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
        </div>
        
        <div class="text-center">
            <p>Don't have an account? <a href="{{ route('register') }}" style="color: #87CEEB;">Register here</a></p>
        </div>
    </form>
</div>
@endsection 