from dotenv import load_dotenv
import os
from pathlib import Path

env_path = Path(__file__).parent.parent / '.env'
load_dotenv(dotenv_path=env_path)

API_VERSION = 1
API_URL = os.getenv('APP_URL') + '/api/v' + str(API_VERSION) + '/'
TOKEN = os.getenv('TELEGRAM_BOT_TOKEN')
ADMIN_ID = os.getenv('TELEGRAM_ADMIN_ID')

BOT_API_HOST = os.getenv('BOT_API_HOST')
BOT_API_PORT = int(os.getenv('BOT_API_PORT'))
