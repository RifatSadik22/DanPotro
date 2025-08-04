@extends('layouts.app')

@section('title', 'Test Form - Donation Tracker')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">Test Campaign Creation Form</h1>
    </div>
</div>

<div class="card">
    <form method="POST" action="{{ route('campaigns.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="title" class="form-label">Campaign Title</label>
            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="grid grid-2">
            <div class="form-group">
                <label for="target_amount" class="form-label">Target Amount ($)</label>
                <input type="number" id="target_amount" name="target_amount" class="form-control @error('target_amount') is-invalid @enderror" value="{{ old('target_amount') }}" min="1" step="0.01" required>
                @error('target_amount')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                @error('end_date')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
            <label for="image" class="form-label">Campaign Image (Optional)</label>
            <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            <small style="color: #6c757d;">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
            @error('image')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Campaign</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<div class="card">
    <h3>Debug Information</h3>
    <p><strong>Route:</strong> {{ route('campaigns.store') }}</p>
    <p><strong>CSRF Token:</strong> {{ csrf_token() }}</p>
    <p><strong>User:</strong> {{ auth()->user()->name ?? 'Not logged in' }}</p>
    <p><strong>User Role:</strong> {{ auth()->user()->role ?? 'N/A' }}</p>
</div>
@endsection 