from aiogram import Bot
from aiogram.types import CallbackQuery
from aiogram.fsm.context import FSMContext
from state.StoreInvoiceState import StoreInvoiceState
from utils.clear_messages import clear
from keyboards.start_create_invoice_keyboard import create_kb
from aiogram.types import Message
from utils.api import get_cart, create_invoice, get_invoice, mark_invoice_as_paid, get_paid_invoices, mark_invoice_as_sent, get_cities
from actions.generate_invoice_text import generate, generate_for_admin, generate_for_shipping
from config import ADMIN_ID
from aiogram.types import InlineKeyboardMarkup, InlineKeyboardButton
from keyboards.cities_keyboard import create_kb as create_cities_kb


async def start_create(update: CallbackQuery, bot: Bot):
    await update.answer()
    await clear(update, bot)

    message = (f"<b>СДЭК доставка </b>\n\n"
    f"Доставка РФ и СНГ\n\n"
    # f"Оплата доставки производится при получении самостоятельно.\n\n"
    f"<b>Заказы отправляются по субботам</b>\n\n"
    # f"<b>Гарантируем сбор вашего заказа и передачу в отдел логистики в течение трех дней после получения оплаты</b> (не считая выходных).\n\n"
    f"Пожалуйста, обратите внимание на эту информацию, чтобы не беспокоиться о статусе вашего заказа.\n\n"
    f"Также <b>вам придёт уведомление в боте, когда ваш заказ будет собран и передан в отдел логистики.</b>\n\n"
    f"<b>Для связи с поддержкой:</b> @celestialwordlove\n\n")

    await bot.send_message(
        chat_id=update.from_user.id,
        text=message,
        reply_markup=create_kb(),
        parse_mode='HTML'
    )

async def create_city(update: CallbackQuery, bot: Bot, state: FSMContext):
    await update.answer()

    # сообщение с просьбой скинуть город
    message = (
        f"Отлично! Приступим к оформлению заказа\n\n"

        f"Отправь, пожалуйста, <b>город</b> для доставки:\n\n"
    )

    await bot.send_message(
        chat_id=update.from_user.id,
        text=message,
        parse_mode='HTML'
    )
    await state.set_state(StoreInvoiceState.regCity)

async def store_city(update: Message, bot: Bot, state: FSMContext):
    await clear(update, bot)
    
    city = update.text
    
    cities = get_cities(city)

    message = (
        f"Пожалуйста, выбери из этого списка свой город:\n\n"
        f"Если его нет, попробуй ввести полное название." 
        f"\n<i>Например: не 'Питер', а 'Санкт-Петербург'</i>"
    )

    await bot.send_message(
        chat_id=update.from_user.id,
        text=message,
        reply_markup=create_cities_kb(cities),
        parse_mode='HTML'
    )


async def create_data(update: CallbackQuery, bot: Bot, state: FSMContext):
    await clear(update, bot)

    await state.update_data(city_code=update.data.split('_')[1])
    
    message = (
        f"Отлично! Приступим к оформлению заказа\n\n"

        f"Отправь, пожалуйста, свой данные в таком формате:\n\n"

        f"<b>"
        f"ФИО (как в паспорте)\n"
        f"Номер телефона (без плюса, только цифры),\n"
        f"Адрес ближайшего пункта выдачи СДЭК(обязательно укажи страну и город)\n\n"
        f"</b>"

        f"Пример:\n\n"

        f"<b>"
        f"Пупкин Василий Алексеевич\n"
        f"375447191945\n"
        f"Беларусь, Гомель, ул. Ильича, 26\n\n"
        f"</b>"
        f"❗️Внимание, я чувствителен к формату"
    )

    await bot.send_message(
        chat_id=update.from_user.id,
        text=message,
        parse_mode='HTML'
    )
    await state.set_state(StoreInvoiceState.regData)

