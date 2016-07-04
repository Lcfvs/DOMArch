CREATE TABLE `Translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `archivedAt` datetime DEFAULT NULL,
  `format` text NOT NULL,
  `isTranslated` tinyint(1) DEFAULT '0',
  `en` text NOT NULL,
  `fr` text NOT NULL,
  `nl` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;