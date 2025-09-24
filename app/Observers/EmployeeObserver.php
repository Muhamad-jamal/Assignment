<?php

namespace App\Observers;

use App\Models\Employee;
use App\Models\SalaryHistory;
use App\Services\EmployeeService;
use App\Models\Log as EmployeeLog;
use Illuminate\Support\Facades\Log;
use App\Notifications\SalaryChanged;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewEmployeeCreated;

class EmployeeObserver
{
    public function __construct(private EmployeeService $employeeService) {}

    public function created(Employee $employee)
    {
        $this->logAction('created', $employee);

        // Notify manager if exists
        optional($employee->manager)?->notify(new NewEmployeeCreated($employee));
    }

    public function updated(Employee $employee)
    {
        $changes = $employee->getChanges();
        $this->logAction('updated', $employee, $changes);

        // Track salary changes
        if (isset($changes['salary'])) {
            $oldSalary = $employee->getOriginal('salary');
            $newSalary = $changes['salary'];

            $this->storeSalaryHistory($employee, $oldSalary, $newSalary);

            // Notify employee
            $employee->notify(new SalaryChanged($employee, $oldSalary, 'employee'));

            // Notify all managers up to founder
            collect($this->employeeService->getManagersUpToFounder($employee))
                ->each(fn($manager) => $manager->notify(new SalaryChanged($employee, $oldSalary, 'manager')));
        }
    }

    public function deleted(Employee $employee)
    {
        $this->logAction('deleted', $employee);
    }

    protected function storeSalaryHistory(Employee $employee, float $oldSalary, float $newSalary): void
    {
        SalaryHistory::create([
            'employee_id' => $employee->id,
            'changed_by' => Auth::id(),
            'old_salary' => $oldSalary,
            'new_salary' => $newSalary,
            'changed_at' => now(),
        ]);
    }
    protected function logAction(string $action, Employee $employee, array $changes = [])
    {
        $data = $changes ?: $employee->getAttributes();

        // File log
        Log::channel('employee')->info("Employee {$action}", [
            'user_id' => Auth::id(),
            'data' => $data,
        ]);

        // Database log
        EmployeeLog::create([
            'action' => $action,
            'model' => Employee::class,
            'model_id' => $employee->id,
            'changes' => $data,
            'user_id' => Auth::id(),
        ]);
    }
}
