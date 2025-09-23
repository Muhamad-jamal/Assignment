<?php

namespace App\Actions\Position;

use App\Services\PositionService;

class StorePositionAction
{
    public function __construct(private PositionService $service) {}

    public function handle(array $data)
    {
        return $this->service->store($data);
    }
}
