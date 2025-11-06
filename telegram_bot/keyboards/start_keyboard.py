from aiogram.types import InlineKeyboardMarkup, InlineKeyboardButton



def start_kb():
    buttons = [
        [InlineKeyboardButton(text='🛒 Магазин', callback_data='shop')],
        [InlineKeyboardButton(text='🍯 Основной канал', url='https://t.me/primaestapis')],
        [InlineKeyboardButton(text='Менеджер', url='https://t.me/celestialwordlove')]
    ]

    return InlineKeyboardMarkup(inline_keyboard=buttons)