<?php

namespace App\Actions\Position;

use App\Repositories\PositionRepository;
use App\Models\Position;

class UpdatePositionAction
{
    public function __construct(private PositionRepository $repository) {}

    public function handle(Position $position, array $data)
    {
        return $this->repository->update($position, $data);
    }
}
