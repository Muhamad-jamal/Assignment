<?php

namespace App\Actions\Position;

use App\Repositories\PositionRepository;

class ShowPositionAction
{
    public function __construct(private PositionRepository $repository) {}

    public function handle(int $id)
    {
        return $this->repository->find($id);
    }
}
