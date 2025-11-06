from aiogram.utils.keyboard import InlineKeyboardBuilder

def create_kb():
    kb = InlineKeyboardBuilder()
    kb.button(
        text="✔️ Ввести данные для доставки",
        callback_data="create_city"
    )
    return kb.as_markup()