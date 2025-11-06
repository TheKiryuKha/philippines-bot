from aiogram import Bot
from aiogram.types import Message
from keyboards.categories_keyboard import create_kb
from utils.clear_messages import clear

async def shop(message: Message, bot: Bot):

    await clear(message, bot)

    await bot.send_message(message.from_user.id, f'Наши товары:', reply_markup=create_kb())
