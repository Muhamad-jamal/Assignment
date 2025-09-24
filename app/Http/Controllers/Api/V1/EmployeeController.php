<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Employee;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Employee\ShowEmployeeAction;
use App\Actions\Employee\ListEmployeesAction;
use App\Actions\Employee\StoreEmployeeAction;
use App\Actions\Employee\DeleteEmployeeAction;
use App\Actions\Employee\UpdateEmployeeAction;
use App\Actions\Employee\SearchEmployeesAction;
use App\Http\Resources\Api\V1\EmployeeResource;
use App\Actions\Employee\ExportEmployeesCsvAction;
use App\Actions\Employee\ImportEmployeesCsvAction;
use App\Http\Requests\Api\V1\StoreEmployeeRequest;
use App\Actions\Employee\GetManagerHierarchyAction;
use App\Http\Requests\Api\V1\UpdateEmployeeRequest;
use App\Actions\Employee\EmployeesWithoutRecentSalaryChangeAction;

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

    public function update(UpdateEmployeeRequest  $request, Employee $employee, UpdateEmployeeAction $action)
    {
        $action->handle($employee, $request->validated());
        return $this->updateResponse();
    }

    public function destroy(Employee $employee, DeleteEmployeeAction $action)
    {
        $action->handle($employee);
        return $this->destroyResponse('Employee deleted successfully');
    }

    public function hierarchyNames(Employee $employee, GetManagerHierarchyAction $action)
    {
        $hierarchy = $action->handle($employee, false);
        return $this->showResponse('Managerial hierarchy (names)', $hierarchy);
    }

    public function hierarchyNamesSalaries(Employee $employee, GetManagerHierarchyAction $action)
    {
        $hierarchy = $action->handle($employee, true);
        return $this->showResponse('Managerial hierarchy (names & salaries)', $hierarchy);
    }

    public function search(Request $request, SearchEmployeesAction $action)
    {
        $filters = $request->only(['name', 'salary']);
        $employees = $action->handle($filters);

        return $this->listResponse('Employees fetched successfully', EmployeeResource::collection($employees));
    }
    public function withoutRecentSalaryChange(Request $request, EmployeesWithoutRecentSalaryChangeAction $action)
    {
        $request->validate([
            'months' => 'required|integer|min:1',
        ]);

        $employees = $action->handle($request->input('months'));

        return $this->listResponse(
            'Employees without recent salary change retrieved successfully',
            EmployeeResource::collection($employees)
        );
    }

    public function exportCsv(ExportEmployeesCsvAction $action)
    {
        return $action->handle();
    }

    public function importCsv(Request $request, ImportEmployeesCsvAction $action)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $count = $action->handle($request->file('file'));

        return $this->storeResponse(null, "{$count} employees imported successfully");
    }
}
