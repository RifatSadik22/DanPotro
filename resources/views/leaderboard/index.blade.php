@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Top Donors Leaderboard</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Donor</th>
                        <th>Badge</th>
                        <th>Total Donated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topDonors as $index => $donor)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $donor->name }}</td>
                        <td>
                            @if($donor->badge)
                                <span class="donor-badge donor-badge-{{ strtolower($donor->badge['name']) }}">
                                    <span>{{ $donor->badge['icon'] }}</span>
                                    <span>{{ $donor->badge['name'] }}</span>
                                </span>
                            @else
                                <span class="text-gray-500">No badge yet</span>
                            @endif
                        </td>
                        <td>${{ number_format($donor->total_donations, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
