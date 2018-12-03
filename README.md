# OWOX PHP School (финальный проект)

Поднимаем проект
--------
1. Клоним репозиторий целиком или просто качаем файл `docker-compose.yml.demo` и переименовываем `docker-compose.yml`

2. В директории с фалом `docker-compose.yml` выполняем:
```bash
$ docker-compose up
```
3. Запускаем сервисный проект:
```bash
$ docker-compose exec service-php-fpm composer install \
   && docker-compose exec service-php-fpm php bin/console app:set-up \
   && docker-compose exec -d service-php-fpm supervisord -c /etc/supervisor.conf
```
4. Запускаем основной проект:
```bash
$ docker-compose exec main-php-fpm composer install \
   && docker-compose exec main-php-fpm php bin/console app:set-up \
   && docker-compose exec main-php-fpm php bin/console app:run-sync
```
5. Ждем пока выполняться миграции и синхронизация с сервисом ...

6. Добавляем в /etc/hosts
```bash
127.0.0.1 myproject.ll
127.0.0.1 admin.myproject.ll
127.0.0.1 service.myproject.ll
```

URLs проекта:
--------
```
http://myproject.ll/
http://admin.myproject.ll/
http://service.myproject.ll:8080/
```

Основной проект (доп. команды для разработки)
--------
1. Устновить зависимости npm
```bash
$ docker-compose exec main-php-fpm npm install
```
2. Отчистить базу данных
```bash
$ docker-compose exec main-php-fpm php bin/console app:set-down
```

Сервисный проект (доп. команды для разработки)
--------
1. Ручной запуск воркеров:
```bash
$ docker-compose exec service-php-fpm php bin/console app:initial-sync
$ docker-compose exec service-php-fpm php bin/console app:update-top
```
2. Устновить зависимости npm
```bash
$ docker-compose exec service-php-fpm npm install
```
3. Отчистить базу данных
```bash
$ docker-compose exec service-php-fpm php bin/console app:set-down
```
4. Проверка очередей RebbitMQ
```bash
$ rabbitmqctl list_queues
```