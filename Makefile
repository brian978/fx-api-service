default:
	echo "Please select a valid option"

build:
	docker-compose -f docker-compose.yml build

start:
	python3 scripts/run.py

install:
	cp app/.env.example app/.env
	python3 scripts/cli.py composer install

stop:
	docker-compose stop

restart:
	docker-compose stop
	python3 scripts/run.py

cli:
	python3 scripts/cli.py

cleanup:
	docker-compose down

regenerate:
	python3 scripts/cli.py php /var/www/app/bin/console doctrine:cache:clear-metadata
	python3 scripts/cli.py php /var/www/app/bin/console doctrine:cache:clear-query
	python3 scripts/cli.py php /var/www/app/bin/console doctrine:cache:clear-result
	python3 scripts/cli.py php /var/www/app/bin/console make:entity --regenerate App\\Entity

update-deps:
	python3 scripts/cli.py composer update

db:
	docker-compose stop
	python3 scripts/run.py
	python3 scripts/cli.py php /var/www/app/bin/console doctrine:database:drop --if-exists --force
	python3 scripts/cli.py php /var/www/app/bin/console doctrine:database:create
	python3 scripts/cli.py php /var/www/app/bin/console --no-interaction doctrine:migrations:migrate

import:
	python3 scripts/cli.py php /var/www/app/bin/console app:import:run -vv

