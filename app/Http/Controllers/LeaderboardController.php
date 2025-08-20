<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $topDonors = User::where('total_donated', '>', 0)
            ->orderBy('total_donated', 'desc')
            ->take(10)
            ->get();
            
        return view('leaderboard.index', compact('topDonors'));
    }
}
