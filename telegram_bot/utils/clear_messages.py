from aiogram import Bot
from aiogram.types import Message, CallbackQuery
from typing import Union

async def clear(update: Union[Message, CallbackQuery], bot: Bot):
    if isinstance(update, Message):
        chat_id = update.from_user.id
        message_id = update.message_id
    else:
        chat_id = update.from_user.id
        message_id = update.message.message_id

    await bot.delete_message(chat_id, message_id)

    try:
        await bot.delete_message(chat_id, message_id - 1)
    except Exception:
        pass