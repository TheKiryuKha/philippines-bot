from aiogram import Bot
from aiogram.types import CallbackQuery
from utils.api import delete_cart_item
from actions.show_cart import generate_cart_text
from utils.api import get_cart_with_items, add_product_to_cart
from utils.clear_messages import clear
from keyboards.edit_cart_keyboard import edit_cart_keyboard

async def destroy(update: CallbackQuery, bot: Bot):
    await update.answer()
    data_parts = update.data.split(':')
     
    item_id = data_parts[1]  

    delete_cart_item(item_id)

    cart = get_cart_with_items(update.from_user.id)

    text = generate_cart_text(cart)

    await bot.edit_message_text(
        chat_id=update.from_user.id,
        message_id=update.message.message_id,
        text=text,
        parse_mode='HTML',
        reply_markup=edit_cart_keyboard(cart)
    )

async def store(update: CallbackQuery, bot: Bot):
    await update.answer()
    data_parts = update.data.split(':')
    
    option_id = data_parts[1]

    add_product_to_cart(option_id, update.from_user.id)

    cart = get_cart_with_items(update.from_user.id)

    text = generate_cart_text(cart)

    await bot.edit_message_text(
        chat_id=update.from_user.id,
        message_id=update.message.message_id,
        text=text,
        parse_mode='HTML',
        reply_markup=edit_cart_keyboard(cart)
    )