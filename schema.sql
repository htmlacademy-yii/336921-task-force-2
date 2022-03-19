-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               8.0.24 - MySQL Community Server - GPL
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.3.0.6376
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;


-- Дамп структуры базы данных taskforce
CREATE DATABASE IF NOT EXISTS `taskforce` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `taskforce`;

-- Дамп структуры для таблица taskforce.category
CREATE TABLE IF NOT EXISTS `category`
(
    `id`   int                                                        NOT NULL AUTO_INCREMENT,
    `name` char(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
    `icon` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='Справочник со значениями категорий';

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица taskforce.city
CREATE TABLE IF NOT EXISTS `city`
(
    `id`   int                                                        NOT NULL AUTO_INCREMENT,
    `name` char(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
    `lat`  float                                                               DEFAULT NULL,
    `lng`  float                                                               DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

-- Дамп структуры для таблица taskforce.response
CREATE TABLE IF NOT EXISTS `response`
(
    `id`          int NOT NULL AUTO_INCREMENT,
    `task_id`     int NOT NULL,
    `executor_id` int NOT NULL,
    `comment`     mediumtext COLLATE utf8mb4_general_ci,
    `price`       int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `task_response` (`task_id`),
    KEY `task_executor` (`executor_id`),
    CONSTRAINT `task_executor` FOREIGN KEY (`executor_id`) REFERENCES `user` (`id`),
    CONSTRAINT `task_response` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;


-- Дамп структуры для таблица taskforce.review
CREATE TABLE IF NOT EXISTS `review`
(
    `id`          int NOT NULL AUTO_INCREMENT,
    `executor_id` int NOT NULL,
    `task_id`     int NOT NULL,
    `mark`        int DEFAULT NULL,
    `comment`     mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
    PRIMARY KEY (`id`),
    KEY `review_executor` (`executor_id`),
    KEY `review_task` (`task_id`),
    CONSTRAINT `review_executor` FOREIGN KEY (`executor_id`) REFERENCES `user` (`id`),
    CONSTRAINT `review_task` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;


-- Дамп структуры для таблица taskforce.task
CREATE TABLE IF NOT EXISTS `task`
(
    `id`               int                                                         NOT NULL AUTO_INCREMENT,
    `created_at`       datetime                                                    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `name`             char(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci  NOT NULL,
    `description`      mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `category_id`      int                                                         NOT NULL DEFAULT '0',
    `budget`           int                                                         NOT NULL DEFAULT '0',
    `finished_at`      datetime                                                             DEFAULT CURRENT_TIMESTAMP,
    `status`           char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci   NOT NULL,
    `lat`              float                                                                DEFAULT '0',
    `lng`              float                                                                DEFAULT '0',
    `city_id`          int                                                                  DEFAULT NULL,
    `customer_user_id` int                                                         NOT NULL,
    `executor_user_id` int                                                                  DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `task_category` (`category_id`),
    KEY `city` (`city_id`),
    KEY `executor` (`executor_user_id`),
    KEY `customer` (`customer_user_id`),
    CONSTRAINT `city` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
    CONSTRAINT `customer` FOREIGN KEY (`customer_user_id`) REFERENCES `user` (`id`),
    CONSTRAINT `executor` FOREIGN KEY (`executor_user_id`) REFERENCES `user` (`id`),
    CONSTRAINT `task_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;


-- Дамп структуры для таблица taskforce.task_file
CREATE TABLE IF NOT EXISTS `task_file`
(
    `id`       int                                                       NOT NULL AUTO_INCREMENT,
    `task_id`  int                                                       NOT NULL,
    `file_url` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    KEY `task` (`task_id`),
    CONSTRAINT `task` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;


-- Дамп структуры для таблица taskforce.user
CREATE TABLE IF NOT EXISTS `user`
(
    `id`            int                                                        NOT NULL AUTO_INCREMENT,
    `registered_at` datetime                                                   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `status`        int                                                        NOT NULL,
    `role`          char(50) COLLATE utf8mb4_general_ci                        NOT NULL,
    `email`         char(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
    `password`      char(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `name`          char(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
    `telephone`     int                                                                 DEFAULT '0',
    `telegram`      char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci           DEFAULT NULL,
    `birthday`      date                                                                DEFAULT NULL,
    `about`         mediumtext COLLATE utf8mb4_general_ci,
    `city_id`       int                                                                 DEFAULT NULL,
    `avatar`        char(50) COLLATE utf8mb4_general_ci                                 DEFAULT NULL,
    `show_contact`  tinyint                                                             DEFAULT '1',
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`),
    KEY `user_city` (`city_id`),
    CONSTRAINT `user_city` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;


-- Дамп структуры для таблица taskforce.user_category
CREATE TABLE IF NOT EXISTS `user_category`
(
    `id`          int NOT NULL AUTO_INCREMENT,
    `user_id`     int NOT NULL,
    `category_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user` (`user_id`),
    KEY `category` (`category_id`),
    CONSTRAINT `category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
    CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;



/*!40103 SET TIME_ZONE = IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE = IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS = IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES = IFNULL(@OLD_SQL_NOTES, 1) */;
