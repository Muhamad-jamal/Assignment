<?php

namespace App\Actions\Employee;

use App\Repositories\EmployeeRepository;
use App\Models\Employee;

class UpdateEmployeeAction
{
    public function __construct(private EmployeeRepository $repository) {}

    public function handle(Employee $employee, array $data)
    {
        return $this->repository->update($employee, $data);
    }
}
