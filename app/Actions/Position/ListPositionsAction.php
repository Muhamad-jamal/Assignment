<?php

namespace App\Actions\Position;

use App\Repositories\PositionRepository;

class ListPositionsAction
{
    public function __construct(private PositionRepository $repository) {}

    public function handle()
    {
        return $this->repository->all();
    }
}
