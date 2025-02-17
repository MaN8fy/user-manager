-- Adminer 4.8.1 MySQL 8.3.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login_time` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `login_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('read','write','delete') NOT NULL DEFAULT 'read',
  `deactivated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `role`, `deactivated`, `created`, `last_update`) VALUES
(1,	'Jan',	'Novák',	'read',	'jan@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 16:48:40',	NULL),
(2,	'Petr',	'Svoboda',	'write',	'petr@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'write',	NULL,	'2025-02-16 16:48:40',	NULL),
(3,	'Admin',	'Admin',	'delete',	'admin@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'delete',	NULL,	'2025-02-16 16:48:40',	NULL),
(4,	'Matyáš',	'Nič',	'admin',	'mat.nic@seznam.cz',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 17:18:49',	NULL);