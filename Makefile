
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
	docker exec -it irakli_apache bash


# --------------- #
#  Database dump  #
# --------------- #

.PHONY:
mysql-dump:
	docker exec -it irakli_mysql bash -c '/dump/generate.sh'

.PHONY:
mysql-restore:
	docker exec -it irakli_mysql bash -c '/dump/populate.sh'
