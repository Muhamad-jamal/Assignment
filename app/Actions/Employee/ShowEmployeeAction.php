<?php

namespace App\Actions\Employee;

use App\Services\EmployeeService;

class ShowEmployeeAction
{
    public function __construct(private EmployeeService $service) {}

    public function handle(int $id)
    {
        return $this->service->show($id);
    }
}
