<?php

namespace App\Observers;

use App\Models\Log as EmployeeLog;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmployeeObserver
{
    public function created(Employee $employee)
    {
        $this->logToFile('created', $employee->getAttributes());

        $this->logChanges('created', $employee, $employee->getAttributes());
    }

    public function updated(Employee $employee)
    {
        $this->logToFile('updated', $employee->getChanges());

        $this->logChanges('updated', $employee, $employee->getChanges());
    }

    public function deleted(Employee $employee)
    {
        $this->logToFile('deleted', $employee->getAttributes());

        $this->logChanges('deleted', $employee, $employee->getAttributes());
    }

    protected function logChanges(string $action, Employee $employee, array $changes = [])
    {
        EmployeeLog::create([
            'action' => $action,
            'model' => Employee::class,
            'model_id' => $employee->id,
            'changes' => $changes ?: null,
            'user_id' => Auth::id(),
        ]);
    }

    protected function logToFile(string $action, array $data)
    {
        Log::channel('employee')->info("Employee {$action}", [
            'user_id' => Auth::id(),
            'data' => $data,
        ]);
    }
}
