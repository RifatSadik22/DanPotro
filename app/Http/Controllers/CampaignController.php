<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    /**
     * Display a listing of campaigns
     */
    public function index()
    {
        $campaigns = Campaign::where('status', 'active')->latest()->get();
        
        // Load saved campaigns for authenticated user to show correct button states
        if (auth()->check()) {
            auth()->user()->load('savedCampaigns');
        }
        
        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Display the specified campaign
     */
    public function show($id)
    {
        $campaign = Campaign::findOrFail($id);
        
        // Load saved campaigns for authenticated user to show correct button states
        if (auth()->check()) {
            auth()->user()->load('savedCampaigns');
        }
        
        return view('campaigns.show', compact('campaign'));
    }
}