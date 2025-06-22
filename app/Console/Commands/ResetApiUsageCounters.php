<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiUsageCounter;

class ResetApiUsageCounters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'command:name';
    protected $signature = 'api:reset-counters';

    public function handle_bk()
    {
        // Option 1: truncate all counters
        ApiUsageCounter::truncate();

        // Or Option 2: reset counts (if you want to keep history)
        // ApiUsageCounter::query()->update(['calls_count' => 0]);

        $this->info('API usage counters reset successfully at ' . now());
    }

    public function handle()
    {
        // Option 1: truncate all counters
        ApiUsageCounter::truncate();

        // Or Option 2: reset counts (if you want to keep history)
        // ApiUsageCounter::query()->update(['calls_count' => 0]);

        $this->info('API usage counters reset successfully at ' . now());
    }

    /**
     * The console command description.
     *
     * @var string
     */
    //protected $description = 'Command description';

    protected $description = 'Reset API usage counters daily';

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
    public function handle_111()
    {
        return 0;
    }
}
