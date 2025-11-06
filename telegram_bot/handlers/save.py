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
    response = create_product(product)

    if response.status_code != 201:
        print(response.content)
        await bot.send_message(
            chat_id=update.from_user.id,
            text=f"Не удалось сохранить продукт. Пожалуйста, попробуйте еще раз"
        )
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
        "category_title": "",
        "description": "",
        "options": []
    }
    
    if not text:
        return result
    
    # Разбиваем на строки
    lines = [line.strip() for line in text.split('\n') if line.strip()]
    
    if not lines:
        return result
    
    # Первая строка - заголовок
    result["title"] = lines[0]
    
    # Вторая строка - категория
    if len(lines) > 1:
        result["category_title"] = lines[1]
    
    # Собираем описание и одновременно ищем начало опций
    description_lines = []
    options_start_index = None
    
    for i in range(2, len(lines)):
        line = lines[i]
        # Проверяем, является ли строка опцией (содержит •, | и цену)
        if '•' in line and '|' in line and any(char.isdigit() for char in line):
            options_start_index = i
            break
        description_lines.append(line)
    
    result["description"] = '\n'.join(description_lines).strip()
    
    # Обрабатываем опции, если нашли их начало
    if options_start_index is not None:
        for i in range(options_start_index, len(lines)):
            line = lines[i]
            if '•' in line and '|' in line:
                # Обрабатываем строку с опцией
                option_data = parse_option_line(line)
                if option_data:
                    result["options"].append(option_data)
    
    return result

def parse_option_line(line: str) -> Dict[str, Any] | None:
    """
    Парсит строку с опцией товара
    Примеры:
    •🫙250 мл | стекло | 590 р.
    •🍯 200 мл | глина (горшок) | 900 р.
    • 100 гр | кр. пакет | 750 р.
    """
    try:
        # Убираем маркер • и эмодзи
        clean_line = re.sub(r'^•\s*[^\w\s]*\s*', '', line.strip())
        
        # Разделяем на части по |
        parts = [part.strip() for part in clean_line.split('|')]
        
        if len(parts) < 4:
            return None
        
        volume = parts[0]  # "250 мл", "100 гр" и т.д.
        package_type = parts[1]  # "стекло", "глина (горшок)" и т.д.
        price_str = parts[2]  # "590 р.", "1 400 р." и т.д.
        weight = parts[3]

        # Очищаем цену: убираем "р.", пробелы, и другие нецифровые символы кроме цифр
        price_clean = re.sub(r'[^\d]', '', price_str)
        
        if not price_clean:
            return None
        
        price = int(price_clean)
        
        return {
            "type": package_type,
            "price": price,
            "volume": volume,
            "weight": weight 
        }
    
    except (ValueError, IndexError, AttributeError):
        return None
