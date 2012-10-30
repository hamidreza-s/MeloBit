DROP TABLE IF EXISTS `bugs`;
CREATE TABLE `bugs` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`author` varchar(250) DEFAULT NULL,
`email` varchar(250) DEFAULT NULL,
`date` int(11) DEFAULT NULL,
`url` varchar(250) DEFAULT NULL,
`description` text,
`priority` varchar(50) DEFAULT NULL,
`status` varchar(50) DEFAULT NULL,
PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `nodes`;
CREATE TABLE `nodes` (
`id` int(11) NOT NULL auto_increment,
`page_id` int(11) default NULL,
`node` varchar(50) default NULL,
`content` text,
PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
`id` int(11) NOT NULL auto_increment,
`parent_id` int(11) default NULL,
`namespace` varchar(50) default NULL,
`name` varchar(100) default NULL,
`date_created` int(11) default NULL,
PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
`id` int(11) NOT NULL auto_increment,
`name` varchar(50) default NULL,
`page_id` int(11) default NULL,
`link` varchar(250) default NULL,
`position` int(11) default NULL,
`access_level` varchar(50) default NULL,
PRIMARY KEY (`id`)
) AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE `menu_items` (
`id` int(11) NOT NULL auto_increment,
`menu_id` int(11) default NULL,
`label` varchar(250) default NULL,
`page_id` int(11) default NULL,
`link` varchar(250) default NULL,
`position` int(11) default NULL,
PRIMARY KEY (`id`)
) AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
`id` int(11) NOT NULL auto_increment,
`username` varchar(50) default NULL,
`password` varchar(250) default NULL,
`first_name` varchar(250) default NULL,
`last_name` varchar(250) default NULL,
`role` varchar(25) default NULL,
PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;


INSERT INTO `users` VALUES (0,'admin','21232f297a57a5a743894a0e4a801fc3','admin','admin','administrator');














