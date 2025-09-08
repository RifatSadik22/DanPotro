@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>My Donation History</h2>
    </div>
    <div class="card-body">
        @if($donations->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Campaign</th>
                            <th>Amount</th>
                            <th>Message</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donations as $donation)
                        <tr>
                            <td>{{ optional($donation->created_at)->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('campaigns.show', $donation->campaign) }}" class="text-primary">
                                    {{ $donation->campaign->title }}
                                </a>
                            </td>
                            <td class="text-success font-weight-bold">${{ number_format($donation->amount, 2) }}</td>
                            <td>{{ $donation->message ?: 'No message' }}</td>
                            <td>
                                <span class="badge badge-success">{{ ucfirst($donation->status) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($donations->hasPages())
                <div class="mt-4">
                    {{ $donations->links() }}
                </div>
            @endif

            <!-- Summary -->
            <div class="mt-4 p-3 bg-light rounded">
                <h4>Donation Summary</h4>
                <p><strong>Total Donations:</strong> {{ $donations->total() }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($donations->sum('amount'), 2) }}</p>
                @if(auth()->user()->badge)
                    <p><strong>Your Badge:</strong> 
                        <span class="donor-badge donor-badge-{{ strtolower(auth()->user()->badge['name']) }}">
                            <span>{{ auth()->user()->badge['icon'] }}</span>
                            <span>{{ auth()->user()->badge['name'] }}</span>
                        </span>
                    </p>
                @endif
            </div>
        @else
            <div class="text-center">
                <h3>No Donations Yet</h3>
                <p>You haven't made any donations yet. Start supporting causes you care about!</p>
                <a href="{{ route('campaigns.index') }}" class="btn btn-primary">Browse Campaigns</a>
            </div>
        @endif
    </div>
</div>
@endsection
