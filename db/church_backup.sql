-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql301.byetcluster.com
-- Generation Time: Jan 04, 2018 at 01:00 AM
-- Server version: 5.6.35-81.0
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `b10_21123313_church`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `doubletable`
--

CREATE TABLE IF NOT EXISTS `doubletable` (
  `quiz_id` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `dd_flag` int(10) NOT NULL,
  `dd_wager` int(10) NOT NULL,
  `dj_flag` int(10) NOT NULL,
  `dj_wager` int(10) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doubletable`
--

INSERT INTO `doubletable` (`quiz_id`, `userid`, `dd_flag`, `dd_wager`, `dj_flag`, `dj_wager`) VALUES
(8, 99, 0, 0, 2, 1000),
(6, 98, 0, 0, 0, 0),
(6, 97, 0, 0, 0, 0),
(6, 96, 0, 0, 0, 0),
(6, 95, 0, 0, 0, 0),
(8, 94, 0, 0, 0, 0),
(8, 93, 0, 0, 0, 0),
(8, 92, 0, 0, 0, 0),
(8, 91, 0, 0, 0, 0),
(8, 90, 0, 0, 0, 0),
(8, 89, 0, 0, 0, 0),
(8, 88, 0, 0, 0, 0),
(8, 87, 0, 0, 0, 0),
(6, 73, 0, 0, 0, 0),
(6, 72, 0, 0, 0, 0),
(8, 100, 0, 0, 0, 0),
(8, 101, 0, 0, 0, 0),
(8, 102, 0, 0, 0, 0),
(8, 103, 0, 0, 0, 0),
(8, 104, 0, 0, 0, 0),
(8, 105, 0, 0, 0, 0),
(8, 106, 0, 0, 0, 0),
(8, 107, 0, 0, 0, 0),
(8, 108, 0, 0, 0, 0),
(8, 109, 0, 0, 0, 0),
(8, 110, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `email_verify`
--

CREATE TABLE IF NOT EXISTS `email_verify` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `user_id` int(50) NOT NULL,
  `token` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `email_verify`
--

INSERT INTO `email_verify` (`id`, `user_id`, `token`) VALUES
(1, 1, '59422893b038a'),
(2, 2, '59422966efbc5'),
(3, 3, '5942299021052'),
(4, 4, '5944c39540c39');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `question_id` int(50) NOT NULL,
  `option_text` varchar(500) NOT NULL,
  `correct` int(1) NOT NULL,
  `option_text_ml` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=333 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_id`, `option_text`, `correct`, `option_text_ml`) VALUES
