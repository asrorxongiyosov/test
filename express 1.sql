-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:33666
-- Время создания: Дек 07 2021 г., 16:05
-- Версия сервера: 8.0.24
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `express`
--

-- --------------------------------------------------------

--
-- Структура таблицы `food`
--

CREATE TABLE `food` (
  `food_id` int NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `food`
--

INSERT INTO `food` (`food_id`, `name`, `type`, `user_id`) VALUES
(1, 'Lavash', 'Fast Food', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `order_time` varchar(50) DEFAULT NULL,
  `food_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `address`, `order_time`, `food_id`) VALUES
(1, 'Chilonzod', '13:00', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `restourant`
--

CREATE TABLE `restourant` (
  `restourant_id` int NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `food_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `restourant`
--

INSERT INTO `restourant` (`restourant_id`, `name`, `address`, `food_id`) VALUES
(1, 'Fed up', 'Qoraqamish', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `password` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '/users/photos/0.png',
  `contact` varchar(50) NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `name`, `password`, `email`, `photo`, `contact`, `role`) VALUES
(1, 'Zafarbek', '1202', 'zafarbektoraxonov@gmail.com', '/users/photos/0.png', '+998904172002', 'admin'),
(2, 'Azamjon', '123456789', 'yusupov@gmail.com', '/users/photos/0.png', '+998997892001', 'user'),
(11, 'Mirabzal', '1111', 'yusupov@gmail.com', '/users/photos/0.png', '+998997892001', 'user'),
(12, 'Murod', '1111', 'zafarbektoraxonov@gmail.com', '/users/photos/0.png', '+998904172002', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Индексы таблицы `restourant`
--
ALTER TABLE `restourant`
  ADD PRIMARY KEY (`restourant_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `name` (`name`,`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `food`
--
ALTER TABLE `food`
  MODIFY `food_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `restourant`
--
ALTER TABLE `restourant`
  MODIFY `restourant_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `food_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `food` (`food_id`);

--
-- Ограничения внешнего ключа таблицы `restourant`
--
ALTER TABLE `restourant`
  ADD CONSTRAINT `restourant_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `food` (`food_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
