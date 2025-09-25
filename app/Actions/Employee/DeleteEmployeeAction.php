<?php

namespace App\Actions\Employee;

use App\Repositories\EmployeeRepository;
use App\Models\Employee;

class DeleteEmployeeAction
{
    public function __construct(private EmployeeRepository $repository) {}

    public function handle(Employee $employee)
    {
        return $this->repository->delete($employee);
    }
}
