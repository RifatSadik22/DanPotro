@extends('layouts.app')

@section('title', 'Create Campaign - DanPotro')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">Create New Campaign</h1>
        <p>Fill out the form below to create a new donation campaign.</p>
    </div>
</div>

<div class="card">
    <form method="POST" action="{{ route('campaigns.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="title" class="form-label">Campaign Title *</label>
            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Enter campaign title" required>
            @error('title')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description" class="form-label">Description *</label>
            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Describe your campaign and its goals" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="grid grid-2">
            <div class="form-group">
                <label for="target_amount" class="form-label">Target Amount ($) *</label>
                <input type="number" id="target_amount" name="target_amount" class="form-control @error('target_amount') is-invalid @enderror" value="{{ old('target_amount') }}" min="1" step="0.01" placeholder="0.00" required>
                @error('target_amount')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="end_date" class="form-label">End Date *</label>
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
        
        <div class="form-group" style="display: flex; gap: 1rem; align-items: center;">
            <button type="submit" class="btn btn-primary">Create Campaign</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<div class="card">
    <h3>Form Information</h3>
    <ul style="list-style: disc; padding-left: 2rem;">
        <li><strong>Campaign Title:</strong> A clear, descriptive name for your campaign</li>
        <li><strong>Description:</strong> Detailed explanation of what the campaign is for</li>
        <li><strong>Target Amount:</strong> The total amount you want to raise</li>
        <li><strong>End Date:</strong> When the campaign will end (must be in the future)</li>
        <li><strong>Image:</strong> Optional image to represent your campaign</li>
    </ul>
</div>
@endsection 