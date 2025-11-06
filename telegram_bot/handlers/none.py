from aiogram.types import CallbackQuery

async def none(update: CallbackQuery):
    await update.answer()