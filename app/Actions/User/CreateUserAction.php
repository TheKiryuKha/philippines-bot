<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\Cart\CreateCartAction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class CreateUserAction
{
    public function __construct(
        private CreateCartAction $action
    ) {}

    /**
     * @param  array{chat_id: int, username: string}  $attr
     */
    public function handle(array $attr): User
    {
        return DB::transaction(function () use ($attr): User {
            $user = User::create($attr);

            $this->action->handle($user);

            return $user;
        });
    }
}
