<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $donations = $user->donations()->with('campaign')->latest()->get();
        $wishlist = $user->wishlist()->with('campaign')->get();

        return view('user.dashboard', compact('donations', 'wishlist'));
    }
}
