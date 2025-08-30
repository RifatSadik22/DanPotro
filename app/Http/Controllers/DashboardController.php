<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $topDonors = User::select('users.name', DB::raw('SUM(donations.amount) as total_amount'))
            ->join('donations', 'users.id', '=', 'donations.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_amount')
            ->limit(10)
            ->get();

        return view('user.dashboard', compact('topDonors'));
    }

    public function topDonors()
    {
        $topDonors = $this->getTopDonors();
        return view('user.top_donors', compact('topDonors'));
    }

    private function getTopDonors()
    {
        return User::select('users.name', DB::raw('SUM(donations.amount) as total_amount'))
            ->join('donations', 'users.id', '=', 'donations.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_amount')
            ->limit(10)
            ->get();
    }
}
