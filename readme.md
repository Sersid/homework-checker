# Помощник проверки тестового задания

## Установка
Требуется поддержка Makefile и Docker.
```bash
make install
```


## Проверка задания

1) Код заданий размещается в папке src
2) Запуск тестов:
```bash
make bash
vendor/bin/phpunit --testdox
```
