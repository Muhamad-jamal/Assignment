<?php

namespace App\Actions\Employee;

use App\Repositories\EmployeeRepository;

class SearchEmployeesAction
{
    public function __construct(private EmployeeRepository $repository) {}

    public function handle(array $filters)
    {
        return $this->repository->search($filters);
    }
}
