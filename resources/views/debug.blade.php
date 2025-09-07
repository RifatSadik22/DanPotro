<!DOCTYPE html>
<html>
<head>
    <title>Debug Save Functionality</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Debug Save Functionality</h1>
    
    @auth
        <p>Logged in as: {{ auth()->user()->name }}</p>
        <p>User ID: {{ auth()->user()->id }}</p>
        
        @if($campaigns->count() > 0)
            <h2>Campaigns:</h2>
            @foreach($campaigns as $campaign)
                <div style="border: 1px solid #ccc; padding: 10px; margin: 10px;">
                    <h3>{{ $campaign->title }}</h3>
                    <p>ID: {{ $campaign->id }}</p>
                    @php
                        $isSaved = auth()->user()->savedCampaigns->contains($campaign->id);
                    @endphp
                    <p>Is Saved: {{ $isSaved ? 'Yes' : 'No' }}</p>
                    <button 
                        class="save-toggle" 
                        data-id="{{ $campaign->id }}"
                        style="padding: 10px; background: {{ $isSaved ? 'red' : 'blue' }}; color: white; border: none; cursor: pointer;"
                    >
                        {{ $isSaved ? 'Unsave' : 'Save' }}
                    </button>
                </div>
            @endforeach
        @else
            <p>No campaigns found.</p>
        @endif
    @else
        <p>Please login to test save functionality.</p>
        <a href="{{ route('login') }}">Login</a>
    @endauth

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.save-toggle');
        console.log('Found buttons:', buttons.length);

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const campaignId = this.dataset.id;
                const btn = this;
                console.log('Clicked button for campaign:', campaignId);

                fetch(`/campaigns/${campaignId}/save`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                })
                .then(res => {
                    console.log('Response status:', res.status);
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    
                    if (data.status === 'saved') {
                        btn.style.background = 'red';
                        btn.textContent = 'Unsave';
                    } else if (data.status === 'removed') {
                        btn.style.background = 'blue';
                        btn.textContent = 'Save';
                    }
                    
                    alert(data.message);
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('An error occurred: ' + err.message);
                });
            });
        });
    });
    </script>
</body>
</html>


