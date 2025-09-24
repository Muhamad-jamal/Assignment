<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\EmployeeRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ExportEmployeesToJson extends Command
{
    protected $signature = 'employees:export-json';
    protected $description = 'Export all employee data to a JSON file';

    public function __construct(private EmployeeRepository $repository)
    {
        parent::__construct();
    }

    public function handle(): int
    {

        try {
            $filePath = $this->getFilePath();

            $employees = $this->repository->all();

            if ($employees->isEmpty()) {
                $this->warn('No employees found to export.');
            }

            File::put($filePath, $employees->toJson(JSON_PRETTY_PRINT));

            $this->info("Employee export completed successfully!");
            $this->info("File saved at: {$filePath}");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Export failed: " . $e->getMessage());
            return Command::SUCCESS;
        }
    }

    private function getFilePath(): string
    {
        $dir = storage_path('backups');

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
            $this->info('Created backups directory.');
        }

        return $dir . '/employees_' . Carbon::now()->format('Y_m_d_His') . '.json';
    }
}
