
![Снимок](https://user-images.githubusercontent.com/55957279/119259739-459a4400-bbd8-11eb-8cc5-1b1a385febbd.PNG)
# КультПульт
Можно попробовать: https://belgoroad.ru/.

Система администрирования культурных мероприятий региона. Функционал включает в себя:
* Сбор заявок как от посетителей мероприятия, так и от творческих коллективов, желающих принять участие в мероприятии;
* Регистрация пришедших на мероприятие путём ввода уникального цифрового кода или, в перспективе, сканирования QR-кода;
* Просмотр календаря событий на интерактивной карте с возможностью фильтрации событий;
* Просмотр и выгрузка ведомостей зарегистрировавшихся и пришедших на мероприятие;
* (в перспективе) Прогнозирование количества пришедших на мероприятие, используя технологии искуственного интеллекта.

Используемые технологии:
* Backend: PHP, PHPWord, MySQL
* Frontend: HTML, CSS, JavaScript, JQuery, Fancybox, Leaflet (карта)

## Установка
В файле `functions/mysql.php` в функции `connectDB()` указать настройки соединения к БД. Импортировать дамп БД `/cultpult.sql`.

## Точки входа
* Главная страница используется для ввода кода для входа на мероприятие.
* Панель администратора доступна по ссылке `{host}/admin`. Данные для входа: логин — admin, пароль — admin.
* Страница регистрации творческих коллективов доступна по адресу `{host}/register`. 
