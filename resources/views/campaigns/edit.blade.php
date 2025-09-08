@extends('layouts.app')

@section('title', 'Edit Campaign - DanPotro')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">Edit Campaign: {{ $campaign->title }}</h1>
    </div>
</div>

<div class="card">
    <form method="POST" action="{{ route('campaigns.update', $campaign->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title" class="form-label">Campaign Title</label>
            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $campaign->title) }}" required>
            @error('title')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $campaign->description) }}</textarea>
            @error('description')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="grid grid-2">
            <div class="form-group">
                <label for="target_amount" class="form-label">Target Amount ($)</label>
                <input type="number" id="target_amount" name="target_amount" class="form-control @error('target_amount') is-invalid @enderror" value="{{ old('target_amount', $campaign->target_amount) }}" min="1" step="0.01" required>
                @error('target_amount')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', optional($campaign->end_date)->format('Y-m-d')) }}" required>
                @error('end_date')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="active" {{ old('status', $campaign->status) === 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ old('status', $campaign->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ old('status', $campaign->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="image" class="form-label">Campaign Image (Optional)</label>
            @if($campaign->image)
                <div style="margin-bottom: 1rem;">
                    <img src="{{ asset('storage/' . $campaign->image) }}" alt="Current image" style="max-width: 200px; border-radius: 5px;">
                    <p><small>Current image</small></p>
                </div>
            @endif
            <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            <small style="color: #6c757d;">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
            @error('image')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Campaign</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection 