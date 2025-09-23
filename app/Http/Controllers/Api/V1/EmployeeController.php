<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Employee;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Actions\Employee\StoreEmployeeAction;
use App\Actions\Employee\UpdateEmployeeAction;
use App\Actions\Employee\DeleteEmployeeAction;
use App\Actions\Employee\ListEmployeesAction;
use App\Actions\Employee\ShowEmployeeAction;
use App\Http\Requests\Api\V1\StoreEmployeeRequest;
use App\Http\Requests\Api\V1\UpdateEmployeeRequest;
use App\Http\Resources\Api\V1\EmployeeResource;

class EmployeeController extends Controller
{
    use ApiResponse;

    public function index(ListEmployeesAction $action)
    {
        $employees = $action->handle();
        return $this->indexResponse(
            'Employees fetched successfully',
            EmployeeResource::collection($employees)
        );
    }

    public function show(Employee $employee, ShowEmployeeAction $action)
    {
        $employee = $action->handle($employee->id);
        return $this->showResponse('Employee details', new EmployeeResource($employee));
    }

    public function store(StoreEmployeeRequest $request, StoreEmployeeAction $action)
    {
        $employee = $action->handle($request->validated());
        return $this->storeResponse(new EmployeeResource($employee), 'Employee created successfully');
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee, UpdateEmployeeAction $action)
    {
        $action->handle($employee, $request->validated());
        return $this->updateResponse();
    }

    public function destroy(Employee $employee, DeleteEmployeeAction $action)
    {
        $action->handle($employee);
        return $this->destroyResponse('Employee deleted successfully');
    }
}
