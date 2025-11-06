from aiogram.utils.keyboard import InlineKeyboardBuilder
from config import ADMIN_ID


def options_kb(product, cart, chat_id):
    kb = InlineKeyboardBuilder()
    options = product['attributes']['options']

    for option in options:
        kb.button(
            text=f"•{option['attributes']['volume']} | "
                + f"{option['attributes']['type']} | "
                + f"{option['attributes']['formatted_price']}",
            callback_data="addToCart_" + f"{option['id']}"
        )
    
    if cart['attributes']['products_amount'] > 0:
        kb.button(
            text=f"Корзина {cart['attributes']['products_amount']} шт. | {cart['attributes']['formatted_price']}",
            callback_data='cart'
        )

    if str(chat_id) == str(ADMIN_ID):
        kb.button(
            text=f"🗑 Удалить",
            callback_data=f"delete_{product['id']}"
        )

    kb.button(
        text=f"Назад",
        callback_data='shop'
    )


    kb.adjust(1)
    return kb.as_markup()   