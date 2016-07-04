CREATE TABLE `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `archivedAt` datetime DEFAULT NULL,
  `account` varchar(20) NOT NULL UNIQUE,
  `type` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `token` text,
  `locale` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;