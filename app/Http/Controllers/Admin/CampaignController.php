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
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Quick Stats</h2>
        </div>
        <div class="card">
            <div class="grid grid-2">
                <div class="text-center">
                    <h3>{{ $donations->count() }}</h3>
                    <p>Total Donations</p>
                </div>
                <div class="text-center">
                    <h3>${{ number_format($donations->sum('amount'), 2) }}</h3>
                    <p>Total Amount</p>
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
                                <span class="badge
                                    @if($donation->status === 'completed') badge-success @endif
                                    @if($donation->status === 'pending') badge-warning @endif
                                    @if($donation->status === 'failed') badge-danger @endif">
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
@endsection

<style>
.badge {
    padding: 0.35em 0.65em;
    border-radius: 0.25rem;
    font-size: 0.875em;
    font-weight: 700;
}

.badge-none {
    background-color: #6c757d;
    color: white;
}

.badge-bronze {
    background-color: #cd7f32;
    color: white;
}

.badge-silver {
    background-color: #c0c0c0;
    color: white;
}

.badge-gold {
    background-color: #ffd700;
    color: black;
}
</style>