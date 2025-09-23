<?php

namespace App\Actions\Position;

use App\Services\PositionService;

class ListPositionsAction
{
    public function __construct(private PositionService $service) {}

    public function handle()
    {
        return $this->service->list();
    }
}
