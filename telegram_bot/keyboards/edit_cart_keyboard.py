from aiogram.utils.keyboard import InlineKeyboardBuilder

def edit_cart_keyboard(cart):
    kb = InlineKeyboardBuilder()

    for item in cart['attributes']['items']:
        kb.button(
            text=f"{item['attributes']['title']} | {item['attributes']['amount']} шт. | {item['attributes']['formatted_price']}",
            callback_data='none'
        )

        kb.button(
            text=f"-1",
            callback_data=f"decrease_cart:{item['id']}"
        )
        kb.button(
            text=f"+1",
            callback_data=f"increase_cart:{item['attributes']['option_id']}"
        )
        
    kb.button(
        text=f"Назад",
        callback_data=f"cart"
    )
    kb.adjust(1, 2, repeat=len(cart['attributes']['items']) + 1)

    return kb.as_markup()