<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('status', 'active')->latest()->get();
        
        // Load saved campaigns for authenticated user to show correct button states
        if (auth()->check()) {
            auth()->user()->load('savedCampaigns');
        }
        
        return view('home', compact('campaigns'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        $donations = $user->donations()->with('campaign')->latest()->get();
        $savedCampaigns = $user->savedCampaigns()->latest()->get();

        $topDonors = User::select('users.name', DB::raw('SUM(donations.amount) as total_amount'))
            ->join('donations', 'users.id', '=', 'donations.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();

        return view('user.dashboard', compact('donations', 'topDonors', 'savedCampaigns'));
    }

    public function adminDashboard()
    {
        $campaigns = Campaign::latest()->get();
        $totalCampaigns = Campaign::count();
        $activeCampaigns = Campaign::where('status', 'active')->count();
        $totalDonations = \App\Models\Donation::count();
        
        return view('admin.dashboard', compact('campaigns', 'totalCampaigns', 'activeCampaigns', 'totalDonations'));
    }
}
