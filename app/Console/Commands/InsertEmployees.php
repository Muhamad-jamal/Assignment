<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\Position;

class InsertEmployees extends Command
{
    protected $signature = 'employees:insert {count : Number of employees to insert}';
    protected $description = 'Insert a given number of employees with a progress bar';

    public function handle(): int
    {
        $count = (int) $this->argument('count');
        $this->info("🚀 Inserting {$count} employees...");

        $positions = $this->getPositions();
        $managers  = [];

        $this->output->progressStart($count);

        for ($i = 0; $i < $count; $i++) {
            $employee = $this->createEmployee($i, $positions, $managers);
            $managers[] = $employee->id;
            $this->output->progressAdvance();
        }

        $this->output->progressFinish();

        $this->newLine(2);
        $this->info("Successfully inserted {$count} employees!");

        return Command::SUCCESS;
    }

    private function getPositions(): array
    {
        return Position::pluck('id')->all();
    }

    private function createEmployee(int $index, array $positions, array $managers): Employee
    {
        return Employee::create([
            'name'        => fake()->name(),
            'email'       => fake()->unique()->safeEmail(),
            'salary'      => fake()->numberBetween(500, 5000),
            'position_id' => $positions ? fake()->randomElement($positions) : null,
            'manager_id'  => $this->pickRandomManager($managers),
            'is_founder'  => $index === 0, // first employee = founder
        ]);
    }

    private function pickRandomManager(array $managers): ?int
    {
        return !empty($managers) ? fake()->randomElement($managers) : null;
    }
}
