CREATE TABLE IF NOT EXISTS `metadata` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `namespace` varchar(255) NOT NULL,
  PRIMARY KEY (`key`,`namespace`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

