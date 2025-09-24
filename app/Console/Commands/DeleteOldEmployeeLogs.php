<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Log;

class DeleteOldEmployeeLogs extends Command
{
    protected $signature = 'employee-logs:cleanup';
    protected $description = 'Delete employee logs older than one month';

    private const MODEL = 'App\Models\Employee';

    public function handle(): int
    {
        $deleted = Log::where('model', self::MODEL)
            ->where('created_at', '<', now()->subMonth())
            ->delete();

        $this->info("Deleted {$deleted} old employee logs.");

            return Command::SUCCESS;
    }
}
