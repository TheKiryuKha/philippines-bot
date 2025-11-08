from aiogram import Bot
from aiogram.types import Message
from utils.api import get_users

async def send(message: Message, bot: Bot):
    data = message.text.split(' ', 2)

    command, id, text = data

    await bot.send_message(
        chat_id=id,
        text=text,
        parse_mode='HTML'
    )

async def sendall(message: Message, bot: Bot):
    data = message.text.split(' ', 1)

    command, text = data

    users = get_users();

    for user in users:
        await bot.send_message(
            chat_id=user['attributes']['chat_id'],
            text=text,
            parse_mode='HTML'
        )