<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Http\UploadedFile;
use App\Repositories\EmployeeRepository;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EmployeeService
{
    public function __construct(private EmployeeRepository $repository) {}

    public function getManagerHierarchy(Employee $employee, bool $includeSalary = false): array
    {
        $managers = $this->getManagersUpToFounder($employee);

        return array_map(
            fn($manager) =>
            $includeSalary ? [$manager->name => $manager->salary] : $manager->name,
            $managers
        );
    }
    public function getManagersUpToFounder(Employee $employee): array
    {
        $managers = [];
        $current = $employee->manager;

        while ($current) {
            $managers[] = $current;
            if ($current->is_founder) break;
            $current = $current->manager;
        }

        return $managers;
    }

    public function exportCsv(): StreamedResponse
    {
        $employees = $this->repository->all();

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=employees.csv",
        ];

        $callback = function () use ($employees) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Position', 'Salary', 'Manager', 'Is Founder']);

            foreach ($employees as $employee) {
                fputcsv($handle, [
                    $employee->id,
                    $employee->name,
                    $employee->email,
                    $employee->position?->title,
                    $employee->salary,
                    $employee->manager?->name,
                    $employee->is_founder ? 'Yes' : 'No',
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCsv(UploadedFile $file): int
    {
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);

        $count = 0;
        while (($row = fgetcsv($handle)) !== false) {
            [$id, $name, $email, $position, $salary, $manager, $is_founder] = $row;

            // 🔹 Lookup position by title or ID
            $positionId = is_numeric($position)
                ? $position
                : \App\Models\Position::where('title', $position)->value('id');

            // 🔹 Lookup manager by ID or email
            $managerId = null;
            if ($manager) {
                $managerId = is_numeric($manager)
                    ? $manager
                    : \App\Models\Employee::where('email', $manager)
                    ->orWhere('name', $manager)
                    ->value('id');
            }

            // Skip row if position not found
            if (!$positionId) {
                continue;
            }

            $this->repository->create([
                'name'       => $name,
                'email'      => $email,
                'position_id' => $positionId,
                'salary'     => $salary,
                'manager_id' => $managerId,
                'is_founder' => strtolower($is_founder) === 'yes',
            ]);

            $count++;
        }

        fclose($handle);

        return $count;
    }
}
