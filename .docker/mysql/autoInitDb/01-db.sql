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
(1,	'Jana',	'Novák',	'read',	'jan@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 16:48:40',	NULL),
(2,	'Petr',	'Svobodas',	'write',	'petr@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'write',	NULL,	'2025-02-16 16:48:40',	NULL),
(3,	'Admin',	'Admin',	'delete',	'admin@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'delete',	NULL,	'2025-02-16 16:48:40',	NULL),
(4,	'Matyáš',	'Nič',	'admin',	'mat.nic@seznam.cz',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'delete',	NULL,	'2025-02-16 17:18:49',	NULL),
(5,	'test',	'test',	'test',	'test@test.cz',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'delete',	'2025-02-18 09:51:44',	'2025-02-18 09:34:09',	NULL),
(6,	'Lukáš',	'Horák',	'user_001',	'lukas001@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 16:48:40',	NULL),
(7,	'Jana',	'Veselá',	'user_002',	'jana002@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'write',	NULL,	'2025-02-16 16:48:40',	NULL),
(8,	'Marek',	'Novotný',	'user_003',	'marek003@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 16:48:40',	NULL),
(9,	'Eva',	'Pavlíčková',	'user_004',	'eva004@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'write',	NULL,	'2025-02-16 16:48:40',	NULL),
(10,	'Tomáš',	'Král',	'user_005',	'tomas005@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 16:48:40',	NULL),
(11,	'Lucie',	'Procházková',	'user_006',	'lucie006@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'delete',	NULL,	'2025-02-16 16:48:40',	NULL),
(12,	'Petr',	'Janků',	'user_007',	'petr007@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'write',	NULL,	'2025-02-16 16:48:40',	NULL),
(13,	'Kristýna',	'Kovářová',	'user_008',	'kristyna008@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 16:48:40',	NULL),
(14,	'Jiří',	'Pokorný',	'user_009',	'jiri009@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'delete',	NULL,	'2025-02-16 16:48:40',	NULL),
(15,	'Alena',	'Černá',	'user_010',	'alena010@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 16:48:40',	NULL),
(16,	'Radek',	'Šimek',	'user_011',	'radek011@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'write',	NULL,	'2025-02-16 16:48:40',	NULL),
(17,	'Monika',	'Dvořáková',	'user_012',	'monika012@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'delete',	NULL,	'2025-02-16 16:48:40',	NULL),
(18,	'Petr',	'Růžička',	'user_013',	'petr013@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 16:48:40',	NULL),
(19,	'Jana',	'Jílová',	'user_014',	'jana014@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'write',	NULL,	'2025-02-16 16:48:40',	NULL),
(20,	'Martin',	'Nový',	'user_015',	'martin015@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 16:48:40',	NULL),
(21,	'Jan',	'Hruška',	'user_016',	'jan016@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'delete',	NULL,	'2025-02-16 16:48:40',	NULL),
(22,	'Tereza',	'Beránková',	'user_017',	'tereza017@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'write',	NULL,	'2025-02-16 16:48:40',	NULL),
(23,	'Veronika',	'Benešová',	'user_018',	'veronika018@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 16:48:40',	NULL),
(24,	'Jiří',	'Vávra',	'user_019',	'jiri019@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'write',	NULL,	'2025-02-16 16:48:40',	NULL),
(25,	'Alžběta',	'Křížová',	'user_020',	'alzbeta020@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 16:48:40',	NULL),
(26,	'Lucie',	'Mikulová',	'user_021',	'lucie021@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'delete',	NULL,	'2025-02-16 16:48:40',	NULL),
(27,	'Tomáš',	'Marek',	'user_022',	'tomas022@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'write',	NULL,	'2025-02-16 16:48:40',	NULL),
(28,	'Pavla',	'Zelenková',	'user_023',	'pavla023@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 16:48:40',	NULL),
(29,	'Jakub',	'Soukup',	'user_024',	'jakub024@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'delete',	NULL,	'2025-02-16 16:48:40',	NULL),
(30,	'Simona',	'Bílková',	'user_025',	'simona025@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'write',	NULL,	'2025-02-16 16:48:40',	NULL),
(31,	'Roman',	'Škoda',	'user_026',	'roman026@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'read',	NULL,	'2025-02-16 16:48:40',	NULL),
(32,	'Michaela',	'Jelínková',	'user_027',	'michaela027@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'delete',	NULL,	'2025-02-16 16:48:40',	NULL),
(33,	'František',	'Cvrček',	'user_028',	'frantisek028@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'write',	NULL,	'2025-02-16 16:48:40',	NULL),
(34,	'Veronika',	'Ládyová',	'user_029',	'veronika029@example.com',	'$2y$10$CnlGMe0zRgF0dbqoVp0C/Os2dt4rc0QO41w6z.7T03K69t1h/RbMG',	'write',	NULL,	'2025-02-16 16:48:40',	NULL);

-- 2025-02-18 10:56:34