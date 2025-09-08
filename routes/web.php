<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SavedCampaignController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\DonationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public Campaign Routes (accessible to all)
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/{id}', [CampaignController::class, 'show'])->name('campaigns.show');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

// Protected User Routes
Route::middleware('auth')->group(function () {
    // User Dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    // Saved campaigns
    Route::get('/saved-campaigns', [CampaignController::class, 'savedCampaigns'])->name('campaigns.saved');
    // Save routes - support both URL params and both names for compatibility
    Route::post('/campaigns/{id}/save', [CampaignController::class, 'save'])->name('campaign.save');
    Route::post('/campaigns/{campaign}/save', [CampaignController::class, 'save'])->name('campaigns.save');
    Route::delete('/campaigns/{id}/unsave', [CampaignController::class, 'unsaveCampaign'])->name('campaigns.unsave');
    
    // Donation Routes
    Route::post('/campaigns/{id}/donate', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/history', [DonationController::class, 'history'])->name('donations.history');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('dashboard');
    
    // Admin Campaign Management
    Route::get('/campaigns', [CampaignController::class, 'adminIndex'])->name('campaigns.index');
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/campaigns/{id}/edit', [CampaignController::class, 'edit'])->name('campaigns.edit');
    Route::put('/campaigns/{id}', [CampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('/campaigns/{id}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');
    
    // Admin Donation Management
    Route::get('/donations', [DonationController::class, 'adminIndex'])->name('donations.index');
    Route::get('/donations/{id}', [DonationController::class, 'show'])->name('donations.show');
});