<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Портал для проведения соревнований по робофутболу

### Введение

Данный проект разрабатывался [Морозом Иваном](https://github.com/Hnakra) совместно с [Соловьевой Дарьей](https://github.com/creasold), [Антиповской Ольгой](https://github.com/OlgaAntipovskaia) и [Мороз Ириной](https://github.com/irinamoroz789) в рамках группового проекта по дисциплине "Технологии разработки программного обеспечения" на 4 курсе ФИПМ ПСТГУ.

После разработки проект был запущен для проведения реальных соревнований по робофутболу [Петренко Эдуардом](https://github.com/EduardPetrenko) на домене [moon.rfbl.ru](http://moon.rfbl.ru/). Данный open-source проект дорабатывается для проведения соревнований бóльшим количеством тренеров и судей.

### Описание функционала

Данный портал имеет следующие функции:

1.	Регистрация участников и формирование команд; 
2.	Составление графика турниров и формирование плана игр(матчей), в ручном и автоматизированном виде; 
3.	Ведение статистики игр и итогов турниров (списка прошедших матчей); 
4.	Каталог площадок для игр; 
5.	Личные кабинеты для разных типов пользователей (администратор, организатор, тренер, игрок);
6.	Механизм нотификации игроков; 
7.	Страницы площадок, пользователей и роботов;
8.  Фильтрация статистики игр, а также поиск по фильтрам.

### Иные ссылки
[Тестирование портала](https://github.com/Hnakra/lunar_walker_portal/blob/main/tests/README.md)


### Стек технологий

- php 8.1
- laravel 8.83.27
- livewire 2.10
- jetstream 2.6
- nginx
- mysql 8.0
- supervisord для автоматического запуска и бесперебойной работы очереди

Проект запакован в несколько docker-контейнеров, с которыми можно ознакомиться в файле [docker-compose.yml](https://github.com/Hnakra/lunar_walker_portal/blob/main/docker-compose.yml)

По всем замечаниям и предложениям, пишите на почту [VanekMRZ@yandex.ru](mailto:VanekMRZ@yandex.ru)
