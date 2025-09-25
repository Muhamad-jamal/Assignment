<?php

namespace App\Repositories;

use App\Models\Position;

class PositionRepository
{
    public function all()
    {
        return Position::get();
    }

    public function find(int $id): ?Position
    {
        return Position::findOrfail($id);
    }

    public function create(array $data): Position
    {
        return Position::create($data);
    }

    public function update(Position $position, array $data): Position
    {
        $position->update($data);
        return $position;
    }

    public function delete(Position $position): bool
    {
        return $position->delete();
    }
}
