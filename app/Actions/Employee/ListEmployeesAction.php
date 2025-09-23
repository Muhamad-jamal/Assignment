<?php

namespace App\Actions\Employee;

use App\Services\EmployeeService;

class ListEmployeesAction
{
    public function __construct(private EmployeeService $service) {}

    public function handle()
    {
        return $this->service->list();
    }
}
