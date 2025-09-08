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
    <div class="card text-center">
        <h3>{{ $totalCampaigns }}</h3>
        <p>Total Campaigns</p>
    </div>
    <div class="card text-center">
        <h3>{{ $activeCampaigns }}</h3>
        <p>Active Campaigns</p>
    </div>
    <div class="card text-center">
        <h3>{{ $totalDonations }}</h3>
        <p>Total Donations</p>
    </div>
    <div class="card text-center">
        <h3>${{ number_format(\App\Models\Donation::sum('amount'), 2) }}</h3>
        <p>Total Raised</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="card-title">Campaign Management</h2>
            <a href="{{ route('admin.campaigns.create') }}" class="btn btn-secondary">Create New Campaign</a>
        </div>
    </div>
    <div class="card-body">
        @if($campaigns->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Target</th>
                    <th>Raised</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($campaigns as $campaign)
                <tr>
                    <td>{{ $campaign->title }}</td>
                    <td>${{ number_format($campaign->target_amount, 2) }}</td>
                    <td>${{ number_format($campaign->current_amount, 2) }}</td>
                    <td>{{ $campaign->progress_percentage }}%</td>
                    <td>{{ ucfirst($campaign->status) }}</td>
                    <td>{{ optional($campaign->end_date)->format('M d, Y') ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" class="btn btn-secondary">Edit</a>
                        <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this campaign?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No campaigns available.</p>
        @endif
    </div>
</div>
@endsection
