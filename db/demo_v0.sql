-- SQL DUMP FOR keios DEMO

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `keios`
--

-- --------------------------------------------------------

--
-- Table structure for table `pl_character`
--

CREATE TABLE IF NOT EXISTS `pl_character` (
  `id_character` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `id_race` int(2) unsigned DEFAULT NULL,
  `LVL` int(5) unsigned DEFAULT NULL,
  `BASE_STR` int(5) unsigned DEFAULT NULL,
  `BASE_CON` int(5) unsigned DEFAULT NULL,
  `BASE_DEX` int(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_character`)
) ENGINE=InnoDB  DEFAULT CHARSET=UTF8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pl_character`
--

INSERT INTO `pl_character` (`id_character`, `name`, `id_race`, `LVL`, `BASE_STR`, `BASE_CON`, `BASE_DEX`) VALUES
(1, 'entomb', 1, 10, 15, 15, 15),
(2, 'vladimir', 1, 10, 15, 15, 15);

-- --------------------------------------------------------

--
-- Table structure for table `pl_character_skills`
--

CREATE TABLE IF NOT EXISTS `pl_character_skills` (
  `id_character` int(10) unsigned NOT NULL,
  `id_skill` int(10) unsigned NOT NULL,
  `rank` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_character`,`id_skill`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

--
-- Dumping data for table `pl_character_skills`
--

INSERT INTO `pl_character_skills` (`id_character`, `id_skill`, `rank`) VALUES
(1, 1, NULL),
(1, 2, NULL),
(1, 5, NULL),
(2, 1, NULL),
(2, 4, NULL),
(2, 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `id_skill` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `skill` varchar(100) DEFAULT NULL,
  `classname` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_skill`)
) ENGINE=InnoDB  DEFAULT CHARSET=UTF8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id_skill`, `skill`, `classname`) VALUES
(1, 'Novice Might', 'Might'),
(2, 'Agile Movement', 'AgileMovement'),
(3, 'Buffed', 'Buffed'),
(4, 'Healer''s Faith', 'SoftHeal'),
(5, 'Last Fortress', 'LastFortress'),
(6, 'Vampirism', 'Vampirism');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
