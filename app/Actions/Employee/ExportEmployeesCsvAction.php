<?php

namespace App\Actions\Employee;

use App\Services\EmployeeService;

class ExportEmployeesCsvAction
{
    public function __construct(private EmployeeService $service) {}

    public function handle()
    {
        return $this->service->exportCsv();
    }
}
