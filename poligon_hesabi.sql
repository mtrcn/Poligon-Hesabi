CREATE TABLE IF NOT EXISTS `ph_projects` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `num_points` int(4) NOT NULL,
  `id` text COLLATE utf8_unicode_ci NOT NULL,
  `angle` text COLLATE utf8_unicode_ci NOT NULL,
  `azimuth` text COLLATE utf8_unicode_ci NOT NULL,
  `distance` text COLLATE utf8_unicode_ci NOT NULL,
  `x` text COLLATE utf8_unicode_ci NOT NULL,
  `y` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS `ph_users` (
  `uid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;