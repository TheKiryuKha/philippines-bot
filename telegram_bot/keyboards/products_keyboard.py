from aiogram.utils.keyboard import InlineKeyboardBuilder

def products_kb(products):
    kb = InlineKeyboardBuilder()
    for product in products:
        kb.button(
            text=f"{product['attributes']['title']}",
            callback_data="product_" + f"{product['id']}"
        )
    kb.adjust(1)
    return kb.as_markup()