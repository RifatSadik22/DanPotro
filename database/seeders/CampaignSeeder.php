<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Campaign;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Campaign::create([
            'title' => 'Help Build a School',
            'description' => 'We are raising funds to build a new school in a rural community. This school will provide education to over 200 children who currently have to walk 5 miles to the nearest school. Your donation will help us provide a better future for these children.',
            'target_amount' => 50000.00,
            'current_amount' => 15000.00,
            'status' => 'active',
            'end_date' => now()->addMonths(3),
        ]);

        Campaign::create([
            'title' => 'Medical Supplies for Hospital',
            'description' => 'Our local hospital is in urgent need of medical supplies and equipment. We are raising funds to purchase essential medical equipment that will help save lives and improve healthcare services in our community.',
            'target_amount' => 25000.00,
            'current_amount' => 8000.00,
            'status' => 'active',
            'end_date' => now()->addMonths(2),
        ]);

        Campaign::create([
            'title' => 'Disaster Relief Fund',
            'description' => 'Recent natural disasters have left many families homeless and in need of immediate assistance. Your donation will help provide food, shelter, and basic necessities to affected families.',
            'target_amount' => 100000.00,
            'current_amount' => 45000.00,
            'status' => 'active',
            'end_date' => now()->addMonths(1),
        ]);
    }
}
