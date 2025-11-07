from aiogram.utils.keyboard import InlineKeyboardBuilder

def create_kb():
    kb = InlineKeyboardBuilder()

    kb.button(
        text='Назад',
        callback_data='clear_state'
    )

    kb.adjust(1)

    return kb.as_markup()