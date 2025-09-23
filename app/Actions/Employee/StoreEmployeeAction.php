<?php

namespace App\Actions\Employee;

use App\Services\EmployeeService;

class StoreEmployeeAction
{
    public function __construct(private EmployeeService $service) {}

    public function handle(array $data)
    {
        return $this->service->store($data);
    }
}
