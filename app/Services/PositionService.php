<?php

namespace App\Services;

use App\Models\Position;
use App\Repositories\PositionRepository;

class PositionService
{
    public function __construct(private PositionRepository $repository) {}

    public function list()
    {
        return $this->repository->all();
    }

    public function show(int $id): ?Position
    {
        return $this->repository->find($id);
    }

    public function store(array $data): Position
    {
        return $this->repository->create($data);
    }

    public function update(Position $position, array $data): Position
    {
        return $this->repository->update($position, $data);
    }

    public function destroy(Position $position): bool
    {
        return $this->repository->delete($position);
    }
}
