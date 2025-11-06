<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Actions\User\CreateUserAction;
use App\Http\Requests\V1\User\CreateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Queries\FilterUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final readonly class UserController
{
    public function index(FilterUsers $query): AnonymousResourceCollection
    {
        $users = $query->handle(User::query());

        return UserResource::collection($users->get());
    }

    // TODO return resource
    public function store(CreateUserRequest $request, CreateUserAction $action): JsonResponse
    {
        $action->handle($request->validated());

        return response()->json(status: 201);
    }
}
