# Simple REST application

## Установка

Находясь в директории приложения. запустить в терминале:

```
composer install
```

Заполнить конфиг config/db.php

Далее, запустить миграции: 
 
```
vendor/bin/doctrine-migrations migrations:migrate
```

Запустить сервер

```
php -S localhost:8282 -t public/
```

###При необходимости поднять базу, можно воспользоваться docker-compose:

```
docker-compose -f data/docker-compose/stack.yml up
```

Узнать ip хоста для подключения

```
docker ps
```

![docker ps](https://gyazo.com/95688e96b389254564a992f49983dc8f)

```
docker inspect <container-id>
```

![docker inspect](https://gyazo.com/eec049b52a62431916b5d3aa3cdf2ef2)


## Использование

##### Создание 20 товаров

* GET /api/generate


##### Вывод списка товаров

* GET /api/goods/{page}/{count}
* page - Страница. Необязательный параметр
* count - Количество элементов на странице. Необязательный параметр


##### Создание заказа

* POST /api/make_order

```
{
	"data":{
		"goods":[1,2,4]
	}
}
```

##### Оплата заказа

* POST /api/pay_order

```
{
	"data":{
		"order":1
	}
}
```

##### Вывод списка заказов

* GET /api/orders/{page}/{count}
* page - Страница. Необязательный параметр
* count - Количество элементов на странице. Необязательный параметр