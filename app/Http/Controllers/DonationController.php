<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:1',
            'donor_name' => 'required|string|max:255',
            'message' => 'nullable|string',
        ]);

        $campaign = Campaign::findOrFail($request->campaign_id);

        if ($campaign->status !== 'active') {
            return back()->withErrors(['campaign' => 'This campaign is not accepting donations.']);
        }

        DB::transaction(function () use ($request, $campaign) {
            // Create the donation
            $donation = Donation::create([
                'user_id' => auth()->id(),
                'campaign_id' => $request->campaign_id,
                'amount' => $request->amount,
                'donor_name' => $request->donor_name,
                'message' => $request->message,
                'status' => 'completed', // For demo purposes, we'll mark as completed immediately
            ]);

            // Update campaign current amount
            $campaign->increment('current_amount', $request->amount);
        });

        return redirect()->route('campaigns.show', $request->campaign_id)
            ->with('success', 'Thank you for your donation! Your contribution has been recorded.');
    }
}
