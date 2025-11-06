from aiogram import Bot
from aiogram.types import Message

async def send(message: Message, bot: Bot):
    data = message.text.split(' ', 2)

    command, id, text = data

    await bot.send_message(
        chat_id=id,
        text=text,
        parse_mode='HTML'
    )