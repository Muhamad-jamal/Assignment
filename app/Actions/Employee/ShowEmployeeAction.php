<?php

namespace App\Actions\Employee;

use App\Repositories\EmployeeRepository;

class ShowEmployeeAction
{
    public function __construct(private EmployeeRepository $repository) {}

    public function handle(int $id)
    {
        return $this->repository->find($id);
    }
}
