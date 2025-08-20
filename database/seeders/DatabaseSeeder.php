<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Donation;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CampaignSeeder::class,
        ]);

        // Create test user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        // Create test campaign
        $campaign = Campaign::create([
            'title' => 'Test Campaign',
            'description' => 'This is a test campaign',
            'goal' => 1000,
            'status' => 'active'
        ]);

        // Create test donation
        Donation::create([
            'user_id' => $user->id,
            'campaign_id' => $campaign->id,
            'amount' => 100,
            'status' => 'completed'
        ]);
    }
}
