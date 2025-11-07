<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Resources\V1\VisaResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class GetUserVisaController
{
    public function __invoke(User $user): JsonResponse|VisaResource
    {
        return $user->visa ? new VisaResource($user->visa) : response()->json(status: 204);
    }
}
