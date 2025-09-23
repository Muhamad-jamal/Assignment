<?php

namespace App\Services;

use App\Models\Employee;
use App\Repositories\EmployeeRepository;

class EmployeeService
{
    public function __construct(private EmployeeRepository $repository) {}

    public function list()
    {
        return $this->repository->all();
    }

    public function show(int $id): ?Employee
    {
        return $this->repository->find($id);
    }

    public function store(array $data): Employee
    {
        return $this->repository->create($data);
    }

    public function update(Employee $employee, array $data): Employee
    {
        return $this->repository->update($employee, $data);
    }

    public function destroy(Employee $employee): bool
    {
        return $this->repository->delete($employee);
    }
}