(132, 33, 'Engineering', 1, ''),
(133, 0, 'Leah', 0, 'sebm'),
(134, 0, 'Tamar', 0, 'XmamÀ'),
(135, 0, 'Rachel', 0, 'dmtlÂ'),
(136, 0, 'Zipporah', 1, 'knt¸md'),
(137, 0, 'Jesus', 0, 'tbip'),
(138, 0, 'Peter', 0, ']t{Xmkv'),
(139, 0, 'Zechariah', 0, 'kJdnb'),
(140, 0, 'John', 1, 'tbml¶m³'),
(168, 0, 'Zipporah', 1, 'knt¸md'),
(165, 0, 'Leah', 0, 'sebm'),
(166, 0, 'Tamar', 0, 'XmamÀ'),
(167, 0, 'Rachel', 0, 'dmtlÂ'),
(164, 0, 'Zipporah', 1, 'knt¸md'),
(153, 0, 'Leah', 0, 'sebm'),
(154, 0, 'Tamar', 0, 'XmamÀ'),
(155, 0, 'Rachel', 0, 'dmtlÂ'),
(156, 0, 'Zipporah', 1, 'knt¸md'),
(157, 0, 'Jesus', 0, 'tbip'),
(158, 0, 'Peter', 0, ']t{Xmkv'),
(159, 0, 'Zechariah', 0, 'kJdnb'),
(160, 0, 'John', 1, 'tbml¶m³'),
(161, 0, 'Leah', 0, 'sebm'),
(162, 0, 'Tamar', 0, 'XmamÀ'),
(163, 0, 'Rachel', 0, 'dmtlÂ'),
(131, 33, 'Maths', 0, ''),
(130, 33, 'Science', 0, ''),
(129, 33, 'English', 0, ''),
(128, 32, 'Blah', 0, ''),
(127, 32, 'Mathew', 0, ''),
(126, 32, 'Aasim', 0, ''),
(125, 32, 'Sheryl', 1, ''),
(189, 0, 'Leah', 0, 'sebm'),
(190, 0, 'Tamar', 0, 'XmamÀ'),
(191, 0, 'Rachel', 0, 'dmtlÂ'),
(192, 0, 'Zipporah', 1, 'knt¸md'),
(332, 71, '4', 1, ''),
(331, 71, '3', 0, ''),
(330, 71, '2', 0, ''),
(329, 71, '1', 0, ''),
(328, 70, '52', 0, ''),
(327, 70, '5', 0, ''),
(326, 70, '8', 1, ''),
(325, 70, '7', 0, ''),
(324, 69, '0', 0, ''),
(323, 69, '1', 0, ''),
(320, 68, '12', 0, ''),
(321, 69, '4', 1, ''),
(322, 69, '2', 0, ''),
(317, 68, '9', 1, ''),
(318, 68, '11', 0, ''),
(319, 68, '7', 0, ''),
(316, 67, 'he looked toward heaven and prayed', 0, 'kzÃ€KÂ¯nteÃ§ IÂ®pIÃ„ DbÃ€Â¯n {]mÃ€Â°nÂ¨p'),
(315, 67, 'threw a piece of wood into water ', 1, 'XSnÂ¡jWw shÃ…Â¯nenÂ«p'),
(314, 67, 'raised the staff ', 0, 'hSn DbÃ€Â¯n '),
(313, 67, 'raised his hands and prayed ', 0, 'IcÂ§Ã„ DbÃ€Â¯n {]mÃ€Â°nÂ¨p'),
(312, 66, 'Irenaeus', 0, 'CctWhqkv'),
(311, 66, 'Augustine', 0, 'AKÃŒnÂ³'),
(310, 66, 'Origen', 1, 'HcnPÂ³'),
(309, 66, 'Chrysostom', 0, '{IntkmÃŒw'),
(308, 65, '"Sing to the Lord, for he has triumphed gloriously; horse and rider he has thrown into the sea', 1, 'â€œ IÃ€Â¯mhns ]mSn kvXpXnÃ§hnÂ³; FsÂ´Â¶mÃ‚ AhnSÃ¬ alXz]qÃ€Ã†amb hnPbw tSnbncnÃ§Ã¬. Ã¦Xncsbbpw Ã¦XncÂ¡mcspw AhnSÃ¬ IsensednÂªp'),
(307, 65, '"Lord, your right hand has become glorious in might; Your right hand has scattered the enemies', 0, ' IÃ€Â¯mth, AÂ§bpsS heÂ¯pssI iÃ nbmÃ‚ alXzamÃ€Â¶ncnÃ§Ã¬; IÃ€Â¯mth, AÂ§bpsS heÂ¯pssI i{Xphns NnXdnÂ¨ncnÃ§Ã¬'),
(306, 65, '"In majestic triumph you overthrow your enemies. Your anger blazes out and burns them up like straw', 0, ' AÂ´alnabmÃ‚ AÂ§v FXncmfnIsf XIÃ€Ã§Ã¬; tIm]mÃ¡n AbÂ¨v hbvtÂ¡mens	Â¸mse Ahsc ZlnÂ¸nÃ§Ã¬'),
(241, 0, 'Because it is about God ', 0, 'ssZhs¯çdn¨pffhbmIbmÂ'),
(242, 0, 'Because it came by men and women moved by the Holy Spirit spoke from God', 1, ']cnip²mßmhnmÂ {]tNmZnXcmbhÀ kwkmcn¨hbmIbmÂ'),
(243, 0, 'Because Christ has given the power to the Church', 0, 'k`ímWv tbip A[nImcw ÂInbncnç¶sX¶XpsImïv'),
(244, 0, 'Because there are not people who learn the scriptures ', 0, 'hn.enJnX§Ä ]Tnç¶hÀ CÃm¯XpsImïv'),
(305, 65, '"The Lord is a warrior, the Lord is his name', 0, 'â€œIÃ€Â¯mhv tbmÂ²mhmÃ¦Ã¬; IÃ€Â¯mhv FÂ¶mÃ¦Ã¬ AhnSsÂ¯ maw'),
(302, 64, 'of the poor', 0, 'Zcn{ZcpsS'),
(303, 64, 'of the resident aliens', 0, ']ctZinIfpsS'),
(304, 64, 'of the slaves', 0, 'ASnaIfpsS'),
(298, 63, 'Peter', 0, ']t{Xmkv'),
(299, 63, ']t{Xmkv', 0, 'kJdnb'),
(300, 63, 'John', 1, 'tbmlÂ¶mÂ³'),
(301, 64, 'of widows and orphans', 1, 'hn[hIfpsSbpw AmYcpsSbpw'),
(291, 61, '', 1, ''),
(292, 61, '', 0, ''),
(293, 62, '', 0, ''),
(294, 62, '', 0, ''),
(295, 62, '', 1, ''),
(296, 62, '', 0, ''),
(297, 63, 'Jesus', 0, 'tbip'),
(290, 61, '', 0, ''),
(288, 60, 'Blessed are you among women, and blessed is the fruit of your womb ', 0, 'o kv{XoIfnÃ‚ AÃ«{KloXbmWv. \nsÂ³d DZc^eh AÃ«{KloXw'),
(289, 61, '', 0, ''),
(286, 60, 'The Lord will give him the throne of his ancestor Abraham.', 0, 'AhsÂ³d ]nXmhmb A{_mlÂ¯nsÂ³d knwlmkw ssZhamb IÃ€Â¯mhv Ahv sImSpÃ§w'),
(287, 60, 'You have found favour with God ', 1, 'ssZhkÂ¶n[nbnÃ‚ o Ir] IsÃ¯Â¯nbncnÃ§Ã¬'),
(284, 0, 'John', 1, 'tbmlÂ¶mÂ³'),
(285, 60, 'He will be great before the Lord.', 0, 'IÃ€Â¯mhnsÂ³d kÂ¶n[nbnÃ‚ AhÂ³ henbhmbncnÃ§w'),
(283, 0, 'Zechariah', 0, 'kJdnb'),
(281, 0, 'Jesus', 0, 'tbip'),
(282, 0, 'Peter', 0, ']t{Xmkv'),
(279, 59, 'Rachel', 0, 'dmtlÃ‚'),
(280, 59, 'Zipporah', 1, 'kntÂ¸md'),
(277, 59, 'Leah', 0, 'sebm'),
(278, 59, 'Tamar', 0, 'XmamÃ€'),
(276, 0, 'John', 1, 'tbmlÂ¶mÂ³'),
(274, 0, 'Peter', 0, ']t{Xmkv'),
(275, 0, 'Zechariah', 0, 'kJdnb'),
(273, 0, 'Jesus', 0, 'tbip'),
(261, 0, 'Jesus', 0, 'tbip'),
(262, 0, 'Peter', 0, ']t{Xmkv'),
(263, 0, 'Zechariah', 0, 'kJdnb'),
(264, 0, 'John', 1, 'tbml¶m³'),
(272, 0, 'Zipporah', 1, 'kntÂ¸md'),
(270, 0, 'Tamar', 0, 'XmamÃ€'),
(271, 0, 'Rachel', 0, 'dmtlÃ‚'),
(269, 0, 'Leah', 0, 'sebm');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `english` varchar(500) NOT NULL,
  `malyalam` varchar(500) CHARACTER SET utf8 NOT NULL,
  `points` int(50) NOT NULL,
  `custom_points` int(10) NOT NULL,
  `category` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `english`, `malyalam`, `points`, `custom_points`, `category`) VALUES
