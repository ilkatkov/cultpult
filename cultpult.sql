-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 23 2021 г., 16:38
-- Версия сервера: 5.7.32-0ubuntu0.16.04.1
-- Версия PHP: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cultpult`
--

-- --------------------------------------------------------

--
-- Структура таблицы `age_categories`
--

CREATE TABLE `age_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `archive`
--

CREATE TABLE `archive` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `ticket` int(10) NOT NULL COMMENT 'Номер билета',
  `participant_id` int(11) DEFAULT NULL,
  `event` varchar(256) DEFAULT NULL,
  `reg_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `passport_num` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `documents`
--

INSERT INTO `documents` (`id`, `passport_num`, `user_id`) VALUES
(1, '1234567890', 26);

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(256) NOT NULL,
  `curator` varchar(64) DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lon` float DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `events`
--

INSERT INTO `events` (`id`, `name`, `curator`, `type`, `lat`, `lon`, `date`) VALUES
(1, 'Конференция «Курская битва. Страницы истории»', NULL, 'place', 51.0418, 36.7471, '2021-05-26'),
(2, 'Передвижной выставочный проект «Славные сыны Отечества»', NULL, 'place', 50.4897, 37.8538, '2021-06-04'),
(3, 'Час памяти «Вспомним первый день войны»', NULL, 'place', 50.4897, 37.8538, '2021-06-22'),
(4, 'Тематический час «Тот самый первый день войны»', NULL, 'place', 50.8845, 35.9001, '2021-06-22'),
(5, 'Литературно-поэтический час «Слов хрустальный перезвон»', NULL, 'place', 50.8845, 35.9001, '2021-06-06'),
(6, 'Библиотечный Интеллектуальный Сезон «Весенние фантазии»', NULL, 'place', 50.7687, 37.4779, '2021-05-27'),
(7, 'Пушкинский час «У лукоморья»', NULL, 'place', 49.8898, 38.9187, '2021-06-04'),
(8, 'Экскурс в историю «В храме умных мыслей»', NULL, 'place', 50.7143, 37.3821, '2021-05-27'),
(9, 'Встреча «Мир сказок и стихотворений – это Пушкин – добрый гений»', NULL, 'place', 50.2719, 38.9512, '2021-06-05'),
(10, 'Час поэзии «Изящной лирики перо»', NULL, 'place', 50.0838, 38.9564, '2021-06-04'),
(11, 'Онлайн-встреча «В семейном кругу мы жизнь создаем»', NULL, 'place', 50.5196, 35.6837, '2021-05-25'),
(12, 'Встреча «Страна, что называется великой»', NULL, 'place', 50.6167, 36.5806, '2021-06-07'),
(13, 'Встреча «Давайте Пушкина читать!»', NULL, 'place', 49.8447, 39.035, '2021-06-04'),
(14, 'Мастер-класс «Оригами»', NULL, 'place', 50.5677, 36.5536, '2021-06-29'),
(15, 'Флешмоб «Прекрасно жить без сигарет, мы табаку ответим: «Нет!»', NULL, 'place', 50.7638, 35.5444, '2021-05-30'),
(16, 'Митинг «Помнить, чтобы жить»', NULL, 'location', 50.6455, 36.5692, '2021-06-21'),
(18, '«Собирайся детвора, ведь гулять пришла пора»', NULL, 'location', 50.812, 35.4366, '2021-06-01'),
(19, 'Выставка «Казачество в русской литературе»', NULL, 'place', 50.6167, 36.5806, '2021-06-17'),
(20, 'Мастер-класс «Магнит на холодильник»', NULL, 'place', 50.1175, 38.0724, '2021-05-29'),
(21, 'Час истории «Наша память священна»', NULL, 'place', 50.0417, 38.007, '2021-05-29'),
(22, 'Беседа «Все о вредных привычках»', NULL, 'place', 50.2892, 38.3621, '2021-05-29'),
(23, 'Программа «Волшебный мяч»', NULL, 'place', 50.1005, 38.2281, '2021-05-29'),
(24, 'Беседа «Мир без нацизма»', NULL, 'place', 50.2932, 38.2517, '2021-05-29'),
(25, 'Программа «Троицкие забавы»', NULL, 'place', 50.8801, 36.0162, '2021-06-17'),
(26, 'Игровая дискотека «Веселый экспресс»', NULL, 'place', 50.2105, 38.1026, '2021-06-01'),
(27, 'Программа «Страна дорожных знаков»', NULL, 'place', 50.8801, 36.0162, '2021-06-08'),
(28, 'Экзамен для обучающихся отделения фортепиано', NULL, 'place', 50.7837, 37.8676, '2021-05-24'),
(29, 'Познавательно-игровая программа «Мифы и реальность о курении»', NULL, 'place', 50.7638, 35.5444, '2021-05-30'),
(30, 'Программа «Скажем наркотикам – Нет!»', NULL, 'place', 50.8801, 36.0162, '2021-06-24'),
(31, '«Танец–это жизнь»', NULL, 'place', 50.7837, 37.8676, '2021-05-24'),
(32, 'Программа «Детство – лучшая пора»', NULL, 'place', 50.8801, 36.0162, '2021-06-01'),
(33, 'Программа «Лета яркий серпантин»', NULL, 'place', 50.7387, 35.8959, '2021-06-01'),
(34, 'Развлекательные конкурсы «Я в теме»', NULL, 'place', 50.2683, 38.2312, '2021-05-29'),
(35, 'Развлекательная программа - «Планета детства»', NULL, 'place', 50.7417, 35.695, '2021-06-01'),
(36, 'Программа «Орден твоего деда»', NULL, 'place', 50.7387, 35.8959, '2021-06-10'),
(37, 'Выставка «Семья глазами ребенка»', NULL, 'place', 51.1026, 36.1119, '2021-05-26'),
(38, 'Интеллектуальная игра «Вокруг кубика Рубика»', NULL, 'place', 50.1187, 38.0733, '2021-05-29'),
(39, 'Молодёжная дискотека «Танцуй, пока молодой!»', NULL, 'place', 51.126, 37.4058, '2021-06-05'),
(40, 'Концерт «Радуга планеты Детство»', NULL, 'place', 50.6078, 36.0118, '2021-06-01'),
(41, '«Молодежь у руля»', NULL, 'place', 50.2756, 38.9475, '2021-06-27'),
(42, 'Я б в библиотекари пошел...', NULL, 'place', 50.7865, 37.2853, '2021-05-27'),
(43, 'Игровая программа «Приз табло»', NULL, 'place', 50.7852, 36.4854, '2021-06-04'),
(44, 'Программа «У летних ворот – игровой хоровод»', NULL, 'place', 50.7387, 35.8959, '2021-06-15'),
(45, 'Программа «Моё безопасное лето»', NULL, 'place', 50.776, 35.9917, '2021-06-03'),
(46, '«Это всё–Россия»', NULL, 'place', 50.2756, 38.9475, '2021-06-12'),
(47, '«Дарите детям радость»', NULL, 'place', 50.0576, 39.0685, '2021-06-01'),
(48, '«Посади дерево»', NULL, 'place', 50.0576, 39.0685, '2021-06-05'),
(49, '«Вместе весело шагать…»', NULL, 'place', 50.2756, 38.9475, '2021-06-01'),
(50, 'Экзамен для обучающихся отделения народных инструментов', NULL, 'place', 50.7837, 37.8676, '2021-05-24'),
(51, 'Программа «Родина моя Россия»', NULL, 'place', 50.7387, 35.8959, '2021-06-12'),
(52, 'Программа «Спортивный калейдоскоп»', NULL, 'place', 50.7387, 35.8959, '2021-06-18'),
(53, 'Программа «Дом под крышей голубой»', NULL, 'place', 50.776, 35.9917, '2021-06-05'),
(54, 'Программа «Мои года – моё богатство»', NULL, 'place', 50.776, 35.9917, '2021-06-13'),
(55, 'Игра «Просыпается мафия»', NULL, 'place', 51.2843, 37.5339, '2021-05-26'),
(56, 'Программа «Путешествие в страну дорожных знаков»', NULL, 'place', 50.7387, 35.8959, '2021-06-19'),
(57, 'Вечер памяти «Чтобы не забылась та война»', NULL, 'place', 51.126, 37.4058, '2021-06-27'),
(58, 'Мастер-класс «Добрых рук мастерство»', NULL, 'place', 50.7387, 35.8959, '2021-06-29'),
(59, 'Встреча «Любить природу – творить добро»', NULL, 'place', 49.9927, 39.2421, '2021-06-05'),
(60, 'Квиз «Эйнштейн-party»', NULL, 'place', 51.3114, 37.8955, '2021-05-27'),
(61, 'Музейный праздник для детей «К Пушкину. Сквозь время и пространство»', NULL, 'place', 50.5976, 36.599, '2021-06-04'),
(62, 'Библиотечный микс «Мы живем в России»', NULL, 'place', 51.2465, 38.0164, '2021-06-10'),
(63, '«Как избежать беды»', NULL, 'place', 50.0576, 39.0685, '2021-06-15'),
(64, '«Россия – Родина моя!»', NULL, 'place', 50.0576, 39.0685, '2021-06-12'),
(65, '«Ура каникулы»', NULL, 'place', 50.7837, 37.8675, '2021-06-01'),
(66, 'Отчетные концерты «Мир творчества»', NULL, 'place', 50.7852, 36.4854, '2021-06-05'),
(67, 'Познавательная программа «Сказок мудрые уроки»', NULL, 'place', 51.126, 37.4058, '2021-06-06'),
(68, 'Программа «Чистый воздух»', NULL, 'place', 50.8741, 35.6869, '2021-06-05'),
(69, 'Бенефис читающей семьи «Счастье быть читателем»', NULL, 'place', 51.3164, 37.8812, '2021-05-26'),
(70, 'Праздничная программа для младших школьников «Россия – родина моя!»', NULL, 'place', 50.5976, 36.599, '2021-06-11'),
(71, 'Акция «Дыши полной грудью»', NULL, 'place', 50.3245, 38.0493, '2021-05-30'),
(73, '«Буквы, строчки».', NULL, 'place', 50.6453, 37.6795, '2021-05-26'),
(74, 'Познавательная программа «История казачества»', NULL, 'place', 51.126, 37.4058, '2021-06-30'),
(75, 'Виртуальный концерт «Детство – это дружба и мечты»', NULL, 'place', 50.6247, 36.5807, '2021-06-01'),
(76, 'Поэтический калейдоскоп «Русские поэты о родной природе»', NULL, 'place', 50.2695, 37.9633, '2021-05-30'),
(77, 'Городской фестиваль «Игры нашего двора»', NULL, 'place', 50.7852, 36.4854, '2021-06-16'),
(78, 'Танцевально–развлекательные программы «Давайте потанцуем!»', NULL, 'place', 50.7852, 36.4854, '2021-06-03'),
(79, 'Фестиваль рисунков «Двор, в котором я живу»', NULL, 'place', 51.3628, 37.4993, '2021-05-28'),
(80, 'Программа «Неразрывна связь»', NULL, 'place', 50.8741, 35.6869, '2021-06-02'),
(81, 'Праздничная программа «Хорошие соседи – надежные друзья!»', NULL, 'place', 51.3628, 37.4993, '2021-05-28'),
(82, 'Мир творчества', NULL, 'place', 51.2678, 38.078, '2021-06-09'),
(83, 'Квест «Форд Кураж»', NULL, 'place', 50.6231, 36.4382, '2021-05-26'),
(84, 'Игровая познавательная программа «В гостях у пожарного огонька»', NULL, 'place', 51.1451, 38.2735, '2021-05-26'),
(85, '«День без табака»', NULL, 'place', 50.6554, 37.5658, '2021-06-30'),
(86, 'Концерт «Jazz Не Джаззз»', NULL, 'place', 51.3164, 37.8812, '2021-05-28'),
(87, '«Берегите природу»', NULL, 'place', 50.6554, 37.5658, '2021-05-26'),
(88, '«За здоровый образ жизни»', NULL, 'place', 50.6554, 37.5658, '2021-05-28'),
(89, 'Конкурс «Скоро лето!»', NULL, 'place', 50.1514, 38.0009, '2021-05-30'),
(90, '«Вот оно, какое наше лето»', NULL, 'place', 50.7837, 37.8675, '2021-06-01'),
(91, 'Игровая программа «Здравствуй лето».', NULL, 'place', 50.6231, 36.4382, '2021-05-31'),
(92, '«Волшебство своими руками»', NULL, 'place', 50.7837, 37.8675, '2021-06-01'),
(93, '«Доктор Айболит»', NULL, 'place', 50.7837, 37.8675, '2021-06-01'),
(94, 'Онлайн-конкурс «О тебе Россия»', NULL, 'place', 50.6078, 36.0118, '2021-06-01'),
(95, 'Выставка военно–патриотической литературы «Час мужества пробил»', NULL, 'place', 51.3114, 37.8955, '2021-06-21'),
(96, 'Ринг эрудитов «Это все о России»', NULL, 'place', 51.1829, 37.9768, '2021-06-11'),
(97, '«Василий Тёркин»', NULL, 'place', 51.3114, 37.8955, '2021-06-22'),
(98, 'Литературно–музыкальный вечер «Нам повезло–мы родились в России!', NULL, 'place', 51.1129, 37.8867, '2021-06-11'),
(99, '«До свидания, детский сад!»', NULL, 'place', 50.774, 36.6537, '2021-05-28'),
(100, 'Книжный микс «Мы интересны миру, мир интересен нам»', NULL, 'place', 51.3114, 37.8955, '2021-06-24');

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_id` int(11) NOT NULL,
  `member_count` int(10) NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `institution` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_dressed` tinyint(1) NOT NULL,
  `is_instrument` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` int(11) NOT NULL,
  `date` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `participants`
--

CREATE TABLE `participants` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `name` varchar(32) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `patronymic` varchar(32) NOT NULL,
  `event` varchar(256) NOT NULL COMMENT 'Группа',
  `pin` varchar(32) NOT NULL COMMENT 'PIN-код'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `participants`
--

INSERT INTO `participants` (`id`, `name`, `surname`, `patronymic`, `event`, `pin`) VALUES
(3, 'Тест', 'Тестович', 'Тестов', '«Берегите природу»', 'd7afbcbf0c607f9d0eb290a4e6c554de'),
(5, 'Илья', 'Катков', 'Евгеньевич', '«Танец–это жизнь»', 'ae576058f69c16509fa7740cd9b59c39'),
(6, 'Сергей', 'Краснояружский', 'Евгеньевич', '«Танец–это жизнь»', '3f9dc2a3efaa3b24e757bcdb3fd3146c');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL COMMENT 'ID',
  `login` varchar(64) NOT NULL COMMENT 'Логин',
  `name` varchar(128) DEFAULT NULL,
  `state` varchar(1) NOT NULL,
  `event` varchar(256) DEFAULT NULL,
  `password` varchar(64) NOT NULL COMMENT 'Пароль'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `name`, `state`, `event`, `password`) VALUES
(1, 'ilkatkov', 'Катков Илья Евгеньевич', '5', NULL, '93b4a86e5b67171c36e9ab4acc1350ce'),
(26, 'test', 'Тестыч', '1', 'Выставка «Андрей Дмитриевич Сахаров - человек эпохи»', '098f6bcd4621d373cade4e832627b4f6'),
(27, 'admin', 'admin', '5', NULL, '21232f297a57a5a743894a0e4a801fc3'),
(28, 'nastya', 'настя', '1', 'Мастер-класс «Оригами»', 'f7126b1ce9faf63a53673ccb3de5f653');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `age_categories`
--
ALTER TABLE `age_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket` (`ticket`),
  ADD KEY `archive_ibfk_2` (`participant_id`),
  ADD KEY `event` (`event`);

--
-- Индексы таблицы `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Индексы таблицы `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pin` (`pin`),
  ADD KEY `event` (`event`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_ibfk_1` (`event`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `age_categories`
--
ALTER TABLE `age_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `archive`
--
ALTER TABLE `archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT для таблицы `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=29;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `archive`
--
ALTER TABLE `archive`
  ADD CONSTRAINT `archive_ibfk_2` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `archive_ibfk_3` FOREIGN KEY (`event`) REFERENCES `events` (`name`);

--
-- Ограничения внешнего ключа таблицы `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Ограничения внешнего ключа таблицы `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Ограничения внешнего ключа таблицы `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`event`) REFERENCES `events` (`name`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
