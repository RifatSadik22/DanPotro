<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class DonorController extends Controller
{
    public function topThree()
    {
        return User::select('users.name', DB::raw('SUM(donations.amount) as total_donated'))
            ->join('donations', 'users.id', '=', 'donations.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_donated')
            ->limit(3)
            ->get();
    }
}
