from aiogram.utils.keyboard import InlineKeyboardBuilder
from utils.api import get_products


def create_kb():
    kb = InlineKeyboardBuilder()
    for product in get_products():
        kb.button(
            text=f"{product['attributes']['title']}",
            callback_data="product_" + f"{product['id']}"
        )
    kb.adjust(1)
    return kb.as_markup()