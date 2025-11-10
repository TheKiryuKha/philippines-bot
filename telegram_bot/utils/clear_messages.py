from aiogram import Bot
from aiogram.types import Message, CallbackQuery
from typing import Union

async def clear(update: Union[Message, CallbackQuery], bot: Bot):
    if isinstance(update, Message):
        if update.text.startswith('/'):
            chat_id = update.from_user.id
            message_id = update.message_id

            try:
                await bot.delete_message(chat_id, message_id - 1)
                await bot.delete_message(chat_id, message_id - 2)
            except Exception:
                pass
            return
        else:
            chat_id = update.from_user.id
            message_id = update.message_id

            await bot.delete_message(chat_id, message_id)
    else:
        chat_id = update.from_user.id
        message_id = update.message.message_id

        await bot.delete_message(chat_id, message_id)