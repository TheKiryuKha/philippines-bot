from aiogram import Bot
from aiogram.types import Message
from config import ADMIN_ID
from aiogram.fsm.context import FSMContext
from state.StoreProductState import StoreProductState
from utils.clear_messages import clear
import re
from typing import Dict, Any
from utils.api import create_product


async def create(update: Message, bot: Bot, state: FSMContext):
    await clear(update, bot)

    if str(update.from_user.id) != str(ADMIN_ID):
        await bot.send_message(
            chat_id=update.from_user.id,
            text=f'У вас нет прав для выполнения этой команды'
        ) 
        return
    
    await bot.send_message(
        chat_id=update.from_user.id,
        text=f"Оправьте новый продукт"
    )
    await state.set_state(StoreProductState.regData)

async def store(update: Message, bot: Bot, state: FSMContext):
    product = await parse_product_message(update, bot)
    print(product)
    response = create_product(product)

    if response.status_code != 201:
        print(response.content)
        await bot.send_message(
            chat_id=update.from_user.id,
            text=f"Не удалось сохранить продукт. Пожалуйста, попробуйте еще раз"
        )

        # await bot.send_message(
        #     chat_id=update.from_user.id,
        #     text=response.content
        # )
        return
    
    await update.delete()
    await state.clear()

    await bot.send_message(
        chat_id=update.from_user.id,
        text=f"✅ Продукт сохранён"
    )



async def parse_product_message(message: Message, bot: Bot) -> Dict[str, Any]:
    """
    Исправленная версия парсера товарных сообщений
    """
    # Получаем изображение
    image_url = None
    if message.photo:
        # Берем самое большое изображение
        photo = message.photo[-1]
        # Получаем информацию о файле
        file = await bot.get_file(photo.file_id)
        # Формируем прямую ссылку для скачивания
        image_url = f"https://api.telegram.org/file/bot{bot.token}/{file.file_path}"
    
    # Получаем текст
    text = message.caption or message.text or ""
    
    result = {
        "image_link": image_url,
        "title": "",
        "description": "",
        "price": "",
    }
    
    if not text:
        return result
    
    # Разбиваем на строки
    lines = [line.strip() for line in text.split('\n') if line.strip()]
    
    if not lines:
        return result
    
    # Первая строка - заголовок
    result["title"] = lines.pop(0)
    result["price"] = lines.pop(0)
    
    result["description"] = '\n'.join(lines).strip()
    
    return result

