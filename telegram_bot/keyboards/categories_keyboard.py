from aiogram.utils.keyboard import InlineKeyboardBuilder
from utils.api import get_categories


def create_kb():
    kb = InlineKeyboardBuilder()
    for category in get_categories():
        kb.button(
            text=f"{category['attributes']['title']}",
            callback_data="category_" + f"{category['id']}"
        )
    kb.adjust(1)
    return kb.as_markup()