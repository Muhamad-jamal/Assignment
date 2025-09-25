<?php

namespace App\Services;

use App\Models\Position;
use App\Repositories\PositionRepository;

class PositionService
{
    public function __construct(private PositionRepository $repository) {}

  
}
