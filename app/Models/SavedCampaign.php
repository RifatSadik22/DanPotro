<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedCampaign extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'saved_campaigns';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'campaign_id'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that saved the campaign
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the saved campaign
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Check if a campaign is saved by a specific user
     */
    public static function isSaved($userId, $campaignId)
    {
        return self::where('user_id', $userId)
                  ->where('campaign_id', $campaignId)
                  ->exists();
    }

    /**
     * Save a campaign for a user
     */
    public static function saveCampaign($userId, $campaignId)
    {
        return self::firstOrCreate([
            'user_id' => $userId,
            'campaign_id' => $campaignId
        ]);
    }

    /**
     * Remove a saved campaign for a user
     */
    public static function removeSavedCampaign($userId, $campaignId)
    {
        return self::where('user_id', $userId)
                  ->where('campaign_id', $campaignId)
                  ->delete();
    }
}