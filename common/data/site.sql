-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 09 2014 г., 18:57
-- Версия сервера: 5.5.37-0ubuntu0.13.10.1
-- Версия PHP: 5.5.3-1ubuntu2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `site`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `alias` varchar(255) NOT NULL,
  `view` tinyint(4) NOT NULL,
  `position` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1402059984),
('m130524_201442_init', 1402059986),
('m140528_102106_rbac_init', 1408029602),
('m140714_110240_create_category_table', 1405580345),
('m140716_163227_create_pages_table', 1405580346);

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `snippet` text,
  `content` longtext NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pages_author` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` smallint(6) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'alexandr', 'P-LX9DzNFcFfdvX-qiFotw9PO-crGTpw', '$2y$13$5rrbN/4Smd10MRR3iFWSpewPx/eNDFXZKKECUZuh7/5R41qQoenVu', NULL, 'aesstudio@yandex.ru', 2, 1, 1402071088, 1402071088),
(3, 'test1', '123456', '$2y$13$5Wjo99I2tNH5axEDeGMH9OYGqUVpY0Xw0TY6ABUtIZupGeC3CD/ua', NULL, 'test1@test.loc', 0, 0, 1403286718, 1403358620),
(4, 'test2', 'sQC77bRmGNHTyOjacTWzUxQOjs66Kfmy', '$2y$13$OxFlTTvZ4RxxoN/vWqSf5O.jfgEW4zrVkmtJZq/zARhVNpKnBaIti', NULL, 'test2@test.loc', 0, 1, 1403287159, 1403287159),
(5, 'test3', 'R1d3HgrmquJrP-ppTzQbqvSwwJ0gVrZQ', '$2y$13$fF/5lUM4nZIYQL/qdqIQ6eEztYrxDmwF0GvVK9T540zV2D8QKh6tu', NULL, 'test3@test.loc', 3, 1, 1403287185, 1403287185),
(6, 'test4', 'I0UFwKf7mhaKOxtpJDtyAFIzPsECHI4c', '$2y$13$4Ap.pC7STFRmRNW5En77nuRlzAORefhlKs678r57DV2LEe/bdsK9C', NULL, 'test4@test.loc', 3, 1, 1403287247, 1403287247),
(7, 'test5', 'j0crvXY3MSoTjtED_n2Wg-renRd9WcHp', '$2y$13$GN/eI1EYd7aSKx9xLrn6q.26gjkivlxrH3omizIzAgGMJwrWsxaMK', NULL, 'test5@test.loc', 0, 1, 0, 1403360302),
(8, 'test6', 'zMBaSNA_vnjbbK_WpGpsPe1lYFn4Npdq', '$2y$13$q3uZqxS1QnE2uOjOt4HOtOF8o0USQU4HCtOTpy4UQmrayl2TwLpei', NULL, 'test6@test.loc', 0, 1, 1403287720, 1403287720),
(9, 'test11', 'wtVXnbbwBLgj1tRYwH4UbnE7jpmQ5jgK', '$2y$13$.c.jiFhb/WbQLvK/pIzKH.oj7AeHbJLkFg2/EHYphN.0c.PWkOZO6', NULL, 'test11@test.loc', 0, 2, 1403460541, 1410269153),
(10, 'test12', '8LokRZmtN1-VDvEs9AagqJ_HfoyI8b_w', '$2y$13$Mt.bK9LxWFzmPJpr/8/34.7a7JOL/KChC9sWbngS4aEB3tfvn.JPO', NULL, 'test12@test.loc', 0, 0, 1403461087, 1403461087),
(11, 'test13', 'Kov8SJuL56xGksLrNobOod3oELWYaJpe', '$2y$13$/VJETql73rjHvaQL7JxwS.xjGtfN3m.Srao7QSi94kbyTejpKHcRa', NULL, 'test13@test.loc', 0, 0, 1403612062, 1403612062),
(12, 'test14', 'NhkUVN3lqT6dz1z-g6eSrB24l_eSQSGb', '$2y$13$8Ngc2Tk3rh4mdpcb75tDXeC/HNTcjCZQe3Gabqw71mBsRUt1GaWhW', NULL, 'test14@test.loc', 0, 0, 1403612681, 1403612681),
(13, 'test15', 'M_fDKVAxGYj9l-UVZojbUzKaJ-hnrTHY', '$2y$13$wnDkl7HEfFxYqkBuUrcH6.2/6zneDUcHokQnHuHnacuW52T4jP2US', NULL, 'test15@test.loc', 0, 0, 1403613216, 1403613216);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `FK_pages_author` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;