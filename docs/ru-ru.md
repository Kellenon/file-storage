## Для чего нужен?
Файловый сервис предоставляет различные api для работы с файлами. Теперь больше не придется во всех проектах реализовывать функционал работы с файлами. Просто используем библиотеки по работе с `http`, и далее работаем с полученным ответом.

## Какие методы предоставляет файловый сервис?

### Метод приветствия
/api/v1

**Метод HTTP запроса**
```php
GET
```

**Для чего нужен?**

Данный метод нужен для проверки работоспособности файлового сервиса. Если код ответа `200`, значит работает.

### Метод авторизация
/api/v1/auth/login

**Метод HTTP запроса**
```php
POST
```

**Входные параметры**
- email
- password

**Правила валидации**
```php
'email' => 'email|string|min:1|max:255',
'password' => 'string|min:1|max:255',
```

**Примечание**

После авторизации меняется `api_token`. Будьте аккуратны.

**Пример возвращаемого ответа**
```php
{
    "token": "GzsSr4AXEjiNKrCvIpoggPl2JsPg4NAm0t8cCZBrK1DscUmnaupWHjPeARnMX75mGVpxKcl5JvjwOZ8I",
    "type": "bearer"
}
```

<hr/>

### Метод создания
/api/v1/file/create

**Метод HTTP запроса**
```php
POST
```


**Входные параметры**
- content
- extension
- category
- service
- description
- metadata
- availableUntil
- specialPath

**Правила валидации**
```php
'content' => 'required|string|min:1|max:10485760',
'extension' => 'required|string|in:txt,json,xml,yaml',
'category' => 'required|string|min:1|max:255',
'service' => 'required|string|min:1|max:255',
'description' => 'string|min:1|max:5000',
'metadata' => 'array|max:20',
'specialPath' => 'string|min:1|max:255',
'availableUntil' => 'date',
```

**Пример возвращаемого ответа**
```php
{
    "url": "https://my-file-service.ru/storage/services/my-service.ru/ticket/result/2022/12/14/z2JChw8YNpdOdvTfr8hH8AeYtaeSEWkyDZAEDBOu.txt",
    "description": null,
    "available_until": null,
    "metadata": "{\"extension\":\"txt\"}",
    "uuid": "ae7707cf-5f3d-4805-b25e-5532c14b1c88",
    "updated_at": "2022-12-14T14:08:32.000000Z",
    "created_at": "2022-12-14T14:08:32.000000Z"
}
```

**Пример параметров запроса**
```php
content:Тестовый контент
category:ticket.result
service:my-service.ru
extension:txt
```

<hr/>

### Метод загрузки
/api/v1/file/upload

**Метод HTTP запроса**
```php
POST
```

**Входные параметры**
- files
- category
- service
- description
- metadata
- availableUntil
- specialPath

**Правила валидации**
```php
'files' => 'required',
'files.*' => 'file|max:102400|mimes:jpg,png,pdf,doc,docx,gif,xls,xlsx,txt,ppt,pptx,xml,csv,heic,jpeg,json',
'category' => 'required|string|min:1|max:255',
'service' => 'required|string|min:1|max:255',
'description' => 'string|min:1|max:5000',
'specialPath' => 'string|min:1|max:255',
'metadata' => 'array|max:20',
'availableUntil' => 'date',
```

**Пример возвращаемого ответа**
```php
[
    {
        "url": "https://my-file-service.ru/storage/services/my-service.ru/ticket/document/2022/12/14/wg8H8V3dPW1arX0KS9bUpXSriWFaGNhZX8A7TzHP.jpg",
        "description": null,
        "available_until": null,
        "metadata": "{\"user\":{\"name\":\"admin\"},\"originalName\":\"543534\",\"extension\":\"jpg\"}",
        "uuid": "b7fc837e-b995-49e2-8554-64b2333c873b",
        "updated_at": "2022-12-14T14:02:49.000000Z",
        "created_at": "2022-12-14T14:02:49.000000Z"
    }
]
```

**Пример параметров запроса**
```php
category:ticket.document
service:my-service.ru
metadata[user][name]:admin
files[0]:uploaded_file.jpg
```

<hr/>

### Метод удаления
/api/v1/file/remove

**Метод HTTP запроса**
```php
POST
```

**Входные параметры**
- uuid

**Правила валидации**
```php
'uuid' => 'required|uuid',
```

**Пример возвращаемого ответа**
```php
{
    "success": true,
    "message": "Файл был успешно удален"
}
```

**Пример параметров запроса**
```php
uuid:5f253db5-6746-4c36-9705-be71164ab57c
```
<hr/>

### Метод поиска
/api/v1/file/search

**Метод HTTP запроса**
```php
GET
```

**Входные параметры**
- uuid
- service
- category
- metadata

**Правила валидации**
```php
'uuid' => 'required_without:metadata|uuid|min:1|max:255',
'service' => 'string|min:1|max:255',
'category' => 'string|min:1|max:255',
'metadata' => 'array|required_without:uuid|min:1|max:20',
```

