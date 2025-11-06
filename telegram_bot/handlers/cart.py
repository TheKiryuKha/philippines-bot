from aiogram import Bot
from aiogram.types import CallbackQuery
from utils.api import add_product_to_cart, get_cart, get_cart_with_items, destroy_cart
from keyboards.product_keyboard import create_kb
from utils.clear_messages import clear
from actions.show_cart import show_cart
from keyboards.edit_cart_keyboard import edit_cart_keyboard

async def show(update: CallbackQuery, bot: Bot):
    await clear(update, bot)

    cart = get_cart_with_items(update.from_user.id)

    await show_cart(cart, update, bot)
    

async def store(update: CallbackQuery, bot: Bot): 
    update.answer()

    product_id = update.data.split('_')[1]

    product = add_product_to_cart(product_id, update.from_user.id) 
    cart = get_cart(update.message.chat.id)
    
    await bot.edit_message_reply_markup(
        chat_id= update.message.chat.id,
        message_id= update.message.message_id,
        reply_markup=create_kb(product, cart, update.from_user.id)
    );

async def edit(update: CallbackQuery, bot: Bot):
    cart = get_cart_with_items(update.from_user.id)
    
    await bot.edit_message_reply_markup(
        chat_id= update.message.chat.id,
        message_id= update.message.message_id,
        reply_markup=edit_cart_keyboard(cart)
    );

async def destroy(update: CallbackQuery, bot: Bot):
    update.answer()

    cart = get_cart(update.from_user.id)
    destroy_cart(cart['id'])

    await show(update, bot)