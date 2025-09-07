<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;

class SavedCampaignController extends Controller
{
    public function index()
    {
        $campaigns = auth()->user()->savedCampaigns()->latest()->get();
        return view('campaigns.saved', compact('campaigns'));
    }

    public function save($id)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated!',
            ], 401);
        }
        
        $user->savedCampaigns()->syncWithoutDetaching([$id]);

        return response()->json([
            'status' => 'saved',
            'message' => 'Campaign saved successfully!',
        ]);
    }

    public function unsave($id)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated!',
            ], 401);
        }
        
        $user->savedCampaigns()->detach($id);

        return response()->json([
            'status' => 'removed',
            'message' => 'Campaign removed successfully!',
        ]);
    }
}
