from aiogram import Bot
from aiogram.types import CallbackQuery
from utils.clear_messages import clear
from utils.api import get_products, get_category, get_product, delete_product
from actions.show_product import show_product

async def show(update: CallbackQuery, bot: Bot):
    await update.answer()
    await clear(update, bot)

    product = get_product(update.data.split('_')[1])

    await show_product(update, bot, product) 

async def destroy(update: CallbackQuery, bot: Bot):
    await update.answer()
    await clear(update, bot)
    
    product_id = int(update.data.split('_')[1])

    delete_product(product_id)

    await bot.send_message(
        chat_id=update.from_user.id,
        text=f"✅ Продукт удалён!"
    )