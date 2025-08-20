@extends('layouts.app')

@section('title', 'Campaigns - DanPotro')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('campaigns.index') }}" method="GET" class="search-form">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search campaigns..." 
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h1 class="card-title">Active Campaigns</h1>
    </div>
    <div class="card">
        <p>Browse and support various causes and campaigns. Every donation makes a difference!</p>
    </div>
</div>

@if($campaigns->count() > 0)
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
            <p class="campaign-description">{{ Str::limit($campaign->description, 150) }}</p>
            
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
@else
<div class="card">
    <div class="text-center">
        <h3>No Active Campaigns</h3>
        <p>Check back later for new campaigns!</p>
    </div>
</div>
@endif
@endsection