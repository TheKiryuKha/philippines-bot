from aiogram import Bot
from aiogram.types import CallbackQuery, Message
from utils.api import get_visa, create_visa
from utils.clear_messages import clear
from state.StoreVisaState import StoreVisaState
from aiogram.fsm.context import FSMContext
from datetime import datetime


async def show(update: CallbackQuery, bot: Bot, state: FSMContext):
    await clear(update, bot)

    response = get_visa(update.from_user.id)

    if response.status_code == 204:
        await bot.send_message(
            chat_id=update.from_user.id,
            text=f"Похоже ты еще не добавил визу. Отправь пж дату истечения"
        )
        await state.set_state(StoreVisaState.regData)
        return
    
    visa = response.json()['data']

    await bot.send_message(
        chat_id=update.from_user.id,
        text=f"твоя виза:{visa}"
    )

async def store(update: Message, bot: Bot, state: FSMContext):
    await clear(update, bot)

    expiration_date = update.text
    
    # Проверка формата даты
    is_valid, result = is_valid_date(expiration_date)
    
    if not is_valid:
        await bot.send_message(
            chat_id=update.from_user.id,
            text=f"❌ {result}\n\nПожалуйста, отправь дату в формате ДД.ММ.ГГГГ (например, 31.12.2024):"
        )
        return  # Не очищаем состояние, чтобы пользователь мог попробовать снова

    data = {
        'chat_id': str(update.from_user.id),
        'expiration_date': expiration_date
    }

    response = create_visa(data)

    if response.status_code != 201:
        await bot.send_message(
            chat_id=update.from_user.id,
            text=response.content
        )
        return

    await state.clear()

    await bot.send_message(
        chat_id=update.from_user.id,
        text=f"Виза успешно сохранена!"
    )


def is_valid_date(date_string):
    """Проверяет, является ли строка валидной датой в формате d.m.Y"""
    try:
        date = datetime.strptime(date_string, "%d.%m.%Y")
        # Дополнительная проверка, что дата не в прошлом
        if date.date() < datetime.now().date():
            return False, "Дата не может быть в прошлом"
        return True, date
    except ValueError:
        return False, "Неверный формат даты. Используйте ДД.ММ.ГГГГ"
