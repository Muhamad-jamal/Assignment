<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function all()
    {
        return Employee::get();
    }

    public function find(int $id): ?Employee
    {
        return Employee::find($id);
    }

    public function create(array $data): Employee
    {
        return Employee::create($data);
    }

    public function update(Employee $employee, array $data): Employee
    {
        $employee->update($data);
        return $employee;
    }

    public function delete(Employee $employee): bool
    {
        return $employee->delete();
    }

public function search(array $filters = [])
{
    $employees = Employee::query()
        ->when($filters['name'] ?? null, fn($q, $name) =>
            $q->where('name', 'like', "%{$name}%")
        )
        ->when($filters['salary'] ?? null, fn($q, $salary) =>
            $q->where('salary', 'like', "%{$salary}%")
        )
        ->get();

    return $employees;
}



}
