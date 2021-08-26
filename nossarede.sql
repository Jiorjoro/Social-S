-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 17-Ago-2021 às 00:29
-- Versão do servidor: 5.7.11
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--
-- Cria o banco de dados
--

DROP DATABASE IF EXISTS socials_bd;

CREATE DATABASE socials_bd 
CHARSET=utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Database: `socials_bd`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `logins`
--

CREATE TABLE `socials_bd`.`logins` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(2000) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `userAccess` enum('usuario','espectador') NOT NULL,
  `userName` varchar(2000) NOT NULL DEFAULT 'Cadastro Incompleto',
  `userPicture` varchar(2000) NOT NULL DEFAULT '../media/usersPictures/DefaultIcon.png',
  `caddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `altdade` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
  PRIMARY KEY (`userId`
  )) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `logins`
--

INSERT INTO `socials_bd`.`logins` (`userId`, `email`, `senha`, `userAccess`, `userName`, `userPicture`, `caddate`, `altdade`) VALUES
(1, 'jorge_minatti-silva@estudante.sc.senai.br', '18dcc27c566b9060b7303b745e4be78f', 'usuario', 'Jorge Minatti da Silva', '../media/usersPictures/defaultIcon.png', '2021-08-16 17:33:37', '2021-08-16 17:33:37'),
(2, 'cristiane.f.mazocoli@edu.sesisc.org.br', '40404d5ab9d056faf84860a220600944', 'usuario', 'Cristiane de Fatima Tomasoni Mazocoli', '../media/usersPictures/20210816_143713.png', '2021-08-16 17:37:13', '2021-08-16 17:37:13');

-- --------------------------------------------------------

--
-- Estrutura da tabela `postcomments`
--

CREATE TABLE `socials_bd`.`postcomments` (
  `commentId` int(11) NOT NULL AUTO_INCREMENT,
  `commentPostId` int(11) NOT NULL,
  `commentUserId` int(11) NOT NULL,
  `commentTxt` varchar(2000) NOT NULL,
  `commentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `postlikes`
--

CREATE TABLE `socials_bd`.`postlikes` (
  `likeId` int(11) NOT NULL AUTO_INCREMENT,
  `likePostId` int(11) NOT NULL,
  `likeUserId` int(11) NOT NULL,
  `likeDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `postlikes`
--

INSERT INTO `socials_bd`.`postlikes` (`likeId`, `likePostId`, `likeUserId`, `likeDate`) VALUES
(2, 2, 2, '2021-08-16 17:41:54'),
(3, 5, 2, '2021-08-16 17:42:02'),
(4, 9, 2, '2021-08-16 17:42:13'),
(5, 9, 1, '2021-08-16 19:35:22'),
(6, 2, 1, '2021-08-16 19:35:27'),
(7, 5, 1, '2021-08-16 19:37:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `postReports`
--

CREATE TABLE `socials_bd`.`postReports` (
 `reportId` INT NOT NULL AUTO_INCREMENT ,
 `reportPostId` INT NOT NULL ,
 `reportUserId` INT NOT NULL ,
 `reportDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 PRIMARY KEY (`reportId`)
) ENGINE = InnoDB;

-- --------------------------------------------------------

--
-- Estrutura da tabela `posts`
--

