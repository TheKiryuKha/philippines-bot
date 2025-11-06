<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\CartItem;

use App\Models\Cart;
use App\Models\ProductOption;
use Illuminate\Foundation\Http\FormRequest;

final class CreateCartItemRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'chat_id' => ['required', 'int', 'exists:users,chat_id'],
            'option_id' => ['required', 'int', 'exists:product_options,id'],
        ];
    }

    public function getCart(): Cart
    {
        return Cart::getByChatId($this->integer('chat_id'));
    }

    public function getOption(): ProductOption
    {
        return ProductOption::findOrFail($this->integer('option_id'));
    }
}
