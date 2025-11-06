from aiogram import Bot, Dispatcher
import asyncio
from utils.commands import set_commands
from handlers.handlers import register_handlers
from config import TOKEN, ADMIN_ID

# TODO auth

bot = Bot(token=TOKEN)
dp = Dispatcher()

async def start_bot(bot: Bot):
    await bot.send_message(ADMIN_ID, text='Я запустил бота!')

dp.startup.register(start_bot)

register_handlers(dp)

async def start():
    await set_commands(bot)
    try:
        await dp.start_polling(bot, skip_updates=True)
    finally:
        await bot.session.close()

if __name__ == '__main__':
    asyncio.run(start())