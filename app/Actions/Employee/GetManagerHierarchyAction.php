<?php

namespace App\Actions\Employee;

use App\Models\Employee;
use App\Services\EmployeeService;

class GetManagerHierarchyAction
{
    public function __construct(private EmployeeService $service) {}

  public function handle(Employee $employee, bool $includeSalary = false): array
    {
        return $this->service->getManagerHierarchy($employee, $includeSalary);
    }
}
