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
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Campaign::where('status', 'active');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $campaigns = $query->latest()->get();
        
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