CREATE TABLE IF NOT EXISTS `likes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdMessage` int(11) NOT NULL,
  `SessionId` int(32) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `messages` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Text` text NOT NULL,
  `Date` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `SessionId` varchar(32) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Chat messages' AUTO_INCREMENT=1 ;