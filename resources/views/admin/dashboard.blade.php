@extends('layouts.app')

@section('title', 'Admin Dashboard - DanPotro')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">Admin Dashboard</h1>
    </div>
    <div class="card">
        <p>Manage campaigns and monitor donation activities across the platform.</p>
    </div>
</div>

<div class="grid grid-4">
    <div class="card">
        <div class="text-center">
            <h3>{{ $totalCampaigns }}</h3>
            <p>Total Campaigns</p>
        </div>
    </div>
    <div class="card">
        <div class="text-center">
            <h3>{{ $activeCampaigns }}</h3>
            <p>Active Campaigns</p>
        </div>
    </div>
    <div class="card">
        <div class="text-center">
            <h3>{{ $totalDonations }}</h3>
            <p>Total Donations</p>
        </div>
    </div>
    <div class="card">
        <div class="text-center">
            <h3>${{ number_format(\App\Models\Donation::sum('amount'), 2) }}</h3>
            <p>Total Raised</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="card-title">Campaign Management</h2>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('campaigns.create') }}" class="btn btn-primary">Create New Campaign</a>
                <a href="{{ route('test-form') }}" class="btn btn-secondary">Test Form</a>
            </div>
        </div>
    </div>
    <div class="card">
        @if($campaigns->count() > 0)
            <div class="table-responsive">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f8f9fa; border-bottom: 2px solid #87CEEB;">
                            <th style="padding: 1rem; text-align: left;">Title</th>
                            <th style="padding: 1rem; text-align: left;">Target</th>
                            <th style="padding: 1rem; text-align: left;">Raised</th>
                            <th style="padding: 1rem; text-align: left;">Progress</th>
                            <th style="padding: 1rem; text-align: left;">Status</th>
                            <th style="padding: 1rem; text-align: left;">End Date</th>
                            <th style="padding: 1rem; text-align: left;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $campaign)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 1rem;">
                                <a href="{{ route('campaigns.show', $campaign->id) }}" style="color: #87CEEB; text-decoration: none;">
                                    {{ $campaign->title }}
                                </a>
                            </td>
                            <td style="padding: 1rem;">${{ number_format($campaign->target_amount, 2) }}</td>
                            <td style="padding: 1rem;">${{ number_format($campaign->current_amount, 2) }}</td>
                            <td style="padding: 1rem;">
                                <div class="progress-bar" style="width: 100px;">
                                    <div class="progress-fill" style="width: {{ $campaign->progress_percentage }}%"></div>
                                </div>
                                <small>{{ $campaign->progress_percentage }}%</small>
                            </td>
                            <td style="padding: 1rem;">
                                <span style="padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.875rem; 
                                    @if($campaign->status === 'active') background-color: #d4edda; color: #155724; @endif
                                    @if($campaign->status === 'completed') background-color: #cce5ff; color: #004085; @endif
                                    @if($campaign->status === 'cancelled') background-color: #f8d7da; color: #721c24; @endif">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                            </td>
                            <td style="padding: 1rem;">{{ $campaign->end_date->format('M d, Y') }}</td>
                            <td style="padding: 1rem;">
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('campaigns.edit', $campaign->id) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Edit</a>
                                    <form method="POST" action="{{ route('campaigns.destroy', $campaign->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this campaign?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center">
                <h3>No Campaigns Yet</h3>
                <p>Create your first campaign to get started!</p>
                <a href="{{ route('campaigns.create') }}" class="btn btn-primary">Create Campaign</a>
            </div>
        @endif
    </div>
</div>
@endsection 