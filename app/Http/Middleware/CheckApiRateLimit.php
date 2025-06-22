<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiUsageCounter;
use App\Models\ApiUsageLog;

class CheckApiRateLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $today = now()->toDateString();
        $tier = $user->subscriptionTier;

        // Get or create usage counter for today
        $counter = ApiUsageCounter::firstOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            ['calls_count' => 0]
        );

        // Check if user exceeded daily limit
        if ($counter->calls_count >= $tier->daily_limit) {
            // Log the denied request with 429 status
            ApiUsageLog::create([
                'user_id' => $user->id,
                'endpoint' => $request->path(),
                'status_code' => 429,
                'called_at' => now(),
            ]);

            return response()->json(['message' => 'Rate limit exceeded'], 429);
        }

        // Increment usage counter
        $counter->increment('calls_count');

        // Log successful request with 200 status
        ApiUsageLog::create([
            'user_id' => $user->id,
            'endpoint' => $request->path(),
            'status_code' => 200,
            'called_at' => now(),
        ]);

        return $next($request);
    }
}
