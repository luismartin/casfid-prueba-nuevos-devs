# Docker Apache2 Template #

This is a basic Docker template with `Apache2` `PHP` `MySQL` and `phpMyAdmin` services.


### 1. What the app does ###

1. Create a table
2. Insert an user
3. Get the user back
4. Display the user

```
# Final results:
Array
(
    [username] => John Doe
    [email] => john.doe@example.com
    [created_on] => {creation_date}
)
```


### 2. Software requirements ###

* [Git](https://git-scm.com/)
* [Docker](https://www.docker.com/)
* [Docker Compose](https://docs.docker.com/compose/)


### 3. How to run the project ###

* Clone the repository
* Enter the project directory
* Run `docker-compose up -d` or `make up`
  (Make command may require installation).


* Website - [http://localhost:8080](http://localhost:8080)
* phpMyAdmin - [http://localhost:8081](http://localhost:8081) (test:test)


### Possible MySQL issues ###
```
# Connection refused error:
SQLSTATE[HY000] [2002] Connection refused

# Solution:
docker exec -it irakli_mysql bash
mysql -u root -p
(Your mysql password, in this case it's "test")
ALTER USER test IDENTIFIED WITH mysql_native_password BY 'test';
```
