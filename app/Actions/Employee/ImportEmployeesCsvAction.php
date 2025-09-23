<?php

namespace App\Actions\Employee;

use App\Services\EmployeeService;
use Illuminate\Http\UploadedFile;

class ImportEmployeesCsvAction
{
    public function __construct(private EmployeeService $service) {}

    public function handle(UploadedFile $file): int
    {
        return $this->service->importCsv($file);
    }
}
