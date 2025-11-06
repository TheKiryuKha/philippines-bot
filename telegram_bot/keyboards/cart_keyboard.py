from aiogram.utils.keyboard import InlineKeyboardBuilder

def create_kb():
    kb = InlineKeyboardBuilder()

    kb.button(
        text='Оформить заказ',
        callback_data='start_create_invoice'
    )

    kb.button(
        text='Изменить',
        callback_data='edit_cart'
    )
    kb.button(
        text='Очистить',
        callback_data='clear_cart'
    )
    kb.adjust(1)

    return kb.as_markup()