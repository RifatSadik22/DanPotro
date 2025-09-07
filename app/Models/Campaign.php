<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'target_amount',
        'current_amount',
        'image',
        'status',
        'end_date',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'end_date' => 'date',
    ];

    /**
     * Get the donations for the campaign.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the progress percentage of the campaign.
     */
    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount == 0) {
            return 0;
        }
        return round(($this->current_amount / $this->target_amount) * 100, 2);
    }

    /**
     * The users that saved the campaign.
     */
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_campaigns')
                    ->withTimestamps();
    }
}
