<?php

namespace App\Actions\Position;

use App\Repositories\PositionRepository;
use App\Models\Position;

class DeletePositionAction
{
    public function __construct(private PositionRepository $repository) {}

    public function handle(Position $position): bool
    {
        return $this->repository->delete($position);
    }
}
