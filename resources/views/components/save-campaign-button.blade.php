@auth
    <form action="{{ route('campaigns.save', $campaign->id) }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn {{ auth()->user()->savedCampaigns->contains($campaign) ? 'btn-danger' : 'btn-secondary' }}">
            <i class="fas fa-bookmark"></i>
            {{ auth()->user()->savedCampaigns->contains($campaign) ? 'Unsave' : 'Save' }}
        </button>
    </form>
@endauth
