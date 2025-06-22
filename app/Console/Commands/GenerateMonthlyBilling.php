<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\BillingRecord;
use Carbon\Carbon;

class GenerateMonthlyBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    //protected $description = 'Command description';
    protected $signature = 'billing:generate-monthly';
    protected $description = 'Generate monthly billing for premium users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle_bk()
    {
        return 0;
    }

    public function handle()
    {
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $premiumUsers = User::whereHas('subscriptionTier', function($q) {
            $q->where('name', 'premium');
        })->get();

        foreach ($premiumUsers as $user) {
            // Sum last month's usage from ApiUsageCounter
            $monthlyCalls = $user->usageCounters()
                ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
                ->sum('calls_count');

            $includedCalls = 10000;
            $extraCalls = max(0, $monthlyCalls - $includedCalls);

            $costPerExtraCall = $user->subscriptionTier->extra_call_cost ?? 0.01;

            $amountCharged = $extraCalls * $costPerExtraCall;

            // Upsert billing record
            BillingRecord::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'billing_month' => $lastMonthStart,
                ],
                [
                    'included_calls' => $includedCalls,
                    'extra_calls' => $extraCalls,
                    'amount_charged' => $amountCharged,
                ]
            );

            $this->info("Billed user {$user->id} for month {$lastMonthStart}: Extra calls: {$extraCalls}, Amount: \${$amountCharged}");
        }

        $this->info('Monthly billing generation completed at ' . now());
    }
}
