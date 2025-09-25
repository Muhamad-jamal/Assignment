<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // First employee = founder
        $founder = Employee::factory()->create([
            'is_founder' => true,
            'manager_id' => null,
        ]);

        $employees = Employee::factory()->count(4)->make()->each(function ($employee) use ($founder) {
            $allManagers = Employee::pluck('id')->push($founder->id);
            $employee->manager_id = $allManagers->random();
            $employee->save();
        });
    }
}
