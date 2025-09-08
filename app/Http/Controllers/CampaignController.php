<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\SavedCampaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    /**
     * Display a listing of active campaigns for public view
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Campaign::where('status', 'active')
                        ->where('end_date', '>=', now());

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $campaigns = $query->orderBy('created_at', 'desc')
                           ->paginate(12);

        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Show campaign details
     */
    public function show($id)
    {
        $campaign = Campaign::with(['donations' => function($query) {
            $query->where('status', 'completed')->orderBy('created_at', 'desc')->take(10);
        }])->findOrFail($id);
        
        $isSaved = false;
        if (Auth::check()) {
            $isSaved = SavedCampaign::where('user_id', Auth::id())
                                  ->where('campaign_id', $id)
                                  ->exists();
        }
        
        $progressPercentage = $campaign->target_amount > 0 
            ? min(($campaign->current_amount / $campaign->target_amount) * 100, 100) 
            : 0;
            
        return view('campaigns.show', compact('campaign', 'isSaved', 'progressPercentage'));
    }

    /**
     * Display admin campaigns listing
     */
    public function adminIndex()
    {
        $campaigns = Campaign::orderBy('created_at', 'desc')->paginate(10);
        
        $stats = [
            'total' => Campaign::count(),
            'active' => Campaign::where('status', 'active')->count(),
            'completed' => Campaign::where('status', 'completed')->count(),
            'cancelled' => Campaign::where('status', 'cancelled')->count(),
        ];
        
        return view('admin.campaigns.index', compact('campaigns', 'stats'));
    }

    /**
     * Show the form for creating a new campaign
     */
    public function create()
    {
        return view('admin.campaigns.create');
    }

    /**
     * Store a newly created campaign
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'target_amount' => 'required|numeric|min:1|max:9999999.99',
            'end_date' => 'required|date|after:today',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,completed,cancelled'
        ]);

        $campaign = new Campaign();
        $campaign->title = $validated['title'];
        $campaign->description = $validated['description'];
        $campaign->target_amount = $validated['target_amount'];
        $campaign->end_date = $validated['end_date'];
        $campaign->status = $validated['status'];
        $campaign->current_amount = 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('campaigns', 'public');
            $campaign->image = $imagePath;
        }

        $campaign->save();

        return redirect()->route('admin.campaigns.index')
                        ->with('success', 'Campaign created successfully!');
    }

    /**
     * Show the form for editing a campaign
     */
    public function edit($id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('admin.campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified campaign
     */
    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'target_amount' => 'required|numeric|min:1|max:9999999.99',
            'end_date' => 'required|date|after_or_equal:today',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,completed,cancelled'
        ]);

        $campaign->title = $validated['title'];
        $campaign->description = $validated['description'];
        $campaign->target_amount = $validated['target_amount'];
        $campaign->end_date = $validated['end_date'];
        $campaign->status = $validated['status'];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }
            
            $imagePath = $request->file('image')->store('campaigns', 'public');
            $campaign->image = $imagePath;
        }

        $campaign->save();

        return redirect()->route('admin.campaigns.index')
                        ->with('success', 'Campaign updated successfully!');
    }

    /**
     * Remove the specified campaign
     */
    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);
        
        // Delete associated image
        if ($campaign->image) {
            Storage::disk('public')->delete($campaign->image);
        }
        
        $campaign->delete();

        return redirect()->route('admin.campaigns.index')
                        ->with('success', 'Campaign deleted successfully!');
    }

    /**
     * Display saved campaigns for the authenticated user
     */
    public function savedCampaigns()
    {
        $user = Auth::user();
        $savedCampaigns = $user->savedCampaigns()
                              ->with('campaign')
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);
        
        return view('user.saved-campaigns', compact('savedCampaigns'));
    }

    /**
     * Save a campaign for the authenticated user
     */
    public function save(Request $request, $id)
    {
        // Support both {id} and {campaign} route params
        $campaignId = $request->route('campaign') ?? $id;
        $campaign = Campaign::findOrFail($campaignId);
        $user = Auth::user();

        // Check if already saved
        $existingSave = SavedCampaign::where('user_id', $user->id)
                                   ->where('campaign_id', $campaign->id)
                                   ->first();

        if ($existingSave) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Campaign is already saved.'
                ], 200);
            }
            return back()->with('info', 'Campaign is already saved!');
        }

        SavedCampaign::create([
            'user_id' => $user->id,
            'campaign_id' => $campaign->id
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'saved',
                'message' => 'Campaign saved successfully.'
            ], 200);
        }

        // Redirect to show if referrer is show page, otherwise back
        return redirect()->route('campaigns.show', $campaign->id)
                         ->with('success', 'Campaign saved successfully!');
    }

    /**
     * Remove a saved campaign
     */
    public function unsaveCampaign($id)
    {
        $user = Auth::user();
        
        SavedCampaign::where('user_id', $user->id)
                    ->where('campaign_id', $id)
                    ->delete();

        return back()->with('success', 'Campaign removed from saved campaigns!');
    }
}