**Пример возвращаемого ответа**
```php
{
    "uuid": "b7fc837e-b995-49e2-8554-64b2333c873b",
    "url": "https://my-file-service.ru/storage/services/my-service.ru/device-part-number-files/2022/12/14/wg8H8V3dPW1arX0KS9bUpXSriWFaGNhZX8A7TzHP.jpg",
    "metadata": "{\"user\":{\"name\":\"admin\"},\"originalName\":\"543534\",\"extension\":\"jpg\"}",
    "description": null,
    "available_until": null,
    "created_at": "2022-12-14T14:02:49.000000Z",
    "updated_at": "2022-12-14T14:02:49.000000Z"
}
```

**Или**

```php
[
    {
        "uuid": "86e0afa6-d3bf-4d67-a017-f6afd68b141f",
        "url": "https://my-file-service.ru/storage/services/my-service.ru/device-part-number-files/2022/12/14/vk31TFA32osl8l19wxPS1qFR0Eo8lHscZegN6uh2.jpg",
        "metadata": "{\"user\":{\"name\":\"admin\"},\"originalName\":\"f1e5309a943b9758d56b262b8f70f6e1\",\"extension\":\"jpg\"}",
        "description": null,
        "available_until": null,
        "created_at": "2022-12-14T14:03:47.000000Z",
        "updated_at": "2022-12-14T14:03:47.000000Z"
    },
    {
        "uuid": "b7fc837e-b995-49e2-8554-64b2333c873b",
        "url": "https://my-file-service.ru/storage/services/my-service.ru/device-part-number-files/2022/12/14/wg8H8V3dPW1arX0KS9bUpXSriWFaGNhZX8A7TzHP.jpg",
        "metadata": "{\"user\":{\"name\":\"admin\"},\"originalName\":\"543534\",\"extension\":\"jpg\"}",
        "description": null,
        "available_until": null,
        "created_at": "2022-12-14T14:02:49.000000Z",
        "updated_at": "2022-12-14T14:02:49.000000Z"
    }
]
```

**Примечание**

В случае, если будет присутствовать параметр `uuid`, то будет возвращен 1 файл. Если параметр `uuid` отсутствует, то поиск будет осуществляться за счёт метаданных (metadata) и прочих других параметров. И в конечном итоге вернется массив файлов.

## Описание атрибутов

### Files
Файлы. Максимальный допустимый размер на 25.11.2022 составляет около 100МБ.

**Файловый сервис поддерживает следующие расширения:**
- jpg
- png
- pdf
- doc
- docx
- gif
- xls
- xlsx
- txt
- ppt
- pptx
- xml
- csv
- heic
- jpeg
- json

### Service
Название сервиса (проекта). По умолчанию предполагается, что он будет передаваться автоматически в методах, которые работают с api файлового сервиса.

### Content
Содержимое файла, который хотим создать.

### Extension
Название расширения файла, который хотим создать.

### Uuid
Uuid файла в базе файлового сервиса. О нем становится известно после загрузки файлов.

### Metadata
Метаданные - это обычные параметры, которые мы передаем при загрузках файла, чтоб иметь возможность его в дальнейшем опознать.
То есть если мы загрузили файлы по заявке, то в метаданные желательно передать параметр "ticketId: 1234", чтоб потом иметь возможность найти все файлы связанные с этой заявкой.

### AvailableUntil
Данный параметр позволяет сказать файловому сервису, что данный файл временный до какой-то определенной даты, и что после наступления данной даты его можно будет удалить.

### Category
Категория позволяет создавать папки и подпапки. Подпапки создаются с помощью **точечной нотации**. То есть `ticket.document` будет интерпретироваться как: `ticket/document`

**Пример**

Мы хотим сохранить файлы по заявке, мы указываем **service:** `my-service.ru`, **category:** `ticket.document`. Таким образом путь до файла после загрузки будет следующим:

`services/my-service.ru/ticket/document/текущий_год/текущий_месяц/текущий_день/file_name.extension`

Если бы category было бы только `ticket`, то путь до файла был бы следующим:

`services/my-service.ru/ticket/текущий_год/текущий_месяц/текущий_день/file_name.extension`

### SpecialPath
Специальный путь - это особый путь к файлу, который сформирует файловый сервис вне зависимости от указанной категорий (category).

## FAQ

### Где можно применить метод поиска файлов?
Метод поиска можно применить, если Вы не хотите создавать отдельную таблицу в базе сервиса под файлы. Так же если ссылки на файлы по какой-то причине оказались некорректными.

### Какие заголовки должны присутствовать при запросе?
Для работы с `api` необходимо в `headers` передать `Accept: application/json`

### Что делать, если возникла ошибка Too Many Attempts?
Необходимо перейти в `config/params.php` и найти переменную `countRateLimit`. Далее задать нужно значение.

## Полезные ссылки
1. [Файловое хранилище (Laravel 8.x)](https://laravel.su/docs/8.x/filesystem)
2. [Валидация (Laravel 8.x)](https://laravel.su/docs/8.x/validation)
3. [База данных. Построитель запросов (Laravel 8.x)](https://laravel.su/docs/8.x/queries)
