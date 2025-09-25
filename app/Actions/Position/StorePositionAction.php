<?php

namespace App\Actions\Position;

use App\Repositories\PositionRepository;

class StorePositionAction
{
    public function __construct(private PositionRepository $repository) {}

    public function handle(array $data)
    {
        return $this->repository->create($data);
    }
}
