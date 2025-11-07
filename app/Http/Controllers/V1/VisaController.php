<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\Visa\CreateVisaRequest;
use App\Http\Resources\V1\VisaResource;
use App\Models\User;
use App\Models\Visa;

final readonly class VisaController
{
    public function store(CreateVisaRequest $request): VisaResource
    {
        $user = User::findByChatId($request->integer('chat_id'));

        $visa = $user->visa()->create([
            'expiration_date' => $request->string('expiration_date'),
        ]);

        return new VisaResource($visa);
    }

    public function update(User $user): VisaResource
    {
        /** @var Visa $visa */
        $visa = $user->visa;

        $visa->update([
            'expiration_date' => $visa->expiration_date->addMonth(),
        ]);

        return new VisaResource($user->visa);
    }
}
