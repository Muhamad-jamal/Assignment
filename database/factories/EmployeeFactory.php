<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
use App\Models\Position;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'salary' => $this->faker->numberBetween(500, 5000),
            'position_id' => Position::inRandomOrder()->value('id'),
            'manager_id' => null, // will assign in seeder
            'is_founder' => false,
        ];
    }
}
