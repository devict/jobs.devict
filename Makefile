.PHONY: deps

setup: deps build app-key

dev:
	docker-compose up client caddy php-fpm db

prod:
	docker-compose run --rm client npm run prod
	docker-compose up -d caddy php-fpm db

test:
	docker-compose run --rm php vendor/bin/phpunit

deps:
	docker run --rm -v ${PWD}:/app composer install

build:
	docker-compose build

db-migrate:
	docker-compose run --rm php php artisan migrate

app-key:
	docker-compose run --rm php php artisan key:generate
