<?php

namespace App\Actions\Employee;

use App\Services\EmployeeService;
use App\Models\Employee;

class DeleteEmployeeAction
{
    public function __construct(private EmployeeService $service) {}

    public function handle(Employee $employee)
    {
        return $this->service->destroy($employee);
    }
}
