@extends('layouts.app')

@section('title', 'Register - DanPotro')

@section('content')
<div class="card" style="max-width: 400px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">Register</h2>
    </div>
    
    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        
        <div class="form-group">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
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
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
        </div>
        
        <div class="text-center">
            <p>Already have an account? <a href="{{ route('login') }}" style="color: #87CEEB;">Login here</a></p>
        </div>
    </form>
</div>
@endsection 