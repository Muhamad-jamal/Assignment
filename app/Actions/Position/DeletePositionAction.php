<?php

namespace App\Actions\Position;

use App\Services\PositionService;
use App\Models\Position;

class DeletePositionAction
{
    public function __construct(private PositionService $service) {}

    public function handle(Position $position): bool
    {
        return $this->service->destroy($position);
    }
}
