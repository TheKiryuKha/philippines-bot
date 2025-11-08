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
    messages: List[SingleMessage]

# Создание FastAPI приложения
app = FastAPI(title="Telegram Bot API")

@app.post("/send_message")
async def send_message(request: MessageRequest):
    """
    Отправляет сообщение в указанный чат
    """
    try:
        for message in request.messages:
            await bot.send_message(chat_id=message.chat_id, text=message.time_until_expiration)
    except Exception as e:
        raise HTTPException(status_code=400, detail=f"Ошибка отправки: {str(e)}")

@app.get("/health")
async def health_check():
    """Проверка работоспособности API"""
    return {"status": "healthy"}