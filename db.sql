
-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `phid` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `original` varchar(255) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`phid`),
  KEY `published` (`published`,`deleted`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL,
  `phid` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`,`published`,`deleted`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_logins`
--

CREATE TABLE IF NOT EXISTS `users_logins` (
  `ulid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `useragent` varchar(255) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`ulid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
