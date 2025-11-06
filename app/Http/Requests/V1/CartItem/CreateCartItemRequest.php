<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\CartItem;

use App\Models\Cart;
use App\Models\Product;
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
            'product_id' => ['required', 'int', 'exists:products,id'],
        ];
    }

    public function getCart(): Cart
    {
        return Cart::getByChatId($this->integer('chat_id'));
    }

    public function getProduct(): Product
    {
        return Product::findOrFail($this->integer('product_id'));
    }
}
