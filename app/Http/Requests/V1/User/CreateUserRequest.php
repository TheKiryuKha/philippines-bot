<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;

final class CreateUserRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'chat_id' => ['required', 'int', 'unique:users,chat_id'],
            'username' => ['required', 'string', 'min:5', 'max:32'],
        ];
    }

    /**
     * @return array{chat_id: int, username: string}
     */
    public function validated($key = null, $default = null): array
    {
        /** @var array{chat_id: int, username: string} */
        $data = parent::validated($key, $default);

        return $data;
    }
}
