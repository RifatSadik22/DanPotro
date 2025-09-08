@extends('layouts.app')

@section('title', 'Dashboard - DanPotro')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">Welcome, {{ auth()->user()->name }}!</h1>
    </div>
    <div class="card">
        <p>Manage your donations and track your contributions to various campaigns.</p>
    </div>
</div>

<div class="grid grid-2">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Your Profile</h2>
        </div>
        <div class="card">
            <div class="form-group">
                <label class="form-label">Name</label>
                <p>{{ auth()->user()->name }}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <p>{{ auth()->user()->email }}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Member Since</label>
                <p>{{ optional(auth()->user()->created_at)->format('M d, Y') ?? 'N/A' }}</p>
            </div>
            <div class="form-group">
                <label class="form-label">Donor Badge</label>
                <p>
                    @if(auth()->user()->badge)
                        <span class="donor-badge donor-badge-{{ strtolower(auth()->user()->badge['name']) }}">
                            <span>{{ auth()->user()->badge['icon'] }}</span>
                            <span>{{ auth()->user()->badge['name'] }} Donor</span>
                        </span>
                    @else
                        <span class="text-gray-500">No badge yet</span>
                    @endif
                </p>
            </div>
            <div class="form-group">
                <label class="form-label">Total Donations</label>
                <p>${{ number_format(auth()->user()->total_donations, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Quick Stats</h2>
        </div>
        <div class="card">
            <div class="grid grid-3">
                <div class="text-center">
                    <h3>{{ $donations->count() }}</h3>
                    <p>Total Donations</p>
                </div>
                <div class="text-center">
                    <h3>${{ number_format($donations->sum('amount'), 2) }}</h3>
                    <p>Total Amount</p>
                </div>
                <div class="text-center">
                    <h3>{{ $savedCampaigns->count() }}</h3>
                    <p>Saved Campaigns</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Your Donation History</h2>
    </div>
    <div class="card">
        @if($donations->count() > 0)
            <div class="table-responsive">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f8f9fa; border-bottom: 2px solid #87CEEB;">
                            <th style="padding: 1rem; text-align: left;">Campaign</th>
                            <th style="padding: 1rem; text-align: left;">Amount</th>
                            <th style="padding: 1rem; text-align: left;">Date</th>
                            <th style="padding: 1rem; text-align: left;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donations as $donation)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 1rem;">
                                <a href="{{ route('campaigns.show', $donation->campaign->id) }}" style="color: #87CEEB; text-decoration: none;">
                                    {{ $donation->campaign->title }}
                                </a>
                            </td>
                            <td style="padding: 1rem;">${{ number_format($donation->amount, 2) }}</td>
                            <td style="padding: 1rem;">{{ optional($donation->created_at)->format('M d, Y') }}</td>
                            <td style="padding: 1rem;">
                                <span style="padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.875rem; 
                                    @if($donation->status === 'completed') background-color: #d4edda; color: #155724; @endif
                                    @if($donation->status === 'pending') background-color: #fff3cd; color: #856404; @endif
                                    @if($donation->status === 'failed') background-color: #f8d7da; color: #721c24; @endif">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center">
                <h3>No Donations Yet</h3>
                <p>Start making a difference by donating to campaigns!</p>
                <a href="{{ route('campaigns.index') }}" class="btn btn-primary">Browse Campaigns</a>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Saved Campaigns</h2>
    </div>
    <div class="card">
        @if($savedCampaigns->count() > 0)
            <div class="grid grid-3">
                @foreach($savedCampaigns as $campaign)
                    <div class="campaign-card" id="dashboard-campaign-{{ $campaign->id }}">
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
                            
                            <div class="flex gap-2">
                                <a href="{{ route('campaigns.show', $campaign->id) }}" class="btn btn-primary">View Details</a>
                                <button 
                                    class="btn btn-danger remove-campaign" 
                                    data-id="{{ $campaign->id }}"
                                    data-title="{{ $campaign->title }}"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center">
                <h3>No Saved Campaigns</h3>
                <p>You haven't saved any campaigns yet. Start exploring and save campaigns you're interested in!</p>
                <a href="{{ route('campaigns.index') }}" class="btn btn-primary">Browse Campaigns</a>
            </div>
        @endif
    </div>
</div>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Top Donors</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donor Name</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Donations</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($topDonors as $donor)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $donor->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($donor->total_amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const removeButtons = document.querySelectorAll('.remove-campaign');

    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const campaignId = this.dataset.id;
            const campaignTitle = this.dataset.title;
            const campaignCard = this.closest('.campaign-card');

            if (confirm(`Are you sure you want to remove "${campaignTitle}" from your saved campaigns?`)) {
                fetch(`/campaigns/${campaignId}/unsave`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    
                    if (data.status === 'removed') {
                        // Remove the campaign card from the DOM
                        campaignCard.remove();
                        
                        // Update the saved campaigns count
                        const countElement = document.querySelector('.text-center h3');
                        if (countElement && countElement.textContent.includes('Saved Campaigns')) {
                            const currentCount = parseInt(countElement.textContent);
                            countElement.textContent = currentCount - 1;
                        }
                        
                        // Show success message
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

                        // Check if no campaigns left
                        const remainingCampaigns = document.querySelectorAll('.campaign-card');
                        if (remainingCampaigns.length === 0) {
                            location.reload(); // Reload to show "no campaigns" message
                        }
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('An error occurred: ' + err.message);
                });
            }
        });
    });
});
</script>
@endsection