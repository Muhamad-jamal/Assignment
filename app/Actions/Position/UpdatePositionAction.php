<?php

namespace App\Actions\Position;

use App\Services\PositionService;
use App\Models\Position;

class UpdatePositionAction
{
    public function __construct(private PositionService $service) {}

    public function handle(Position $position, array $data)
    {
        return $this->service->update($position, $data);
    }
}
