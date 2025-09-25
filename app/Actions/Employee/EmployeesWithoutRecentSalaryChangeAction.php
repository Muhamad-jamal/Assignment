<?php

namespace App\Actions\Employee;

use App\Repositories\EmployeeRepository;

class EmployeesWithoutRecentSalaryChangeAction
{
    public function __construct(private EmployeeRepository $repository) {}

    public function handle(int $month)
    {
        return $this->repository->withoutRecentSalaryChange($month);
    }
}
