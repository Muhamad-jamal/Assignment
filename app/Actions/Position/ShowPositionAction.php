<?php

namespace App\Actions\Position;

use App\Services\PositionService;

class ShowPositionAction
{
    public function __construct(private PositionService $service) {}

    public function handle(int $id)
    {
        return $this->service->show($id);
    }
}