(33, 6, 'What are you studying', '', 100, 500, 2),
(32, 6, 'What is your name', '', 100, 200, 1),
(68, 8, '4+5', '', 300, 300, 2),
(69, 8, '2*2', '', 400, 400, 2),
(70, 8, '4+4', '', 500, 500, 2),
(71, 8, '2*2', '', 200, 200, 3),
(67, 8, 'What did Moses do to make the water fresh? ', 'amdmbnse Ibv]pÃ… shÃ…w a[pcnÃ§Â¶XnÃ« aptÂ¶mSnbmbn tami FÂ´mWv {]hÃ€Â¯nÂ¨Xv?', 200, 200, 2),
(66, 8, 'The Father of the Church who held that Second Letter of Peter was not written by St. Peter the Apostle. ', 'hnipÂ² ]t{XmknsÃ¢ cÃ¯mw teJw injy{]apJmb ]t{XmkntÃ¢XÃƒ FÂ¶v A`n{]mbsÂ¸Â« k`m]nXmhv ?', 500, 500, 1),
(65, 8, 'Miriam sang to them: complete the sentence: ', 'ancnbmw AhÃ€Â¡v ]mSnsÂ¡mSpÂ¯Xv C{]ImcambnÃªÃ¬:', 400, 400, 1),
(64, 8, 'If you do abuse them, when they cry out to me, I will surely heed their cry". Whose cry? ', '"\nÂ§Ã„ Ahsc D]{ZhnÂ¡pItbm AhÃ€ FsÂ¶ hnfnÂ¡pItbm sNbvXmÃ‚ \nÃbambpw RmÂ³ AhcpsS \nehnfn tIÃ„Â¡pw". BcpsS?', 300, 300, 1),
(60, 8, 'Which of the following did angel Gabriel speak to Mary? ', 'K{_ntbÃ‚ ZqXÂ³ adnbtÂ¯mSp ]dÂª hN\\taXv?', 100, 100, 2),
(61, 8, '', '', 100, 100, 3),
(62, 8, '', '', 100, 100, 4),
(63, 8, 'He must never drink wine or strong drink. About whom is it recorded in Luke''s Gospel?', 'hotÂªm aÃ¤p elcn]m\\obÂ§tfm AhÂ³ IpSnÃ§IbnÃƒ. C{]Imcw eqÂ¡m kphntijÂ¯nÃ‚ tcJsÂ¸SpÂ¯nbncnÃ§Â¶Xv BscÃ§dnÂ¨v.?', 200, 200, 1),
(59, 8, 'What is the name of Moses'' wife??', 'tamibpsS `mcybpsS t]cv??', 100, 100, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE IF NOT EXISTS `quiz` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `title` varchar(100) NOT NULL,
  `ongoing_flag` int(11) NOT NULL DEFAULT '0',
  `curr_chance` int(10) NOT NULL,
  `c1` varchar(100) NOT NULL,
  `c2` varchar(100) NOT NULL,
  `c3` varchar(100) NOT NULL,
  `c4` varchar(100) NOT NULL,
  `c5` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `start_time`, `end_time`, `title`, `ongoing_flag`, `curr_chance`, `c1`, `c2`, `c3`, `c4`, `c5`) VALUES
