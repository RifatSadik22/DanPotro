<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user
     */
    public function isUser()
    {
        return $this->role === 'user';
    }

    /**
     * Get the donations made by the user
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the saved campaigns for the user
     */
    public function savedCampaigns()
    {
        return $this->hasMany(SavedCampaign::class);
    }

    /**
     * Get the campaigns that the user has saved (many-to-many relationship)
     */
    public function savedCampaignsWithDetails()
    {
        return $this->belongsToMany(Campaign::class, 'saved_campaigns')
                    ->withTimestamps()
                    ->orderBy('saved_campaigns.created_at', 'desc');
    }

    /**
     * Get completed donations only
     */
    public function completedDonations()
    {
        return $this->donations()->where('status', 'completed');
    }

    /**
     * Get pending donations
     */
    public function pendingDonations()
    {
        return $this->donations()->where('status', 'pending');
    }

    /**
     * Get total amount donated by the user
     */
    public function getTotalDonatedAttribute()
    {
        return $this->completedDonations()->sum('amount');
    }

    /**
     * Get the number of campaigns the user has donated to
     */
    public function getCampaignsDonatedToCountAttribute()
    {
        return $this->completedDonations()
                   ->distinct('campaign_id')
                   ->count('campaign_id');
    }

    /**
     * Get the count of saved campaigns
     */
    public function getSavedCampaignsCountAttribute()
    {
        return $this->savedCampaigns()->count();
    }

    /**
     * Get total number of donations made
     */
    public function getTotalDonationsCountAttribute()
    {
        return $this->donations()->count();
    }

    /**
     * Get completed donations count
     */
    public function getCompletedDonationsCountAttribute()
    {
        return $this->completedDonations()->count();
    }

    /**
     * Check if user has saved a specific campaign
     */
    public function hasSavedCampaign($campaignId)
    {
        return $this->savedCampaigns()
                    ->where('campaign_id', $campaignId)
                    ->exists();
    }

    /**
     * Check if user has donated to a specific campaign
     */
    public function hasDonatedToCampaign($campaignId)
    {
        return $this->donations()
                    ->where('campaign_id', $campaignId)
                    ->where('status', 'completed')
                    ->exists();
    }

    /**
     * Get user's donation to a specific campaign
     */
    public function getDonationToCampaign($campaignId)
    {
        return $this->donations()
                    ->where('campaign_id', $campaignId)
                    ->where('status', 'completed')
                    ->sum('amount');
    }

    /**
     * Get user's most recent donations
     */
    public function getRecentDonations($limit = 5)
    {
        return $this->donations()
                    ->with('campaign')
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
    }

    /**
     * Get user's favorite campaigns (most donated to)
     */
    public function getFavoriteCampaigns($limit = 3)
    {
        return Campaign::whereIn('id', 
            $this->completedDonations()
                 ->select('campaign_id')
                 ->groupBy('campaign_id')
                 ->orderByRaw('SUM(amount) DESC')
                 ->limit($limit)
                 ->pluck('campaign_id')
        )->get();
    }

    /**
     * Get user's activity summary
     */
    public function getActivitySummary()
    {
        return [
            'total_donated' => $this->total_donated,
            'campaigns_supported' => $this->campaigns_donated_to_count,
            'saved_campaigns' => $this->saved_campaigns_count,
            'total_donations' => $this->total_donations_count,
            'completed_donations' => $this->completed_donations_count,
            'recent_donations' => $this->getRecentDonations(3)
        ];
    }

    /**
     * Scope to get only admin users
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope to get only regular users
     */
    public function scopeUsers($query)
    {
        return $query->where('role', 'user');
    }

    /**
     * Scope to get users with donations
     */
    public function scopeWithDonations($query)
    {
        return $query->whereHas('donations');
    }

    /**
     * Scope to get top donors
     */
    public function scopeTopDonors($query, $limit = 10)
    {
        return $query->withSum(['donations as total_donated' => function($query) {
                         $query->where('status', 'completed');
                     }], 'amount')
                     ->orderBy('total_donated', 'desc')
                     ->limit($limit);
    }
}