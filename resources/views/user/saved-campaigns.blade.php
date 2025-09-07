<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Saved Campaigns - Donation Tracker</title>
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

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #3b82f6;
            text-decoration: none;
            margin-bottom: 2rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #2563eb;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-header h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .page-header p {
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
            position: relative;
        }

        .campaign-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .saved-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 0.3rem;
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
            line-height: 1.3;
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
            flex-wrap: wrap;
            gap: 0.5rem;
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

        .status-completed {
            background: #dbeafe;
            color: #2563eb;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #dc2626;
        }

        .saved-date {
            color: #64748b;
            font-size: 0.9rem;
        }

        .campaign-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
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
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fca5a5;
            padding: 0.5rem;
            width: 40px;
            height: 40px;
        }

        .btn-danger:hover {
            background: #fca5a5;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            color: #374151;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .empty-state p {
            color: #64748b;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .browse-link {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .browse-link:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-2px);
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            border-left: 4px solid;
        }

        .alert-success {
            background: #dcfdf7;
            color: #059669;
            border-left-color: #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            border-left-color: #ef4444;
        }

        .stats-summary {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #3b82f6;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .campaigns-grid {
                grid-template-columns: 1fr;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .campaign-actions {
                flex-direction: column;
                gap: 0.8rem;
            }

            .btn-primary {
                width: 100%;
            }

            .stats-summary {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back Link -->
        <a href="{{ route('user.dashboard') }}" class="back-link">
            ← Back to Dashboard
        </a>

        <!-- Page Header -->
        <div class="page-header">
            <h1>My Saved Campaigns</h1>
            <p>Keep track of campaigns you want to support later</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                ❌ {{ session('error') }}
            </div>
        @endif

        @if($savedCampaigns->count() > 0)
            <!-- Stats Summary -->
            <div class="stats-summary">
                <div class="stat-item">
                    <div class="stat-number">{{ $savedCampaigns->total() }}</div>
                    <div class="stat-label">Total Saved</div>
                </div>
                <div class="stat-item">
                    @php
                        $activeSaved = 0;
                        foreach($savedCampaigns as $saved) {
                            if($saved->campaign && $saved->campaign->status === 'active') {
                                $activeSaved++;
                            }
                        }
                    @endphp
                    <div class="stat-number">{{ $activeSaved }}</div>
                    <div class="stat-label">Active Campaigns</div>
                </div>
                <div class="stat-item">
                    @php
                        $totalRaised = 0;
                        foreach($savedCampaigns as $saved) {
                            if($saved->campaign) {
                                $totalRaised += $saved->campaign->current_amount;
                            }
                        }
                    @endphp
                    <div class="stat-number">${{ number_format($totalRaised, 0) }}</div>
                    <div class="stat-label">Total Raised</div>
                </div>
                <div class="stat-item">
                    @php
                        $totalTarget = 0;
                        foreach($savedCampaigns as $saved) {
                            if($saved->campaign) {
                                $totalTarget += $saved->campaign->target_amount;
                            }
                        }
                    @endphp
                    <div class="stat-number">${{ number_format($totalTarget, 0) }}</div>
                    <div class="stat-label">Total Targets</div>
                </div>
            </div>

            <!-- Campaigns Grid -->
            <div class="campaigns-grid">
                @foreach($savedCampaigns as $savedCampaign)
                    @if($savedCampaign->campaign)
                        @php $campaign = $savedCampaign->campaign; @endphp
                        <div class="campaign-card">
                            <div class="saved-badge">
                                ❤️ Saved
                            </div>
                            
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
                                            ${{ number_format($campaign->current_amount, 0) }} raised
                                        </span>
                                        <span class="progress-target">
                                            of ${{ number_format($campaign->target_amount, 0) }}
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
                                    <span class="saved-date">
                                        Saved: {{ $savedCampaign->created_at->format('M j, Y') }}
                                    </span>
                                </div>
                                
                                <div class="campaign-actions">
                                    <a href="{{ route('campaigns.show', $campaign->id) }}" class="btn btn-primary">
                                        View Details
                                    </a>
                                    <form action="{{ route('campaign.unsave', $campaign->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Remove from saved campaigns?')" title="Remove from saved">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Pagination -->
            @if($savedCampaigns->hasPages())
                <div class="pagination-wrapper">
                    {{ $savedCampaigns->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">💛</div>
                <h3>No Saved Campaigns Yet</h3>
                <p>You haven't saved any campaigns yet. Browse our active campaigns to find causes you care about and save them for later!</p>
                <a href="{{ route('campaigns.index') }}" class="browse-link">
                    Browse Active Campaigns
                </a>
            </div>
        @endif
    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.3s ease';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 300);
            });
        }, 5000);

        // Confirm before removing saved campaigns
        document.querySelectorAll('.btn-danger').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to remove this campaign from your saved list?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>