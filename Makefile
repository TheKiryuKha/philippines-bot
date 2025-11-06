restart-bot:
	./vendor/bin/sail stop telegram-bot
	./vendor/bin/sail build --no-cache telegram-bot
	./vendor/bin/sail up -d telegram-bot

lint:
	./vendor/bin/sail composer lint

fix: 	
	./vendor/bin/sail composer fix

test\:unit:
	./vendor/bin/sail composer test:unit

test\:types:
	./vendor/bin/sail composer test:types

test:
	./vendor/bin/sail composer test

migration:
	./vendor/bin/sail artisan make:migration "$(subst $() ,_,$(filter-out $@,$(MAKECMDGOALS)))"

migrate:
	./vendor/bin/sail artisan migrate
