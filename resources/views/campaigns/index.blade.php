@extends('layouts.app')

@section('title', 'Campaigns - DanPotro')

@section('content')
<div class="card mb-2">
    <form method="GET" action="{{ route('campaigns.index') }}" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search campaigns..." />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    @if(request('search'))
        <p class="mt-1 text-muted">Showing results for: "{{ request('search') }}"</p>
    @endif
  </div>
<div class="grid grid-3">
    @foreach($campaigns as $campaign)
        <div class="campaign-card">
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
                    
                    @auth
                        @php
                            $saved = auth()->user()->savedCampaigns->contains($campaign->id);
                        @endphp
                        <button class="btn {{ $saved ? 'btn-danger unsave-btn' : 'btn-success save-btn' }}" 
                                data-id="{{ $campaign->id }}"
                                data-save-url="{{ route('campaign.save', $campaign->id) }}"
                                data-unsave-url="{{ route('campaign.unsave', $campaign->id) }}">
                            {{ $saved ? 'Unsave' : 'Save' }}
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    @endforeach
</div>
@if(method_exists($campaigns, 'links'))
    {{ $campaigns->appends(request()->only('search'))->links() }}
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';

    function saveHandler() {
        const id = this.dataset.id;
        const btn = this;
        const url = btn.dataset.saveUrl;
        
        console.log('Attempting to save campaign:', id);
        
        fetch(url, { 
            method: 'POST', 
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
            console.log('Save response:', data);
            if(data.status === 'saved'){
                btn.textContent = 'Unsave';
                btn.classList.remove('btn-success', 'save-btn');
                btn.classList.add('btn-danger', 'unsave-btn');
                btn.removeEventListener('click', saveHandler);
                btn.addEventListener('click', unsaveHandler);
                
                // Show success message
                alert('Campaign saved successfully!');
            } else if(data.status === 'error') {
                alert('Error: ' + data.message);
            }
        })
        .catch(err => {
            console.error('Error saving campaign:', err);
            alert('An error occurred while saving the campaign: ' + err.message);
        });
    }

    function unsaveHandler() {
        const id = this.dataset.id;
        const btn = this;
        const url = btn.dataset.unsaveUrl;
        
        console.log('Attempting to unsave campaign:', id);
        
        fetch(url, { 
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
            console.log('Unsave response:', data);
            if(data.status === 'removed'){
                btn.textContent = 'Save';
                btn.classList.remove('btn-danger', 'unsave-btn');
                btn.classList.add('btn-success', 'save-btn');
                btn.removeEventListener('click', unsaveHandler);
                btn.addEventListener('click', saveHandler);
                
                // Show success message
                alert('Campaign removed from saved list!');
            } else if(data.status === 'error') {
                alert('Error: ' + data.message);
            }
        })
        .catch(err => {
            console.error('Error removing campaign:', err);
            alert('An error occurred while removing the campaign: ' + err.message);
        });
    }

    document.querySelectorAll('.save-btn').forEach(btn => btn.addEventListener('click', saveHandler));
    document.querySelectorAll('.unsave-btn').forEach(btn => btn.addEventListener('click', unsaveHandler));
});
</script>
@endsection
