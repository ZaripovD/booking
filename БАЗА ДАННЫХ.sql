-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 13 2019 г., 08:39
-- Версия сервера: 10.1.39-MariaDB
-- Версия PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `friendly_hotel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `booking`
--

CREATE TABLE `booking` (
  `id` int(5) UNSIGNED NOT NULL,
  `id_room_book` int(5) UNSIGNED NOT NULL,
  `id_user` int(5) UNSIGNED NOT NULL,
  `summary` int(10) UNSIGNED NOT NULL,
  `id_worker` int(5) UNSIGNED NOT NULL DEFAULT '1',
  `id_status` int(5) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `booking`
--

INSERT INTO `booking` (`id`, `id_room_book`, `id_user`, `summary`, `id_worker`, `id_status`) VALUES
(1, 1, 2, 700, 3, 2),
(2, 2, 2, 1040, 5, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `ID` int(5) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`ID`, `name`) VALUES
(1, 'Пользователь'),
(2, 'Администратор');

-- --------------------------------------------------------

--
-- Структура таблицы `room`
--

CREATE TABLE `room` (
  `id` int(5) UNSIGNED NOT NULL,
  `number` int(5) UNSIGNED NOT NULL,
  `roominess` int(3) UNSIGNED NOT NULL,
  `id_type` int(5) UNSIGNED NOT NULL,
  `price` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `room`
--

INSERT INTO `room` (`id`, `number`, `roominess`, `id_type`, `price`) VALUES
(1, 1, 1, 1, 80),
(2, 2, 1, 1, 100),
(3, 3, 2, 1, 180),
(4, 4, 2, 2, 400),
(5, 5, 2, 3, 780),
(6, 6, 1, 2, 200),
(7, 7, 1, 3, 370),
(8, 50, 2, 3, 800),
(9, 45, 2, 2, 430);

-- --------------------------------------------------------

--
-- Структура таблицы `room_book`
--

CREATE TABLE `room_book` (
  `id` int(5) UNSIGNED NOT NULL,
  `id_room` int(5) UNSIGNED NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `room_book`
--

INSERT INTO `room_book` (`id`, `id_room`, `start`, `end`) VALUES
(1, 2, '2019-06-13', '2019-06-20'),
(2, 1, '2019-06-15', '2019-06-28');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Рассматривается'),
(2, 'Одобрено');

-- --------------------------------------------------------

--
-- Структура таблицы `type`
--

CREATE TABLE `type` (
  `ID` int(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `type`
--

INSERT INTO `type` (`ID`, `name`) VALUES
(1, 'Стандарт'),
(2, 'Полулюкс'),
(3, 'Люкс');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(5) UNSIGNED NOT NULL,
  `name` char(100) NOT NULL,
  `family` char(100) NOT NULL,
  `father` char(100) NOT NULL,
  `passport` text NOT NULL,
  `phone` text NOT NULL,
  `id_role` int(5) UNSIGNED NOT NULL DEFAULT '1',
  `_password` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `family`, `father`, `passport`, `phone`, `id_role`, `_password`) VALUES
(1, 'Иван', 'Карпов', 'Владимирович', '1234556677', '89173394567', 2, '7488e331b8b64e5794da3fa4eb10ad5d'),
(2, 'Данияр', 'Зарипов', 'Наилевич', '4455332211', '89963369165', 1, '306ea948ac8e510163fc1730fb78e6cf');

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `id` int(5) UNSIGNED NOT NULL,
  `family` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `father` varchar(50) NOT NULL,
  `passport` text NOT NULL,
  `phone` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`id`, `family`, `name`, `father`, `passport`, `phone`) VALUES
(1, 'НЕ', 'НАЗНАЧЕН', '', '', ''),
(3, 'Бажитова', 'Кристина', 'Сергеевна', '2233445566', '89993334567'),
(4, 'Семенина', 'Светлана', 'Евгеньевна', '7788990011', '1231234455'),
(5, 'Курбанова', 'Алсу', 'Марсовна', '0000998877', '0009876655'),
(6, 'Даутова', 'Зилия', 'Римовна', '7788665544', '6667778899'),
(7, 'Шакирова', 'Эльза', 'Рустемовна', '7788665543', '6667778892'),
(8, 'Якупова', 'Лейла', 'Рамилевна', '1896004455', '6667774455');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_room` (`id_room_book`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_worker` (`id_worker`),
  ADD KEY `id_status` (`id_status`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type` (`id_type`);

--
-- Индексы таблицы `room_book`
--
ALTER TABLE `room_book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_room` (`id_room`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_role` (`id_role`);

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `ID` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `room`
--
ALTER TABLE `room`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `room_book`
--
ALTER TABLE `room_book`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `type`
--
ALTER TABLE `type`
  MODIFY `ID` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_room_book`) REFERENCES `room_book` (`id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`id_worker`) REFERENCES `workers` (`id`),
  ADD CONSTRAINT `booking_ibfk_4` FOREIGN KEY (`id_status`) REFERENCES `status` (`id`);

--
-- Ограничения внешнего ключа таблицы `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`id_type`) REFERENCES `type` (`ID`);

--
-- Ограничения внешнего ключа таблицы `room_book`
--
ALTER TABLE `room_book`
  ADD CONSTRAINT `room_book_ibfk_1` FOREIGN KEY (`id_room`) REFERENCES `room` (`id`);

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
