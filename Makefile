
.PHONY:
up:
	docker-compose up -d
	composer install
	npm install

.PHONY:
down:
	docker-compose down

.PHONY:
clean:
	docker-compose down && rm -rf mysql/data && git reset --hard
	rm -rf vendor
	rm -rf node_modules

.PHONY:
reload:
	docker-compose stop && docker-compose start

.PHONY:
shell:
	docker exec -it casfid_prueba_devs_luis bash


# --------------- #
#  Database dump  #
# --------------- #

.PHONY:
mysql-dump:
	docker exec -it casfid_prueba_devs_luis bash -c '/dump/generate.sh'

.PHONY:
mysql-restore:
	docker exec -it casfid_prueba_devs_luis bash -c '/dump/populate.sh'
