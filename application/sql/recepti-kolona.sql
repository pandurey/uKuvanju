-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2017 at 05:16 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ukuvanju`
--

-- --------------------------------------------------------

--
-- Table structure for table `recepti`
--

CREATE TABLE `recepti` (
  `id` int(11) NOT NULL,
  `naziv` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `sastojci` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priprema` text COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pregledi` int(7) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `recepti`
--

INSERT INTO `recepti` (`id`, `naziv`, `sastojci`, `priprema`, `img`, `pregledi`, `id_user`, `created`, `modified`) VALUES
(1, 'Ražnjići sa pilećom kobasicom i povrćem', 'Carnex pileća kobasica 400g, tikvice 1 kom, crveni luk 1 kom, paprika 1 kom, pečurke 1 pakovanje, so po ukusu, biber po ukusu, majčina dušica 1 veza, bosiljak 1 veza, limun 1 kom, Maslinovo ulje 2 kašike', 'Carnex Pileću kobasicu iseći na kolutove, a ostalo povrće na jednake komade.\r\nTako isečene namirnice marinirati oko sat vremena u maslinovom ulju, soku od limuna, soli, biberu i majčinoj dušici.\r\nNa ražnjiće naizmenično slagati marinirano povrće i Carnex Pileću kobasicu, potom složiti na tepsiju prekrivenu pekarskim papirom. Rernu zagrejati na 200 stepeni, ubaciti ražnjice i na pola pečenja okrenuti da bi se jednako ispekli sa svih strana.', 'assets/img/food/raznjici-sa-pilecom-kobasicom-i-povrcem.jpg', 200, 2, '2017-08-25 16:56:31', '2017-08-25 16:56:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recepti`
--
ALTER TABLE `recepti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recepti`
--
ALTER TABLE `recepti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
