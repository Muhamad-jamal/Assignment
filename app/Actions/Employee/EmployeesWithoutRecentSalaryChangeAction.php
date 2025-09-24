<?php

namespace App\Actions\Employee;

use App\Services\EmployeeService;

class EmployeesWithoutRecentSalaryChangeAction
{
    public function __construct(private EmployeeService $service) {}


    public function handle(int $month)
    {
        return $this->service->getEmployeesWithoutRecentSalaryChange($month);
    }
}
