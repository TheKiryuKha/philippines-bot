from aiogram import Bot
from aiogram.types import Message
from keyboards.products_keyboard import create_kb
from utils.clear_messages import clear

async def shop(message: Message, bot: Bot):

    await clear(message, bot)

    text = (
        f"<b>🥥МАГАЗИН🌴</b>\n"
        f"(еще одно очень крутое описание)\n\n"
        f"Порадуй себя свежими филиппинскими продуктами:"
    )


    await bot.send_message(chat_id=message.from_user.id, text=text, reply_markup=create_kb(), parse_mode='HTML')
