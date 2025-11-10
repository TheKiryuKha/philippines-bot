from aiogram import Bot
from aiogram.types import CallbackQuery
from aiogram.fsm.context import FSMContext
from keyboards.start_keyboard import start_kb
from utils.clear_messages import clear

async def clear_state(update: CallbackQuery, bot: Bot, state: FSMContext):
    await update.answer()
    await state.clear()
    await clear(update, bot)

    text = (f"Привет! \n\n"
        "Это официальный бот завхоза чата Филиппин\n"
        "(очень крутой текст, который я пока не придумал)"           
    )

    await bot.send_message(update.from_user.id, text, reply_markup=start_kb())

