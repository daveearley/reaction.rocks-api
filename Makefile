.PHONY: composer-update composer-install php-bash docker-up docker-stop redis-cli redis-flush clear-config-cache start-app

php-user=www-data
php-exec-command=docker-compose exec --user=${php-user} php-fpm
user-group-id=USER_ID=`id -u` GROUP_ID=`id -g`

start-app:
	${user-group-id} docker-compose up -d --force-recreate
	sudo chmod -R 0777 ./storage ./bootstrap/cache
	docker-compose exec php-fpm composer install
	docker-compose exec php-fpm php artisan migrate

composer-update:
	${php-exec-command} composer update

composer-install:
	${php-exec-command} composer install

composer-dump-autoload:
	${php-exec-command} composer dump-autoload

composer-require:
	${php-exec-command} composer require $(package)

composer-require-dev:
	${php-exec-command} composer require $(package) --dev

php-bash:
	${php-exec-command} bash

php-cbf:
	${php-exec-command} ./vendor/bin/phpcbf --standard=psr12 -s ./app/

php-cs:
	${php-exec-command} ./vendor/bin/phpcs -s --standard=psr12 -s ./app/

run-migrations:
	${php-exec-command} php artisan migrate

generate-domain-objects:
	${php-exec-command} php artisan generate-domain-objects

clear-config-cache:
	${php-exec-command} php artisan config:cache

docker-up:
	${user-group-id} docker-compose up -d

docker-up-rebuild:
	${user-group-id} docker-compose up -d --build --force-recreate

docker-stop:
	docker stop `docker ps -f "name=reaction" -q`

redis-cli:
	docker-compose exec redis redis-cli

redis-flush:
	docker-compose exec redis redis-cli flushall

postgres-cli:
	docker-compose exec postgres psql postgres --user=user
