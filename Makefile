
.PHONY:
up:
	docker-compose up -d

.PHONY:
down:
	docker-compose down

.PHONY:
reload:
	docker-compose stop && docker-compose start

.PHONY:
shell:
	docker exec -it irakli_apache bash
