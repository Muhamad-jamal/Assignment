<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Position;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Actions\Position\StorePositionAction;
use App\Actions\Position\UpdatePositionAction;
use App\Actions\Position\DeletePositionAction;
use App\Actions\Position\ListPositionsAction;
use App\Actions\Position\ShowPositionAction;
use App\Http\Requests\Api\V1\StorePositionRequest;
use App\Http\Requests\Api\V1\UpdatePositionRequest;
use App\Http\Resources\Api\V1\PositionResource;

class PositionController extends Controller
{
    use ApiResponse;

    public function index(ListPositionsAction $action)
    {
        $positions = $action->handle();
        return $this->indexResponse(
            'Positions fetched successfully',
            PositionResource::collection($positions)
        );
    }

    public function show(Position $position, ShowPositionAction $action)
    {
        $position = $action->handle($position->id);
        return $this->showResponse('Position details', new PositionResource($position));
    }


    public function store(StorePositionRequest $request, StorePositionAction $action)
    {
        $position = $action->handle($request->validated());
        return $this->storeResponse(new PositionResource($position), 'Position created successfully');
    }

    public function update(UpdatePositionRequest $request, Position $position, UpdatePositionAction $action)
    {
        $position = $action->handle($position, $request->validated());
        return $this->updateResponse();
    }

    public function destroy(Position $position, DeletePositionAction $action)
    {
        $action->handle($position);
        return $this->destroyResponse('Position deleted successfully');
    }
}
