Freyja Project
======

## Documentation
* You can explore the documentation of the application right here : http://docs.lexteam-executive.com/freyja

## Badges
[![CircleCI](https://circleci.com/gh/lexteamexecutive/freyja/tree/master.svg?style=svg)](https://circleci.com/gh/lexteamexecutive/freyja/tree/master)

Authors :
* Mathieu JUSTEAU
* Christophe CAVANNA <cavannachristophe@gmail.com>

## Coding Style

PSR2 Symfony [doc](http://www.php-fig.org/psr/psr-2/)

## Deploy

Go to [PENDING]

## Docker

Check our [documentation](https://github.com/lexteamexecutive/freyja-docker) to init your docker environment.

## Vendors
```
docker-compose exec freyja composer install
```

## Permissions
```
docker-compose exec freyja setfacl -Rm u:www-data:rwx /var/www/freyja/var/
```

## Tests
```
docker-compose exec freyja vendor/bin/phpunit -c app/phpunit.xml
```
