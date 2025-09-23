<?php

namespace App\Traits;

use App\Exceptions\SystemLogicException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    protected function listResponse($message = '', $data = []): Application|Response|ResponseFactory
    {
        return jsonResponse(message: $message, data: $data);
    }

    protected function showResponse($message = '', $data = []): Application|Response|ResponseFactory
    {
        return jsonResponse(message: $message, data: $data);
    }

    protected function indexResponse($message = '', $data = [], $extraData = [], $meta = []): Application|Response|ResponseFactory
    {
        return jsonResponse(
            message: $message,
            data: $data,
            extraData: $extraData,
            meta: $meta
        );
    }

    protected function destroyResponse(
        $message = '',
        $data = [],
        $status = Response::HTTP_NO_CONTENT
    ): Application|Response|ResponseFactory {
        return jsonResponse(status: $status, message: $message, data: $data);
    }

    public function updateResponse(
        $message = '',
        $data = [],
        $status = Response::HTTP_NO_CONTENT
    ): Application|Response|ResponseFactory {
        return jsonResponse(status: $status, message: $message, data: $data);
    }


    public function storeResponse(
        $data = [],
        $message = '',
        $status = Response::HTTP_CREATED
    ): Application|Response|ResponseFactory {
        return jsonResponse(status: $status, message: $message, data: $data);
    }



    public function getPaginationMeta($request, $model = [], $total = null): array
    {
        $total = $total ?? $model->count();
        $perPage = $request->input('perPage', 10);
        $totalPages = (int) ceil($total / $perPage);
        $currentPage = $request->input('page', 1);
        $firstItem = $total > 0 ? ($currentPage - 1) * $perPage + 1 : null;
        $to = $total > 0 ? $firstItem + $perPage - 1 : null;
        $lastPage = max($totalPages, 1);

        return [
            'total' => $total,
            'totalPages' => $totalPages,
            'perPage' => (int) $perPage,
            'currentPage' => (int) $currentPage,
            'lastPage' => (int) $lastPage,
            'isLastPage' => $currentPage == $lastPage,
            'isFirstPage' => $currentPage == 1,
            'from' => (int) $firstItem,
            'to' => $total < (int) $to ? $total : $to,
        ];
    }

    public function limitAndOffset($query, $request)
    {
        $per_page = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $skip = $per_page * ($page - 1);

        return $query->skip($skip)->limit($per_page);
    }


    protected function failedResponse($message, $code): JsonResponse
    {
        return response()->json(['message' => $message], $code);
    }
}
