<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:0',
            'end_date' => 'required|date|after:today',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,completed,cancelled'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('campaigns', 'public');
        }

        Campaign::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Campaign created successfully!');
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

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:0',
            'end_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,completed,cancelled'
        ]);

        $data = $request->all();

        // Replace image if uploaded
        if ($request->hasFile('image')) {
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }
            $data['image'] = $request->file('image')->store('campaigns', 'public');
        }

        $campaign->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Campaign updated successfully!');
    }

    /**
     * Remove the specified campaign
     */
    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);

        if ($campaign->image) {
            Storage::disk('public')->delete($campaign->image);
        }

        $campaign->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Campaign deleted successfully!');
    }

    /**
     * Update campaign status
     */
    public function updateStatus(Request $request, Campaign $campaign)
    {
        $request->validate([
            'status' => 'required|in:active,completed,cancelled'
        ]);

        $campaign->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Campaign status updated successfully!');
    }
}