<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Actions\Visa\CreateVisaAction;
use App\Actions\Visa\ExtendVisaAction;
use App\Http\Requests\V1\Visa\CreateVisaRequest;
use App\Http\Resources\V1\VisaResource;
use App\Models\Visa;
use Illuminate\Http\JsonResponse;

final readonly class VisaController
{
    public function store(CreateVisaRequest $request, CreateVisaAction $action): VisaResource
    {
        $visa = $action->handle($request->validated());

        return new VisaResource($visa);
    }

    public function update(Visa $visa, ExtendVisaAction $action): VisaResource
    {
        $action->handle($visa);

        return new VisaResource($visa);
    }

    public function destroy(Visa $visa): JsonResponse
    {
        $visa->delete();

        return response()->json(status: 204);
    }
}
