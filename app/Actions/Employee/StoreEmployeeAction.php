<?php

namespace App\Actions\Employee;

use App\Repositories\EmployeeRepository;

class StoreEmployeeAction
{
    public function __construct(private EmployeeRepository $repository) {}

    public function handle(array $data)
    {
        return $this->repository->create($data);
    }
}
