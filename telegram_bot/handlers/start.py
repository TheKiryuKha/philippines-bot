from aiogram import Bot
from aiogram.types import Message
from keyboards.start_keyboard import start_kb
from utils.clear_messages import clear
from utils.api import create_user


async def get_start(message: Message, bot: Bot):
    create_user(message.from_user.id, message.from_user.username)

    text = (f"<b>🇵🇭 Приветствую!</b>\n\n"
        f"это бот <a href='https://t.me/zavhozph'>завхоза чата Филиппин</a>\n\n"
        f"Здесь ты можешь приобрести товары, отследить свою визу и получить любую помощь\n\n"
        f"🥥 Добро пожаловать на Святую Землю\n"
        f"<a href='https://t.me/sect_philippines'>Наш чат</a>"
    )

    await bot.send_message(message.from_user.id, text, reply_markup=start_kb(), parse_mode='HTML')
