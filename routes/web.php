<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\Admin\CampaignController as AdminCampaignController;
use App\Http\Controllers\SavedCampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DonorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/{id}', [CampaignController::class, 'show'])->name('campaigns.show');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/history', [DonationController::class, 'history'])->name('donations.history');

    // Saved campaigns
    Route::get('/saved-campaigns', [SavedCampaignController::class, 'index'])->name('campaigns.saved');
    // Unified save route handler to support both named routes and existing JS fetches
    Route::post('/campaigns/{id}/save', [CampaignController::class, 'save'])->name('campaign.save');
    // Additional named route as requested to fix "campaigns.save" references
    Route::post('/campaigns/{campaign}/save', [CampaignController::class, 'save'])->name('campaigns.save');
    Route::delete('/campaigns/{id}/unsave', [SavedCampaignController::class, 'unsave'])->name('campaign.unsave');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::resource('campaigns', AdminCampaignController::class)->except(['index', 'show'])->names([
        'create' => 'admin.campaigns.create',
        'store' => 'admin.campaigns.store',
        'edit' => 'admin.campaigns.edit',
        'update' => 'admin.campaigns.update',
        'destroy' => 'admin.campaigns.destroy'
    ]);
    Route::patch('/campaigns/{campaign}/status', [AdminCampaignController::class, 'updateStatus'])->name('admin.campaigns.status');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/generate', [AdminReportController::class, 'generate'])->name('admin.reports.generate');
    Route::get('/reports/donations', [AdminReportController::class, 'donationReports'])->name('admin.reports.donations');
});
