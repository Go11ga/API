# Эмуляция API

## GET
http://api/api/categories - получить все категории
http://api/api/categories/1 - получить категорию по id, принимается параметр: id

## POST
http://api/api/categories/title?title=sdfg&categ=12345 - добавить категорию, принимается два параметра: title и categ

## PUT
http://api/api/categories/3?title=sdsdf&categ=12345 - обновить категорию, принимается три параметра: id, title и categ

## DELETE
http://api/api/categories/1 - удалить категорию по id, принимается параметр: id

### На хостинге не работает из-за PUT и DELETE, нужен фреймворк для эмуляции