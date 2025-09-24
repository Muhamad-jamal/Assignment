<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveAllLogFiles extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'logs:remove-all';

    /**
     * The console command description.
     */
    protected $description = 'Remove all log files from storage/logs directory';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $logPath = storage_path('logs');
        $files = File::files($logPath);

        collect($files)->each(fn($file) => File::delete($file));

        $this->info($files ? 'All log files have been removed successfully.' : 'No log files found.');

        return Command::SUCCESS;
    }
}
