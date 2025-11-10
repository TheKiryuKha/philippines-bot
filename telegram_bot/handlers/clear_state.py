from aiogram import Bot
from aiogram.types import CallbackQuery
from aiogram.fsm.context import FSMContext
from keyboards.start_keyboard import start_kb
from utils.clear_messages import clear

async def clear_state(update: CallbackQuery, bot: Bot, state: FSMContext):
    await update.answer()
    await clear(update, bot)
    await state.clear()

    text = (f"<b>🇵🇭 Приветствую!</b>\n\n"
        f"это бот <a href='https://t.me/zavhozph'>завхоза чата Филиппин</a>\n\n"
        f"Здесь ты можешь приобрести товары, отследить свою визу и получить любую помощь\n\n"
        f"🥥 Добро пожаловать на Святую Землю\n"
        f"<a href='https://t.me/sect_philippines'>Наш чат</a>"
    )

    await bot.send_message(
        chat_id=update.from_user.id, 
        text=text,
        reply_markup=start_kb(),
        parse_mode='HTML'
    )

