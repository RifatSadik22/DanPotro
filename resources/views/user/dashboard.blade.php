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
                <p>{{ auth()->user()->created_at->format('M d, Y') }}</p>
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
                    <h3>{{ $wishlist?->count() ?? 0 }}</h3>
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
                            <td style="padding: 1rem;">{{ $donation->created_at->format('M d, Y') }}</td>
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
        @if($wishlist?->count() ?? 0)

            <div class="grid grid-3">
                @foreach($wishlist as $item)
                    <div class="campaign-card">
                        <h3>{{ $item->campaign->title }}</h3>
                        <p>{{ Str::limit($item->campaign->description, 100) }}</p>
                        <div class="campaign-actions">
                            <a href="{{ route('campaigns.show', $item->campaign->id) }}" class="btn btn-primary">View</a>
                            <form action="{{ route('wishlist.remove', $item->campaign->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center">
                <p>No saved campaigns yet.</p>
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