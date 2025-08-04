<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;

class HomeController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('status', 'active')->latest()->get();
        return view('home', compact('campaigns'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        $donations = $user->donations()->with('campaign')->latest()->get();
        return view('user.dashboard', compact('donations'));
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
