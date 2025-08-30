<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminCampaignController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DonorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/{id}', [CampaignController::class, 'show'])->name('campaigns.show');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
    Route::post('/wishlist/{campaign}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{campaign}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('/top-donors', [App\Http\Controllers\DashboardController::class, 'topDonors'])
        ->name('top-donors');
    Route::get('/top-three-donors', [DonorController::class, 'topThree'])->name('donors.top-three');
    Route::get('/monthly-donations', [ReportController::class, 'monthlyDonations'])->name('reports.monthly');
    Route::get('/weekly-donations', [ReportController::class, 'weeklyDonations'])->name('reports.weekly');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::resource('campaigns', CampaignController::class)->except(['index', 'show']);
    Route::get('/test-form', function() {
        return view('test-form');
    })->name('test-form');
    Route::patch('/campaigns/{campaign}/status', [AdminCampaignController::class, 'updateStatus'])
         ->name('admin.campaigns.status');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/generate', [AdminReportController::class, 'generate'])->name('admin.reports.generate');
    Route::get('/reports/donations', [AdminReportController::class, 'donationReports'])
        ->name('admin.reports.donations');
});