async def store(update: Message, state: FSMContext, bot: Bot):
    lines = update.text.split('\n')

    if len(lines) != 3:
        await bot.send_message(
            update.from_user.id,
            f'❗️ Похоже ты ввел не все необходимые данные или ввел их в неверном формате. Пожалуйста, попробуй еще раз'
        )
        return    

    fio_parts = lines[0].split()

    last_name = fio_parts[0]
    first_name = fio_parts[1]
    middle_name = fio_parts[2]
    
    phone = lines[1].strip()
    
    address = lines[2].strip()
    
    cart = get_cart(update.from_user.id)
    response = create_invoice(
        cart['id'],
        first_name,
        last_name,
        middle_name,
        address,
        phone
    )

    if response.status_code == 201:
        await state.set_state(StoreInvoiceState.waitingForPayment) 
        await clear(update, bot)

        invoice = response.json()['data']
        
        await bot.send_message(
            chat_id=update.from_user.id,
            text=generate(invoice),
            parse_mode='HTML'
        )
        return;

    await bot.send_message(
        chat_id=update.from_user.id,
        text=f"❗️ Извините, произошла ошибка на сервере. Пожалуйста, попробуйте еще раз. Код ошибки: {response.status_code}"
    )


async def pay(update: Message, state: FSMContext, bot: Bot):
    
    invoice = get_invoice(update.from_user.id)

    message = generate_for_admin(invoice)

    keyboard = InlineKeyboardMarkup(inline_keyboard=[
        [InlineKeyboardButton(text="💵 Принять оплату", callback_data=f"mark_paid_invoice:{invoice['id']}")]
    ])

    await bot.send_message(
        chat_id=ADMIN_ID,
        text=message,
        parse_mode='HTML',
        reply_markup=keyboard
    )

    await bot.forward_message(
        chat_id=ADMIN_ID,
        from_chat_id=update.chat.id,
        message_id=update.message_id
    )

    await clear(update, bot)

    await bot.send_message(
        chat_id=update.from_user.id,
        text=f"Отлично! Благодарим за оплату. Скоро бот отправит вам данные для отслеживания. По любым вопросам можете обращаться в поддержку"
    )

    await state.clear()

async def mark_paid(update: CallbackQuery, bot: Bot):
    update.answer()

    invoice_id = int(update.data.split(":")[1])
    mark_invoice_as_paid(invoice_id)

    await bot.send_message(
        chat_id=update.from_user.id,
        text=f"Заказ помечен как оплаченный. Он ожидает отправки. \n\nОтправьте /to_ship в этот чат, чтобы получить список неотправленных заказов"
    )

async def get_paid(update: Message, bot: Bot):

    if int(update.from_user.id) != int(ADMIN_ID):
        return

    invoices = get_paid_invoices()

    if len(invoices) == 0:
        await bot.send_message(
            chat_id=update.from_user.id,
            text=f"Нет заказов ожидающих отправки"
        )
        return

    await bot.send_message(
        chat_id=update.from_user.id,
        text=f"Заказы ожидающие отправки:"
    )

    for invoice in invoices:
        message = generate_for_shipping(invoice)

        keyboard = InlineKeyboardMarkup(inline_keyboard=[
            [InlineKeyboardButton(text="📦 Пометить отправленным", callback_data=f"mark_sent_invoice:{invoice['id']}")]
        ])

        await bot.send_message(
            chat_id=update.from_user.id,
            text=message,
            parse_mode='HTML',
            reply_markup=keyboard
        )

    await bot.send_message(
        chat_id=update.from_user.id,
        text="После отправки заказа введите команду:\n\n<b>/send {id пользователя} {текст}</b>\n\nчтобы отправить клиенту данные для отслеживания заказа",
        parse_mode='HTML',
    )

async def mark_as_sent(update: CallbackQuery, bot: Bot):
    await update.answer()

    id = update.data.split(":")[1]
    response = mark_invoice_as_sent(id)

    if response.status_code != 200:
        await bot.send_message(
            chat_id=update.from_user.id,
            text=f"Не удалось пометить заказ как оплаченный"
        )
        return

    new_keyboard = InlineKeyboardMarkup(inline_keyboard=[
        [InlineKeyboardButton(text="✅ Отправлено", callback_data="none")]
    ])

    await bot.edit_message_reply_markup(
        chat_id=update.from_user.id,
        message_id=update.message.message_id,
        reply_markup=new_keyboard
    )
    