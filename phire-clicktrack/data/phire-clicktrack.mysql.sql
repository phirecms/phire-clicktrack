--
-- ClickTrack Module MySQL Database for Phire CMS 2.0
--

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------

--
-- Table structure for table `clicks`
--

CREATE TABLE IF NOT EXISTS `[{prefix}]clicks` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `clicks` int(16),
  `ips` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21001;

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 1;
