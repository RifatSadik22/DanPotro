<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Create test campaigns
        $campaigns = [
            [
                'title' => 'Help Local Food Bank',
                'description' => 'Support our local food bank to provide meals for families in need. Every dollar helps feed a family for a day.',
                'target_amount' => 10000.00,
                'current_amount' => 3500.00,
                'status' => 'active',
                'end_date' => now()->addDays(30),
            ],
            [
                'title' => 'School Supplies Drive',
                'description' => 'Help provide school supplies for underprivileged children in our community. Education is the key to a better future.',
                'target_amount' => 5000.00,
                'current_amount' => 1200.00,
                'status' => 'active',
                'end_date' => now()->addDays(45),
            ],
            [
                'title' => 'Animal Shelter Support',
                'description' => 'Support our local animal shelter to provide care, food, and medical treatment for abandoned pets.',
                'target_amount' => 8000.00,
                'current_amount' => 2800.00,
                'status' => 'active',
                'end_date' => now()->addDays(60),
            ],
            [
                'title' => 'Community Garden Project',
                'description' => 'Help establish a community garden to provide fresh vegetables and promote healthy eating in our neighborhood.',
                'target_amount' => 3000.00,
                'current_amount' => 3000.00,
                'status' => 'completed',
                'end_date' => now()->subDays(10),
            ],
            [
                'title' => 'Emergency Relief Fund',
                'description' => 'Support families affected by recent natural disasters. Every contribution helps rebuild lives.',
                'target_amount' => 15000.00,
                'current_amount' => 8500.00,
                'status' => 'active',
                'end_date' => now()->addDays(90),
            ],
            [
                'title' => 'Youth Sports Equipment',
                'description' => 'Provide sports equipment for local youth teams to promote physical activity and teamwork.',
                'target_amount' => 4000.00,
                'current_amount' => 800.00,
                'status' => 'active',
                'end_date' => now()->addDays(25),
            ],
        ];

        foreach ($campaigns as $campaignData) {
            Campaign::create($campaignData);
        }

        // Create test donations
        $donations = [
            // John Doe donations (Bronze level - $75 total)
            ['user_id' => 1, 'campaign_id' => 1, 'amount' => 25.00, 'donor_name' => 'John Doe', 'message' => 'Great cause!', 'status' => 'completed'],
            ['user_id' => 1, 'campaign_id' => 2, 'amount' => 50.00, 'donor_name' => 'John Doe', 'message' => 'Happy to help!', 'status' => 'completed'],

            // Jane Smith donations (Silver level - $350 total)
            ['user_id' => 2, 'campaign_id' => 1, 'amount' => 100.00, 'donor_name' => 'Jane Smith', 'message' => 'Supporting our community', 'status' => 'completed'],
            ['user_id' => 2, 'campaign_id' => 3, 'amount' => 150.00, 'donor_name' => 'Jane Smith', 'message' => 'Love animals!', 'status' => 'completed'],
            ['user_id' => 2, 'campaign_id' => 5, 'amount' => 100.00, 'donor_name' => 'Jane Smith', 'message' => 'Emergency relief is important', 'status' => 'completed'],

            // Mike Johnson donations (Gold level - $750 total)
            ['user_id' => 3, 'campaign_id' => 1, 'amount' => 200.00, 'donor_name' => 'Mike Johnson', 'message' => 'Food security matters', 'status' => 'completed'],
            ['user_id' => 3, 'campaign_id' => 3, 'amount' => 300.00, 'donor_name' => 'Mike Johnson', 'message' => 'Animals need our help', 'status' => 'completed'],
            ['user_id' => 3, 'campaign_id' => 5, 'amount' => 250.00, 'donor_name' => 'Mike Johnson', 'message' => 'Disaster relief is crucial', 'status' => 'completed'],

            // Sarah Wilson donations (Silver level - $400 total)
            ['user_id' => 4, 'campaign_id' => 2, 'amount' => 150.00, 'donor_name' => 'Sarah Wilson', 'message' => 'Education is key', 'status' => 'completed'],
            ['user_id' => 4, 'campaign_id' => 4, 'amount' => 100.00, 'donor_name' => 'Sarah Wilson', 'message' => 'Community gardens rock!', 'status' => 'completed'],
            ['user_id' => 4, 'campaign_id' => 6, 'amount' => 150.00, 'donor_name' => 'Sarah Wilson', 'message' => 'Sports build character', 'status' => 'completed'],

            // Additional donations for variety
            ['user_id' => 1, 'campaign_id' => 3, 'amount' => 30.00, 'donor_name' => 'Anonymous', 'message' => 'Keep up the good work!', 'status' => 'completed'],
            ['user_id' => 2, 'campaign_id' => 6, 'amount' => 75.00, 'donor_name' => 'Anonymous', 'message' => 'Youth development is important', 'status' => 'completed'],
            ['user_id' => 3, 'campaign_id' => 2, 'amount' => 100.00, 'donor_name' => 'Anonymous', 'message' => 'Supporting education', 'status' => 'completed'],
        ];

        foreach ($donations as $donationData) {
            Donation::create($donationData);
        }

        // Create some saved campaigns relationships
        $users = User::where('role', 'user')->get();
        $campaigns = Campaign::where('status', 'active')->get();

        // John saves campaigns 1 and 3
        $users[0]->savedCampaigns()->attach([1, 3]);

        // Jane saves campaigns 2, 3, and 5
        $users[1]->savedCampaigns()->attach([2, 3, 5]);

        // Mike saves campaigns 1, 5, and 6
        $users[2]->savedCampaigns()->attach([1, 5, 6]);

        // Sarah saves campaigns 2, 4, and 6
        $users[3]->savedCampaigns()->attach([2, 4, 6]);

        $this->command->info('Test data seeded successfully!');
        $this->command->info('Users created: john@example.com, jane@example.com, mike@example.com, sarah@example.com, admin@example.com');
        $this->command->info('Password for all users: password');
        $this->command->info('Badge levels: John (Bronze), Jane (Silver), Mike (Gold), Sarah (Silver)');
    }
}
