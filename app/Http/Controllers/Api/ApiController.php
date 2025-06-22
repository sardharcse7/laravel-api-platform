<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillingRecord;

class ApiController extends Controller
{
    // Sample protected endpoint
    public function getData(Request $request)
    {
        return response()->json([
            'message' => 'API data',
            'user' => $request->user()->name,
        ]);
    }

    // Usage summary: daily & monthly usage w/ limits
    public function usageSummary(Request $request)
    {
        $user = $request->user();

       // return response()->json(['message' => 'Usage summary']);

        // Assuming you have usage counters and logs, example (you will customize this):
        $dailyUsage = $user->usageCounters()
            ->where('date', now()->format('Y-m-d'))
            ->first();

        // Monthly usage sum
        $monthlyUsageCount = $user->usageCounters()
            ->whereBetween('date', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
            ->sum('calls_count');

        $subscriptionTier = $user->subscriptionTier;

        return response()->json([
            'daily_limit' => $subscriptionTier->daily_limit,
            'daily_usage' => $dailyUsage ? $dailyUsage->calls_count : 0,
            'monthly_usage' => $monthlyUsageCount,
            'subscription_tier' => $subscriptionTier->name,
        ]);
    }

    // Billing summary only for premium users
    public function billingSummary(Request $request)
    {
        $user = $request->user();

        if ($user->subscriptionTier->name !== 'premium') {
            return response()->json(['message' => 'Not premium'], 403);
        }

        $billingRecords = BillingRecord::where('user_id', $user->id)
            ->orderBy('billing_month', 'desc')
            ->get();

        return response()->json($billingRecords);
    }
}