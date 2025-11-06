restart-bot:
	./vendor/bin/sail stop telegram-bot
	./vendor/bin/sail build --no-cache telegram-bot
	./vendor/bin/sail up -d telegram-bot
