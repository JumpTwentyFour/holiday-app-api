<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Trips;

use App\Domain\Trips\Models\Trip;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class DeleteController extends Controller
{
    public function __invoke(Trip $trip): JsonResponse
    {
        $this->authorize('delete', $trip);

        $trip->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
