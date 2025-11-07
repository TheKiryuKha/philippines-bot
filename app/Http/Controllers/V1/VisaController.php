<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\Visa\CreateVisaRequest;
use App\Models\Visa;
use Illuminate\Http\JsonResponse;

final readonly class VisaController
{
    public function store(CreateVisaRequest $request): JsonResponse
    {
        Visa::create($request->validated());

        return response()->json(status: 201);
    }
}