(6, '0000-00-00', '0000-00-00', 'Church', 1, 95, 'Category 1', 'Category 2', 'Category 3', 'Category 4', 'Category 5'),
(8, '0000-00-00', '0000-00-00', 'Vichara', 1, 108, 'Category 1', 'Category 2', 'Category 3', 'Category 4', 'Category 5');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_answers`
--

CREATE TABLE IF NOT EXISTS `quiz_answers` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `user_id` int(50) NOT NULL,
  `questions_id` int(50) NOT NULL,
  `quiz_id` int(50) NOT NULL,
  `points` decimal(50,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=385 ;

--
-- Dumping data for table `quiz_answers`
--

INSERT INTO `quiz_answers` (`id`, `user_id`, `questions_id`, `quiz_id`, `points`) VALUES
(336, 97, 32, 6, '100'),
(335, 97, 32, 6, '100'),
(334, 96, 32, 6, '100'),
(333, 98, 32, 6, '0'),
(332, 95, 32, 6, '100'),
(331, 97, 33, 6, '500'),
(167, 0, 0, 0, '100'),
(166, 0, 0, 0, '10'),
(165, 0, 0, 0, '10'),
(337, 98, 32, 6, '0'),
(338, 95, 32, 6, '100'),
(339, 96, 32, 6, '100'),
(384, 107, 69, 8, '400'),
(383, 110, 62, 8, '0'),
(382, 108, 61, 8, '50'),
(381, 109, 61, 8, '0'),
(380, 109, 61, 8, '0'),
(379, 108, 61, 8, '50'),
(378, 108, 60, 8, '100'),
(377, 107, 59, 8, '100');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_participants`
--

CREATE TABLE IF NOT EXISTS `quiz_participants` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(10) NOT NULL,
  `team_name` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

--
-- Dumping data for table `quiz_participants`
--

INSERT INTO `quiz_participants` (`id`, `quiz_id`, `team_name`) VALUES
(97, 6, 'dad'),
(96, 6, 'admin2'),
(95, 6, 'admin'),
(110, 8, 'blah 4'),
(109, 8, 'blah 3'),
(108, 8, 'blah 2'),
(107, 8, 'blah'),
(98, 6, 'awdawd');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

CREATE TABLE IF NOT EXISTS `reset_password` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `user_id` int(50) NOT NULL,
  `token` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(80) NOT NULL,
  `contact` int(10) NOT NULL,
  `type` int(1) NOT NULL,
  `verified` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `contact`, `type`, `verified`) VALUES
(1, 'aasimkhan30', '$2y$12$9tzHUHwCLTg4SpZxHUXSz.KGgTmdSLEvgGA1d3KoohiC800W4tB.a', 'aasimkhan30@gmail.com', 0, 0, 1),
(2, 'aasimkhan301', '$2y$12$GTYiuj1mCOSeXBz61hIov.zrIGzaFY1iMrSDAzdflA57m313czNgy', 'aasim.khan30@gmail.com', 0, 0, 1),
(3, 'aasimkhan302', '$2y$12$a.dTT9h1kF90uGQUSsmuwelW5gUXOSgDvzagjikcZnHyFEx7zuLM6', 'aa.simkhan30@gmail.com', 0, 0, 1),
(4, 'aasimkhan303', '$2y$12$1ytXelSCays99ljrmLE4Ze2EQtTZANIL0k0DQ.ZngL6OvsSw9jYmG', 'aasimkhan3045@gmail.com', 0, 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
