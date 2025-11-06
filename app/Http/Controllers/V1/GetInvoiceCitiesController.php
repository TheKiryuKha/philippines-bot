<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Actions\Invoice\GetCitiesAction;
use App\Http\Requests\V1\Invoice\GetCitiesRequest;
use App\Http\Resources\V1\CityResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final readonly class GetInvoiceCitiesController
{
    public function __invoke(GetCitiesRequest $request, GetCitiesAction $action): AnonymousResourceCollection
    {
        $cities = $action->handle($request->string('city')->value());

        return CityResource::collection($cities);
    }
}
