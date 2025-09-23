<?php

namespace App\Actions\Employee;

use App\Services\EmployeeService;
use App\Models\Employee;

class UpdateEmployeeAction
{
    public function __construct(private EmployeeService $service) {}

    public function handle(Employee $employee, array $data)
    {
        return $this->service->update($employee, $data);
    }
}
