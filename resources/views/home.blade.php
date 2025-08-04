@extends('layouts.app')

@section('title', 'Home - DanPotro')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">Welcome to DanPotro</h1>
    </div>
    <div class="card">
        <p class="mb-3">Track and manage donations for various causes and campaigns. Join us in making a difference!</p>
        
        @auth
            <div class="text-center">
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            </div>
        @else
            <div class="text-center">
                <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
            </div>
        @endauth
    </div>
</div>

@if($campaigns->count() > 0)
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Active Campaigns</h2>
    </div>
    <div class="grid grid-3">
        @foreach($campaigns as $campaign)
        <div class="campaign-card">
            @if($campaign->image)
                <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="campaign-image">
            @else
                <div class="campaign-image" style="background: linear-gradient(135deg, #87CEEB, #5F9EA0); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem;">
                    {{ $campaign->title }}
                </div>
            @endif
            <div class="campaign-content">
                <h3 class="campaign-title">{{ $campaign->title }}</h3>
                <p class="campaign-description">{{ Str::limit($campaign->description, 100) }}</p>
                
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $campaign->progress_percentage }}%"></div>
                </div>
                
                <div class="mb-2">
                    <strong>${{ number_format($campaign->current_amount, 2) }}</strong> raised of 
                    <strong>${{ number_format($campaign->target_amount, 2) }}</strong>
                    <span class="text-right">({{ $campaign->progress_percentage }}%)</span>
                </div>
                
                <div class="mb-2">
                    <small>Ends: {{ $campaign->end_date->format('M d, Y') }}</small>
                </div>
                
                <a href="{{ route('campaigns.show', $campaign->id) }}" class="btn btn-primary">View Details</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
<div class="card">
    <div class="text-center">
        <h3>No Active Campaigns</h3>
        <p>Check back later for new campaigns!</p>
    </div>
</div>
@endif
@endsection 