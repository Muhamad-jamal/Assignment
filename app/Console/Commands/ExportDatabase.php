<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ifsnop\Mysqldump\Mysqldump;
use Carbon\Carbon;

class ExportDatabase extends Command
{
    protected $signature = 'db:export';
    protected $description = 'Export the entire database to a SQL file';

    public function handle(): int
    {
        try {
            $fileName = 'backup_' . Carbon::now()->format('Y_m_d_His') . '.sql';
            $filePath = storage_path("backups/{$fileName}");

            // Ensure directory exists
            if (!is_dir(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
                $this->info('Created backup directory.');
            }

            $connection = config('database.connections.mysql');

            $this->info('Exporting database...');

            $dump = new Mysqldump(
                "mysql:host={$connection['host']};dbname={$connection['database']}",
                $connection['username'],
                $connection['password']
            );
            $dump->start($filePath);

            $this->info("Database export completed successfully!");
            $this->info("File saved at: {$filePath}");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Export failed: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
