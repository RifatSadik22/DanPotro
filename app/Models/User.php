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
        'role',
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
    ];

    /**
     * Get the badge for the user based on total donations.
     * 
     * @return array
     */
    public function getBadgeAttribute()
    {
        $totalDonations = $this->donations()->sum('amount');

        if ($totalDonations > 2000) {
            return [
                'name' => 'Gold',
                'color' => '#FFD700',
                'icon' => '🏆'
            ];
        } elseif ($totalDonations >= 501) {
            return [
                'name' => 'Silver',
                'color' => '#C0C0C0',
                'icon' => '🥈'
            ];
        } elseif ($totalDonations >= 1) {
            return [
                'name' => 'Bronze',
                'color' => '#CD7F32',
                'icon' => '🥉'
            ];
        }
        
        return null;
    }

    /**
     * Get the total donations amount for the user.
     * 
     * @return float
     */
    public function getTotalDonationsAttribute()
    {
        return $this->donations()->sum('amount');
    }

    /**
     * Get the donations for the user.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
