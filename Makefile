.PHONY: deps

setup: deps build app-key

start:
	docker-compose up

test:
	docker-compose run --rm app vendor/bin/phpunit

deps:
	docker run --rm -v ${PWD}:/app composer install

build:
	docker-compose build

db-migrate: start
	docker-compose run --rm app php artisan migrate

app-key:
	docker-compose run --rm app php artisan key:generate
