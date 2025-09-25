<?php

namespace App\Actions\Employee;

use App\Repositories\EmployeeRepository;

class ListEmployeesAction
{
    public function __construct(private EmployeeRepository $repository) {}

    public function handle()
    {
        return $this->repository->all();
    }
}
