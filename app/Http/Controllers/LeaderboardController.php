<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $topDonors = User::with('donations')
            ->get()
            ->map(function ($user) {
                $user->total_donations = $user->donations->sum('amount');
                return $user;
            })
            ->filter(function ($user) {
                return $user->total_donations > 0;
            })
            ->sortByDesc('total_donations')
            ->take(10);
            
        return view('leaderboard.index', compact('topDonors'));
    }
}
