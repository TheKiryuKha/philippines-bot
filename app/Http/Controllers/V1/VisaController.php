<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Requests\V1\Visa\CreateVisaRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final readonly class VisaController
{
    public function store(CreateVisaRequest $request): JsonResponse
    {
        $user = User::findByChatId($request->integer('chat_id'));

        $user->visa()->create([
            'expiration_date' => $request->string('expiration_date'),
        ]);

        return response()->json(status: 201);
    }
}
