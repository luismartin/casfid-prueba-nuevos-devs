
.PHONY:
up:
	docker-compose up -d

.PHONY:
down:
	docker-compose down

.PHONY:
clean:
	docker-compose down && rm -rf mysql/data && git reset --hard

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
