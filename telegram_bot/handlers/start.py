from aiogram import Bot
from aiogram.types import Message
from keyboards.start_keyboard import start_kb
from utils.clear_messages import clear
from utils.api import create_user


async def get_start(message: Message, bot: Bot):
    await clear(message, bot)

    create_user(message.from_user.id, message.from_user.username)

    text = (f"Привет! \n\n"
        "Это официальный бот завхоза чата Филиппин\n"
        "(очень крутой текст, который я пока не придумал)"           
    )

    await bot.send_message(message.from_user.id, text, reply_markup=start_kb())