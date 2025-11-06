from aiogram.utils.keyboard import InlineKeyboardBuilder

def create_kb(cities):
    kb = InlineKeyboardBuilder()

    for city in cities:
        kb.button(
            text=f"{city['city']}",
            callback_data=f"city_{city['code']}"
        )

    kb.adjust(1)

    return kb.as_markup() 