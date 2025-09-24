<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        Position::factory()->count(10)->create();
    }
}
