from aiogram import Bot, Dispatcher
import asyncio
from utils.commands import set_commands
from handlers.handlers import register_handlers
from config import TOKEN, ADMIN_ID, BOT_API_HOST, BOT_API_PORT
import uvicorn

bot = Bot(token=TOKEN)
dp = Dispatcher()

async def start_bot(bot: Bot):
    await bot.send_message(ADMIN_ID, text='Я запустил бота!')

dp.startup.register(start_bot)
register_handlers(dp)

async def run_api():
    """Запуск API сервера"""
    config = uvicorn.Config(
        "api:app", 
        host=BOT_API_HOST, 
        port=BOT_API_PORT, 
        log_level="info",
        reload=False
    )
    server = uvicorn.Server(config)
    await server.serve()

async def start():
    await set_commands(bot)
    
    # Запускаем бота и API параллельно
    await asyncio.gather(
        dp.start_polling(bot, skip_updates=True),
        run_api()
    )

if __name__ == '__main__':
    asyncio.run(start())
