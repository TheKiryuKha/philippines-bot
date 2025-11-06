

def generate(invoice):
    message = (
        f"<b>Заказ</b>\n\n"
        f"ФИО: {invoice['attributes']['last_name']} "
            f"{invoice['attributes']['first_name']} "
            f"{invoice['attributes']['middle_name']}\n"
        f"Номер телефона: {invoice['attributes']['phone']}\n\n"
        f"● Товары:\n"  
    )

    for item in invoice['attributes']['items']:
        message += f"\n<b>{item['attributes']['title']}</b>"
        message += f"\n{item['attributes']['amount']} x {item['attributes']['formatted_price']} = {item['attributes']['total_price']}"
        message += f"\n———"
    
    message += f"\n\n<b>● 💰 Итого: {invoice['attributes']['formatted_price']} </b>"

    # message += f"\n\n ⏳ Оставшееся время для оплаты: 30 мин. После этого времени данные заказа будут удалены"
    # message += f"\n\n <b>Способы оплаты:</b>\n\n"
    message += ( 
            f"⚡️\n\n <b>Реквизиты для оплаты</b> 👇\n\n"
            f"+7 (981) 111-25-43 \n"
            f"Райффайзен\n"
            f"(Куква Г.Аcd.)\n\n"
    )
    message += "‼️ <b> ВАЖНО: для завершения и отправки заказа отправьте скриншот 🧾 об оплате в этот чат.</b>\n"
    message += "📩 Данные для отслеживания придут в этом диалоге с ботом"

    return message

def generate_for_admin(invoice):
    message = (
        f"<b>Заказ от @{invoice['attributes']['username']} </b>\n"
        f"ID: {invoice['attributes']['user_chat_id']}\n\n"
        f"ФИО: {invoice['attributes']['last_name']} "
            f"{invoice['attributes']['first_name']} "
            f"{invoice['attributes']['middle_name']}\n"
        f"Номер телефона: {invoice['attributes']['phone']}\n\n"
        f"<b> Адрес СДЭК: {invoice['attributes']['delivery_address']}\n\n </b>"
        f"● Товары:\n"  
    )

    for item in invoice['attributes']['items']:
        message += f"\n<b>{item['attributes']['title']}</b>"
        message += f"\n{item['attributes']['amount']} x {item['attributes']['formatted_price']} = {item['attributes']['total_price']}"
        message += f"\n———"
    
    message += f"\n\n<b>● 💰 Итого: {invoice['attributes']['formatted_price']} </b>"

    return message

def generate_for_shipping(invoice):
    message = (
        f"<b>Заказ от @{invoice['attributes']['username']} </b>\n"
        f"ID: <code>{invoice['attributes']['user_chat_id']}</code>\n\n"
        f"<b>ФИО: {invoice['attributes']['last_name']} "
            f"{invoice['attributes']['first_name']} "
            f"{invoice['attributes']['middle_name']}\n"
        f"Номер телефона: {invoice['attributes']['phone']}\n"
        f"Адрес СДЭК: {invoice['attributes']['delivery_address']}\n\n </b>"
        f"● Товары:"  
    )

    for item in invoice['attributes']['items']:
        message += f"\n\n<b>{item['attributes']['title']} x {item['attributes']['amount']}</b>"
        message += f"\n{item['attributes']['volume']} | {item['attributes']['type']}"

    return message
