@extends('layouts.app')

@section('title', $campaign->title . ' - DanPotro')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">{{ $campaign->title }}</h1>
    </div>
</div>

<div class="grid grid-2">
    <div class="card">
        @if($campaign->image)
            <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" style="width: 100%; height: 300px; object-fit: cover; border-radius: 10px; margin-bottom: 1rem;">
        @else
            <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #87CEEB, #5F9EA0); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; border-radius: 10px; margin-bottom: 1rem;">
                {{ $campaign->title }}
            </div>
        @endif
        
        <div class="progress-bar">
            <div class="progress-fill" style="width: {{ $campaign->progress_percentage }}%"></div>
        </div>
        
        <div class="mb-3">
            <h3>${{ number_format($campaign->current_amount, 2) }} raised of ${{ number_format($campaign->target_amount, 2) }}</h3>
            <p>Progress: {{ $campaign->progress_percentage }}%</p>
        </div>
        
        <div class="mb-3">
            <h4>Campaign Details</h4>
            <p>{{ $campaign->description }}</p>
        </div>
        
        <div class="mb-3">
            <h4>Campaign Information</h4>
            <ul style="list-style: none; padding: 0;">
                <li style="padding: 0.5rem 0; border-bottom: 1px solid #e2e8f0;">
                    <strong>Status:</strong> 
                    <span style="padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.875rem; 
                        @if($campaign->status === 'active') background-color: #d4edda; color: #155724; @endif
                        @if($campaign->status === 'completed') background-color: #cce5ff; color: #004085; @endif
                        @if($campaign->status === 'cancelled') background-color: #f8d7da; color: #721c24; @endif">
                        {{ ucfirst($campaign->status) }}
                    </span>
                </li>
                <li style="padding: 0.5rem 0; border-bottom: 1px solid #e2e8f0;">
                    <strong>End Date:</strong> {{ optional($campaign->end_date)->format('M d, Y') ?? 'N/A' }}
                </li>
                <li style="padding: 0.5rem 0;">
                    <strong>Created:</strong> {{ optional($campaign->created_at)->format('M d, Y') ?? 'N/A' }}
                </li>
            </ul>
        </div>

        @auth
        <div class="mb-3">
            @php
                $isSaved = auth()->user()->savedCampaigns->contains($campaign->id);
            @endphp
            <button 
                class="btn save-toggle {{ $isSaved ? 'btn-danger' : 'btn-secondary' }}" 
                data-id="{{ $campaign->id }}"
            >
                <i class="fas fa-bookmark"></i>
                {{ $isSaved ? 'Unsave Campaign' : 'Save Campaign' }}
            </button>
        </div>
        @endauth
    </div>
    
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Make a Donation</h2>
        </div>
        
        @auth
            @if($campaign->status === 'active')
                <form method="POST" action="{{ route('donations.store', ['id' => $campaign->id]) }}">
                    @csrf
                    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                    
                    <div class="form-group">
                        <label for="donor_name" class="form-label">Your Name</label>
                        <input type="text" id="donor_name" name="donor_name" class="form-control @error('donor_name') is-invalid @enderror" value="{{ old('donor_name', auth()->user()->name) }}" required>
                        @error('donor_name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="amount" class="form-label">Donation Amount ($)</label>
                        <input type="number" id="amount" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" min="1" step="0.01" required>
                        @error('amount')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">Message (Optional)</label>
                        <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" rows="3" placeholder="Leave a message of support...">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Make Donation</button>
                    </div>
                </form>
            @else
                <div class="text-center">
                    <h3>Campaign {{ ucfirst($campaign->status) }}</h3>
                    <p>This campaign is no longer accepting donations.</p>
                </div>
            @endif
        @else
            <div class="text-center">
                <h3>Login to Donate</h3>
                <p>Please login or register to make a donation to this campaign.</p>
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                </div>
            </div>
        @endauth
    </div>
</div>

@if($campaign->donations->count() > 0)
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Recent Donations</h2>
    </div>
    <div class="card">
        <div class="grid grid-2">
            @foreach($campaign->donations()->latest()->take(6)->get() as $donation)
            <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; border-left: 4px solid #87CEEB;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <strong>{{ $donation->donor_name }}</strong>
                    <span style="color: #28a745; font-weight: bold;">${{ number_format($donation->amount, 2) }}</span>
                </div>
                @if($donation->message)
                    <p style="margin: 0; font-style: italic; color: #6c757d;">"{{ $donation->message }}"</p>
                @endif
                <small style="color: #6c757d;">{{ optional($donation->created_at)->format('M d, Y') }}</small>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.save-toggle');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const campaignId = this.dataset.id;
            const btn = this;
            
            // Determine if this is a save or unsave action
            const isCurrentlySaved = btn.classList.contains('btn-danger');
            const url = isCurrentlySaved 
                ? "{{ route('campaigns.unsave', $campaign->id) }}" 
                : "{{ route('campaigns.save', $campaign->id) }}";
            const method = isCurrentlySaved ? 'DELETE' : 'POST';

            console.log('Making request to:', url, 'with method:', method);
            
            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            })
            .then(res => {
                console.log('Response status:', res.status);
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                console.log('Response data:', data); // Debug log
                
                if (data.status === 'saved') {
                    btn.classList.remove('btn-secondary');
                    btn.classList.add('btn-danger');
                    btn.innerHTML = '<i class="fas fa-bookmark"></i> Unsave Campaign';
                } else if (data.status === 'removed') {
                    btn.classList.remove('btn-danger');
                    btn.classList.add('btn-secondary');
                    btn.innerHTML = '<i class="fas fa-bookmark"></i> Save Campaign';
                } else if (data.status === 'error') {
                    alert('Error: ' + data.message);
                    return;
                }
                
                // Show success message
                if (data.message) {
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-success';
                    alert.textContent = data.message;
                    alert.style.position = 'fixed';
                    alert.style.top = '20px';
                    alert.style.right = '20px';
                    alert.style.zIndex = '9999';
                    document.body.appendChild(alert);
                    
                    setTimeout(() => {
                        alert.remove();
                    }, 3000);
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('An error occurred: ' + err.message);
            });
        });
    });
});
</script>
@endsection 