CREATE TABLE IF NOT EXISTS `postal_code_tehran` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`phone_no` varchar(10) NOT NULL, 
`postal_code` varchar(10) NOT NULL, 
PRIMARY KEY (`id`),
INDEX name (`phone_no`, `postal_code`)
) ENGINE=MyISAM  DEFAULT CHARSET = ascii COLLATE = ascii_general_ci; 

load data local infile '/home/hamidrezas/Desktop/SMS_Postal/tehran.csv' into table `postal_code_tehran` 
fields 
terminated by ','
lines terminated by '\n'
(`phone_no`, `postal_code`);

CREATE TABLE IF NOT EXISTS `postal_code_iran` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`phone_no` varchar(10) NOT NULL, 
`postal_code` varchar(10) NOT NULL, 
PRIMARY KEY (`id`),
INDEX name (`phone_no`, `postal_code`)
) ENGINE=MyISAM  DEFAULT CHARSET = ascii COLLATE = ascii_general_ci; 

load data local infile '/home/hamidrezas/Desktop/SMS_Postal/iran.csv' into table `postal_code_iran` 
fields 
terminated by ','
lines terminated by '\n'
(`phone_no`, `postal_code`);
