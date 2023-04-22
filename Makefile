
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
