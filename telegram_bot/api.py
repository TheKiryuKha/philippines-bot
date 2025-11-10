from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from aiogram import Bot
from config import TOKEN
import asyncio
from typing import List

# Инициализация бота для API
bot = Bot(token=TOKEN)

# Модель сообщения
class SingleMessage(BaseModel):
    chat_id: str
    time_until_expiration: str

# Модель для запроса
class MessageRequest(BaseModel):
    visas: List[SingleMessage]

class ChatID(BaseModel):
    chat_id: int

class DeletInvoices(BaseModel):
    users: List[ChatID]

# Создание FastAPI приложения
app = FastAPI(title="Telegram Bot API")

@app.post("/notify")
async def send_message(request: MessageRequest):
    """
    Отправляет сообщение в указанный чат
    """
    try:
        for visa in request.visas:

            message = (
                f"<b>🌴 ВНИМАНИЕ 🌴</b>\n\n"
                f"Ваша виза истечёт <b>{visa.time_until_expiration}</b>\n"
                f"Рекомендуем продлить ее"
            )

            await bot.send_message(
                chat_id=visa.chat_id,
                text=message,
                parse_mode='HTML'
            )
    except Exception as e:
        raise HTTPException(status_code=400, detail=f"Ошибка отправки: {str(e)}")

@app.post("/delete_invoice")
async def send_message(request: DeletInvoices):
    """
    Отправляет сообщение в указанный чат
    """
    try:
        for user in request.users:

            message = (
                f"❌ Данные вашего заказа были очищены"
            )

            await bot.send_message(
                chat_id=user.chat_id,
                text=message,
                parse_mode='HTML'
            )
    except Exception as e:
        raise HTTPException(status_code=400, detail=f"Ошибка отправки: {str(e)}")

@app.get("/health")
async def health_check():
    """Проверка работоспособности API"""
    return {"status": "healthy"}