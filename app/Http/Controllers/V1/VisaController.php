<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Actions\Visa\CreateVisaAction;
use App\Actions\Visa\ExtendVisaAction;
use App\Http\Requests\V1\Visa\CreateVisaRequest;
use App\Http\Resources\V1\VisaResource;
use App\Models\User;
use App\Models\Visa;

final readonly class VisaController
{
    public function store(CreateVisaRequest $request, CreateVisaAction $action): VisaResource
    {
        $visa = $action->handle($request->validated());

        return new VisaResource($visa);
    }

    public function update(User $user, ExtendVisaAction $action): VisaResource
    {
        /** @var Visa $visa */
        $visa = $user->visa;

        $action->handle($visa);

        return new VisaResource($user->visa);
    }
}
