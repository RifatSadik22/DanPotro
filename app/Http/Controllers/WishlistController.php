<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function add(Request $request, $campaignId)
    {
        auth()->user()->wishlist()->firstOrCreate([
            'campaign_id' => $campaignId
        ]);

        return back()->with('success', 'Campaign added to wishlist');
    }

    public function remove($campaignId)
    {
        auth()->user()->wishlist()
            ->where('campaign_id', $campaignId)
            ->delete();

        return back()->with('success', 'Campaign removed from wishlist');
    }
}
