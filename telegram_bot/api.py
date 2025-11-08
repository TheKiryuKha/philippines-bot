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

# Создание FastAPI приложения
app = FastAPI(title="Telegram Bot API")

@app.post("/notify")
async def send_message(request: MessageRequest):
    """
    Отправляет сообщение в указанный чат
    """
    try:
        for visa in request.visas:
            await bot.send_message(chat_id=visa.chat_id, text=visa.time_until_expiration)
    except Exception as e:
        raise HTTPException(status_code=400, detail=f"Ошибка отправки: {str(e)}")

@app.get("/health")
async def health_check():
    """Проверка работоспособности API"""
    return {"status": "healthy"}