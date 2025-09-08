<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'target_amount',
        'current_amount',
        'image',
        'status',
        'end_date'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The possible status values
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get all possible status values
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled'
        ];
    }

    /**
     * Get the donations for the campaign
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
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
     * Get the saved campaigns records
     */
    public function savedBy()
    {
        return $this->hasMany(SavedCampaign::class);
    }

    /**
     * Get users who saved this campaign
     */
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_campaigns')
                    ->withTimestamps();
    }

    /**
     * Get the count of users who saved this campaign
     */
    public function getSavedCountAttribute()
    {
        return $this->savedBy()->count();
    }

    /**
     * Get the progress percentage
     */
    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount <= 0) {
            return 0;
        }
        return min(($this->current_amount / $this->target_amount) * 100, 100);
    }

    /**
     * Get the remaining amount needed
     */
    public function getRemainingAmountAttribute()
    {
        return max($this->target_amount - $this->current_amount, 0);
    }

    /**
     * Get the number of donors
     */
    public function getDonorsCountAttribute()
    {
        return $this->completedDonations()
                    ->distinct('user_id')
                    ->count('user_id');
    }

    /**
     * Get total donations count
     */
    public function getTotalDonationsCountAttribute()
    {
        return $this->completedDonations()->count();
    }

    /**
     * Get average donation amount
     */
    public function getAverageDonationAttribute()
    {
        $totalDonations = $this->completedDonations()->count();
        if ($totalDonations == 0) {
            return 0;
        }
        return $this->current_amount / $totalDonations;
    }

    /**
     * Check if campaign is active
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE && $this->end_date >= now()->toDateString();
    }

    /**
     * Check if campaign is completed
     */
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if campaign is cancelled
     */
    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Check if campaign has expired
     */
    public function hasExpired()
    {
        return $this->end_date < now()->toDateString();
    }

    /**
     * Check if campaign goal is reached
     */
    public function isGoalReached()
    {
        return $this->current_amount >= $this->target_amount;
    }

    /**
     * Check if this campaign is saved by a specific user
     */
    public function isSavedByUser($userId)
    {
        return $this->savedBy()
                    ->where('user_id', $userId)
                    ->exists();
    }

    /**
     * Get days remaining until end date
     */
    public function getDaysRemainingAttribute()
    {
        $endDate = $this->end_date;
        $today = now()->toDateString();
        
        if ($endDate < $today) {
            return 0;
        }
        
        return now()->diffInDays($endDate);
    }

    /**
     * Get the campaign image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::disk('public')->url($this->image);
        }
        return null;
    }

    /**
     * Get recent donations for this campaign
     */
    public function getRecentDonations($limit = 5)
    {
        return $this->completedDonations()
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
    }

    /**
     * Get top donors for this campaign
     */
    public function getTopDonors($limit = 5)
    {
        return User::whereHas('donations', function($query) {
                        $query->where('campaign_id', $this->id)
                              ->where('status', 'completed');
                    })
                    ->withSum(['donations as total_donated' => function($query) {
                        $query->where('campaign_id', $this->id)
                              ->where('status', 'completed');
                    }], 'amount')
                    ->orderBy('total_donated', 'desc')
                    ->limit($limit)
                    ->get();
    }

    /**
     * Update current amount based on completed donations
     */
    public function updateCurrentAmount()
    {
        $this->current_amount = $this->completedDonations()->sum('amount');
        $this->save();
    }

    /**
     * Get campaign statistics
     */
    public function getStatistics()
    {
        return [
            'target_amount' => $this->target_amount,
            'current_amount' => $this->current_amount,
            'remaining_amount' => $this->remaining_amount,
            'progress_percentage' => $this->progress_percentage,
            'donors_count' => $this->donors_count,
            'total_donations_count' => $this->total_donations_count,
            'average_donation' => $this->average_donation,
            'days_remaining' => $this->days_remaining,
            'saved_count' => $this->saved_count,
            'is_goal_reached' => $this->isGoalReached(),
            'has_expired' => $this->hasExpired()
        ];
    }

    /**
     * Scope to get only active campaigns
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)
                     ->where('end_date', '>=', now()->toDateString());
    }

    /**
     * Scope to get completed campaigns
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope to get cancelled campaigns
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    /**
     * Scope to get expired campaigns
     */
    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now()->toDateString());
    }

    /**
     * Scope to get campaigns with goal reached
     */
    public function scopeGoalReached($query)
    {
        return $query->whereColumn('current_amount', '>=', 'target_amount');
    }

    /**
     * Scope to search campaigns by title or description
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
        });
    }

    /**
     * Scope to get popular campaigns (most donated to)
     */
    public function scopePopular($query, $limit = 10)
    {
        return $query->orderBy('current_amount', 'desc')
                     ->limit($limit);
    }

    /**
     * Scope to get trending campaigns (most recent donations)
     */
    public function scopeTrending($query, $limit = 10)
    {
        return $query->whereHas('donations', function($q) {
                         $q->where('created_at', '>=', now()->subDays(7))
                           ->where('status', 'completed');
                     })
                     ->withCount(['donations as recent_donations_count' => function($q) {
                         $q->where('created_at', '>=', now()->subDays(7))
                           ->where('status', 'completed');
                     }])
                     ->orderBy('recent_donations_count', 'desc')
                     ->limit($limit);
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // When deleting a campaign, delete its image
        static::deleting(function($campaign) {
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }
        });

        // Auto-complete campaigns when goal is reached
        static::updated(function($campaign) {
            if ($campaign->isGoalReached() && $campaign->status === self::STATUS_ACTIVE) {
                $campaign->status = self::STATUS_COMPLETED;
                $campaign->save();
            }
        });
    }
}