CREATE TABLE `socials_bd`.`posts` (
  `postId` int(11) NOT NULL AUTO_INCREMENT,
  `postUserId` int(11) NOT NULL,
  `postTxt` varchar(2000) DEFAULT NULL,
  `postImg` varchar(2000) DEFAULT NULL,
  `postVideo` varchar(2000) DEFAULT NULL,
  `postTags` varchar(2000) DEFAULT NULL,
  `postDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `posts`
--

INSERT INTO `socials_bd`.`posts` (`postId`, `postUserId`, `postTxt`, `postImg`, `postVideo`, `postTags`, `postDate`) VALUES
(2, 2, '', '../media/uploads/20210816_144002_2.jpeg', '', '#fabricação-digital', '2021-08-16 17:40:02'),
(3, 2, '', '../media/uploads/20210816_144016_2.jpeg', '', '#fabricação-digital', '2021-08-16 17:40:16'),
(4, 2, '', '../media/uploads/20210816_144025_2.jpeg', '', '#fabricação-digital', '2021-08-16 17:40:25'),
(5, 2, '', '../media/uploads/20210816_144036_2.jpeg', '', '#fabricação-digital', '2021-08-16 17:40:36'),
(6, 2, '', '../media/uploads/20210816_144042_2.jpeg', '', '#fabricação-digital', '2021-08-16 17:40:42'),
(7, 2, '', '../media/uploads/20210816_144053_2.jpeg', '', '#fabricação-digital', '2021-08-16 17:40:53'),
(8, 2, '', '', '../media/uploads/20210816_144103_2.mp4', '#fabricação-digital', '2021-08-16 17:41:03'),
(9, 2, '', '', '../media/uploads/20210816_144110_2.mp4', '#fabricação-digital', '2021-08-16 17:41:10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `posttags`
--

CREATE TABLE `socials_bd`.`posttags` (
  `Tag` varchar(2000) DEFAULT NULL,
  `tagDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `posttags`
--

INSERT INTO `socials_bd`.`posttags` (`Tag`, `tagDate`) VALUES
('Bem', '2021-08-16 17:30:41'),
('Bem', '2021-08-16 17:30:41'),
('Bem', '2021-08-16 17:30:41'),
('Bem', '2021-08-16 17:30:41'),
('Vindos', '2021-08-16 17:30:41'),
('Vindos', '2021-08-16 17:30:41'),
('Vindos', '2021-08-16 17:30:41'),
('à', '2021-08-16 17:30:41'),
('à', '2021-08-16 17:30:41'),
('Nossa Rede', '2021-08-16 17:30:41'),
('#fabricação-digital', '2021-08-16 17:40:02'),
('#fabricação-digital', '2021-08-16 17:40:16'),
('#fabricação-digital', '2021-08-16 17:40:25'),
('#fabricação-digital', '2021-08-16 17:40:36'),
('#fabricação-digital', '2021-08-16 17:40:42'),
('#fabricação-digital', '2021-08-16 17:40:53'),
('#fabricação-digital', '2021-08-16 17:41:03'),
('#fabricação-digital', '2021-08-16 17:41:10');

-- --------------------------------------------------------

--
-- Stand-in structure for view `rank_rec_tags`
--
CREATE TABLE `socials_bd`.`rank_rec_tags` (
`Total` bigint(21)
,`Tag` varchar(2000)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `rank_tags`
--
CREATE TABLE `socials_bd`.`rank_tags` (
`Total` bigint(21)
,`Tag` varchar(2000)
);

-- --------------------------------------------------------

--
-- Structure for view `rank_rec_tags`
--
DROP TABLE IF EXISTS `socials_bd`.`rank_rec_tags`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `socials_bd`.`rank_rec_tags`  AS  select count(0) AS `Total`,`posttags`.`Tag` AS `Tag` from `socials_bd`.`posttags` where ((`posttags`.`Tag` is not null) and (`posttags`.`Tag` <> '') and (`posttags`.`Tag` <> ' ') and (`posttags`.`Tag` <> '\r\n') and (`posttags`.`tagDate` >= (cast(now() as date) - interval 6 week))) group by `posttags`.`Tag` order by `Total` desc ;

-- --------------------------------------------------------

--
-- Structure for view `rank_tags`
--
DROP TABLE IF EXISTS `socials_bd`.`rank_tags`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `socials_bd`.`rank_tags`  AS  select count(0) AS `Total`,`posttags`.`Tag` AS `Tag` from `socials_bd`.`posttags` where ((`posttags`.`Tag` is not null) and (`posttags`.`Tag` <> '') and (`posttags`.`Tag` <> ' ') and (`posttags`.`Tag` <> '\r\n ')) group by `posttags`.`Tag` order by `Total` desc ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logins`
--
ALTER TABLE `socials_bd`.`logins`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `postcomments`
--
ALTER TABLE `socials_bd`.`postcomments`
  ADD PRIMARY KEY (`commentId`);

--
-- Indexes for table `postlikes`
--
ALTER TABLE `socials_bd`.`postlikes`
  ADD PRIMARY KEY (`likeId`);

--
-- Indexes for table `posts`
--
ALTER TABLE `socials_bd`.`posts`
  ADD PRIMARY KEY (`postId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `socials_bd`.`logins`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `postcomments`
--
ALTER TABLE `socials_bd`.`postcomments`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `postlikes`
--
ALTER TABLE `socials_bd`.`postlikes`
  MODIFY `likeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `socials_bd`.`posts`
  MODIFY `postId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
