CREATE TABLE IF NOT EXISTS `news_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `news_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `relation` (`news_id`, `categories_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `category` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `news_categories` (`news_id`, `categories_id`)
VALUES ('2', '2'), ('3', '2');