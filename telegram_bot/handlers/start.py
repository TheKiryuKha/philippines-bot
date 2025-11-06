from aiogram import Bot
from aiogram.types import Message
from keyboards.start_keyboard import start_kb
from utils.clear_messages import clear
from utils.api import create_user


async def get_start(message: Message, bot: Bot):
    await clear(message, bot)

    create_user(message.from_user.id, message.from_user.username)

    await bot.send_message(message.from_user.id, f'Производство мёда без сиропа, антибиотиков и химии (с 2006 г) \n\n'
                           f'Частная эко-пасека в г. Гуково (Ростовская обл.) \n\n'
                           f'Доставка РФ и СНГ.', reply_markup=start_kb())