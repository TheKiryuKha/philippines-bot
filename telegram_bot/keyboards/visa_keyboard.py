from aiogram.utils.keyboard import InlineKeyboardBuilder

def create_kb(visa):
    kb = InlineKeyboardBuilder()

    kb.button(
        text='Продлить',
        callback_data=f"extend_{visa['id']}"
    )

    kb.button(
        text='Удалить',
        callback_data=f"deleteVisa_{visa['id']}"
    )

    kb.adjust(1)

    return kb.as_markup()