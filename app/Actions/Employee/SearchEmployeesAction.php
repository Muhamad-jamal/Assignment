<?php

namespace App\Actions\Employee;

use App\Services\EmployeeService;

class SearchEmployeesAction
{
    public function __construct(private EmployeeService $service) {}

    public function handle(array $filters)
    {
        return $this->service->search($filters);
    }
}
