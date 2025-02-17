# Users

Recruitment task for a job position.<br>

## Local run

### Standard run
- run project
  ```shell
  docker-compose up
  ```
- wait for docker and composer to install all dependencies

### Project is running on:
- [Users front-end](http://users.localhost)

### Other running services (Irrelevant)
- [adminer](http://adminer.localhost/)
- [Fake SMTP mail receiver - MailPit](http://mail.localhost/)

### Usage
- all current users have set 'admin' as default password

### Adminer login
- MYSQL_DATABASE: database
- MYSQL_USER: admin
- MYSQL_PASSWORD: admin
- MYSQL_DATABASE: users


## Built With

* [Nette](https://nette.org/en/) - The web framework used

## Used technology

* PHP
* Nette
* MySQL
* jQuery
* Docker
* GitHub
* Bootstrap
* Contributte Datagrid
* PHPUnit, PHPCS, PHPStan

## Dev commands

Run CodeSniffer:
- docker-compose exec php vendor/bin/phpcbf --standard=ruleset.xml app
- docker-compose exec php vendor/bin/phpcs --standard=ruleset.xml app

Run PHPStan
- docker-compose exec php vendor/bin/phpstan analyse

Run tests (not included):
- docker-compose exec php vendor/bin/phpunit