@extends('layouts.app')

@section('title','Saved Campaigns - DanPotro')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Your Saved Campaigns</h2>
        </div>
        <div class="card-body">
            <div id="saved-campaigns">
            @if($campaigns->count() > 0)
                <div class="grid grid-3">
                    @foreach($campaigns as $campaign)
                        <div class="campaign-card" data-id="{{ $campaign->id }}">
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
                                    <small>Ends: {{ optional($campaign->end_date)->format('M d, Y') ?? 'N/A' }}</small>
                                </div>
                                
                                <div class="flex gap-2">
                                    <a href="{{ route('campaigns.show', $campaign->id) }}" class="btn btn-primary">View Details</a>
                                    <button class="btn btn-danger unsave-btn" data-id="{{ $campaign->id }}">Remove</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center">You haven't saved any campaigns yet.</p>
                <div class="text-center mt-3">
                    <a href="{{ route('campaigns.index') }}" class="btn btn-primary">Browse Campaigns</a>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';

    function removeCampaign(card){
        card.remove();
        if(document.querySelectorAll('.campaign-card').length === 0){
            const container = document.getElementById('saved-campaigns');
            container.innerHTML = `
                <p class="text-center">You haven't saved any campaigns yet.</p>
                <div class="text-center mt-3">
                    <a href="{{ route('campaigns.index') }}" class="btn btn-primary">Browse Campaigns</a>
                </div>`;
        }
    }

    document.querySelectorAll('.unsave-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const card = this.closest('.campaign-card');

            console.log('Attempting to remove campaign:', id);

            fetch(`/campaigns/${id}/unsave`, {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': csrfToken, 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => {
                console.log('Response status:', res.status);
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                console.log('Remove response:', data);
                if(data.status === 'removed'){
                    removeCampaign(card);
                    alert('Campaign removed from saved list!');
                } else if(data.status === 'error') {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => {
                console.error('Error removing campaign:', err);
                alert('An error occurred while removing the campaign: ' + err.message);
            });
        });
    });
});
</script>
@endsection



