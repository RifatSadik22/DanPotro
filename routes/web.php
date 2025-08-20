<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminCampaignController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\Admin\ReportController;

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
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::resource('campaigns', CampaignController::class)->except(['index', 'show']);
    Route::get('/test-form', function() {
        return view('test-form');
    })->name('test-form');
    Route::patch('/admin/campaigns/{campaign}/status', [AdminCampaignController::class, 'updateStatus'])
         ->name('admin.campaigns.status');
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/generate', [ReportController::class, 'generate'])->name('admin.reports.generate');
});
