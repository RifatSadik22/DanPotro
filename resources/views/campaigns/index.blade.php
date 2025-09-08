<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Campaigns - Donation Tracker</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #87CEEB 0%, #f8fafc 100%);
            min-height: 100vh;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .header h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #64748b;
            font-size: 1.1rem;
        }

        .campaigns-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .campaign-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .campaign-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .campaign-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(45deg, #87CEEB, #b8dff0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            position: relative;
            overflow: hidden;
        }

        .campaign-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .campaign-content {
            padding: 1.5rem;
        }

        .campaign-title {
            color: #2c3e50;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.8rem;
        }

        .campaign-description {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 1.2rem;
            line-height: 1.5;
        }

        .campaign-progress {
            margin-bottom: 1rem;
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .progress-raised {
            color: #059669;
            font-weight: 600;
        }

        .progress-target {
            color: #64748b;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #059669, #10b981);
            transition: width 0.3s ease;
        }

        .campaign-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active {
            background: #dcfdf7;
            color: #059669;
        }

        .end-date {
            color: #64748b;
            font-size: 0.9rem;
        }

        .campaign-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.7rem 1.2rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        .no-campaigns {
            text-align: center;
            padding: 3rem;
            color: #64748b;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #3b82f6;
            text-decoration: none;
            margin-bottom: 2rem;
            font-weight: 500;
        }

        .back-link:hover {
            color: #2563eb;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .campaigns-grid {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('home') }}" class="back-link">
            ← Back to Home
        </a>

        <div class="header">
            <h1>Active Campaigns</h1>
            <p>Support causes you care about and make a difference today</p>
        </div>

        <form action="{{ route('campaigns.index') }}" method="GET" style="margin-bottom: 1.5rem; display: flex; gap: .5rem;">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search campaigns by name or description..."
                style="flex: 1; padding: .8rem 1rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 1rem;"
            >
            <button type="submit" class="btn btn-primary">Search</button>
            @if(request('search'))
                <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">Clear</a>
            @endif
        </form>

        @if($campaigns->count() > 0)
            <div class="campaigns-grid">
                @foreach($campaigns as $campaign)
                    <div class="campaign-card">
                        <div class="campaign-image">
                            @if($campaign->image)
                                <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}">
                            @else
                                <span>{{ $campaign->title }}</span>
                            @endif
                        </div>
                        
                        <div class="campaign-content">
                            <h3 class="campaign-title">{{ $campaign->title }}</h3>
                            <p class="campaign-description">
                                {{ Str::limit($campaign->description, 120) }}
                            </p>
                            
                            <div class="campaign-progress">
                                <div class="progress-info">
                                    <span class="progress-raised">
                                        ${{ number_format($campaign->current_amount, 2) }} raised
                                    </span>
                                    <span class="progress-target">
                                        of ${{ number_format($campaign->target_amount, 2) }}
                                    </span>
                                </div>
                                <div class="progress-bar">
                                    @php
                                        $percentage = $campaign->target_amount > 0 
                                            ? min(($campaign->current_amount / $campaign->target_amount) * 100, 100) 
                                            : 0;
                                    @endphp
                                    <div class="progress-fill" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                            
                            <div class="campaign-meta">
                                <span class="status-badge status-{{ $campaign->status }}">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                                <span class="end-date">
                                    Ends: {{ date('M j, Y', strtotime($campaign->end_date)) }}
                                </span>
                            </div>
                            
                            <div class="campaign-actions">
                                <a href="{{ route('campaigns.show', $campaign->id) }}" class="btn btn-primary">
                                    View Details
                                </a>
                                @auth
                                    <form action="{{ route('campaigns.save', $campaign->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary">
                                            Save Campaign
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $campaigns->appends(['search' => request('search')])->links() }}
            </div>
        @else
            <div class="no-campaigns">
                <h3>No Active Campaigns</h3>
                <p>There are currently no active campaigns available.</p>
            </div>
        @endif
    </div>

    @if(session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif

    @if(session('info'))
        <script>
            alert('{{ session('info') }}');
        </script>
    @endif
</body>
</html>