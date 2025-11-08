from aiogram import Bot
from aiogram.types import CallbackQuery, Message
from utils.api import get_visa, create_visa, extend_visa, delete_visa
from utils.clear_messages import clear
from state.StoreVisaState import StoreVisaState
from aiogram.fsm.context import FSMContext
from datetime import datetime
from keyboards.clear_state_keyboard import create_kb
from keyboards.visa_keyboard import create_kb as visa_kb


async def show(update: CallbackQuery, bot: Bot, state: FSMContext):
    await clear(update, bot)

    response = get_visa(update.from_user.id)

    if response.status_code == 204:

        text = (
            f"<b>🇵🇭 МОЯ ВИЗА </b>\n\n"
            f"Этот бот поможет тебе продлять твою визу. За 2 недели до истечения визы, он будет отправлять тебе уведомления. Для этого просто отправь дату истечения своей визы боту"
            f'\n\n<b>ВАЖНО</b>: отправь дату в формате "день.месяц.год" \n пример: 31.03.2027'
        )

        await bot.send_message(
            chat_id=update.from_user.id,
            text=text,
            reply_markup=create_kb(),
            parse_mode='HTML'
        )
        await state.set_state(StoreVisaState.regData)
        return
    
    visa = response.json()['data']

    text = (
        f"<b>🛩 ВИЗА</b>\n\n"

        f"<b>Истечет</b> {visa['attributes']['expiration_time']}\n"
        f"<b>Дата продления:</b> {visa['attributes']['extension_date']}"
    )

    await bot.send_message(
        chat_id=update.from_user.id,
        text=text,
        reply_markup=visa_kb(visa),
        parse_mode='HTML'
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
        text=f"✅ Виза успешно сохранена!"
    )

async def extend(update: CallbackQuery, bot: Bot):
    await update.answer()
    await clear(update, bot)

    visa_id = update.data.split('_')[1]
    visa = extend_visa(visa_id)

    text = (
        f"<b>🛩 ВИЗА</b>\n\n"

        f"<b>Истечет</b> {visa['attributes']['expiration_time']}\n"
        f"<b>Дата продления:</b> {visa['attributes']['extension_date']}"
    )

    await bot.send_message(
        chat_id=update.from_user.id,
        text=text,
        reply_markup=visa_kb(visa),
        parse_mode='HTML'
    )

async def delete(update: CallbackQuery, bot: Bot):
    await update.answer()
    await clear(update, bot)

    visa_id = update.data.split('_')[1]
    delete_visa(visa_id)

    await bot.send_message(
        chat_id=update.from_user.id,
        text=f"✅ Данные о визе очищены. Ты можешь внести новые данные командой /visa"
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
