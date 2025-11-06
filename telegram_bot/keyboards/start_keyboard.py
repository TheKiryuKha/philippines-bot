from aiogram.types import InlineKeyboardMarkup, InlineKeyboardButton



def start_kb():
    buttons = [
        [InlineKeyboardButton(text='🛒 У завхоза', callback_data='shop')],
        [InlineKeyboardButton(text='📑 Моя виза', callback_data='visa')],
        [InlineKeyboardButton(text='Товарищ Завхоз', url='https://t.me/predkovalery')]
    ]

    return InlineKeyboardMarkup(inline_keyboard=buttons)