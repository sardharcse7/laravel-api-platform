<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionTier;

class SubscriptionTiersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        SubscriptionTier::updateOrCreate(
            ['name' => 'free'],
            ['daily_limit' => 100, 'extra_call_cost' => 0]
        );

        SubscriptionTier::updateOrCreate(
            ['name' => 'standard'],
            ['daily_limit' => 1000, 'extra_call_cost' => 0]
        );

        SubscriptionTier::updateOrCreate(
            ['name' => 'premium'],
            ['daily_limit' => 10000, 'extra_call_cost' => 0.01]
        );
    }
}
