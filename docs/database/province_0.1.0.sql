CREATE TABLE IF NOT EXISTS `province_code_01` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`phone_no` varchar(10) NOT NULL, 
`province_code` varchar(10) NOT NULL, 
PRIMARY KEY (`id`),
INDEX province_code (`province_code`)
) ENGINE=MyISAM  DEFAULT CHARSET = ascii COLLATE = ascii_general_ci; 

load data local infile 'C:/Users/h.soleimani/Desktop/01_Azarbaijansharghi/01.csv' into table `province_code_01` 
fields 
terminated by ','
lines terminated by '\n'
(`phone_no`, `province_code`);

