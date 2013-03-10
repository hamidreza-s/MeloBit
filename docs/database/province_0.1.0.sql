CREATE TABLE IF NOT EXISTS `province_code_all_filtered` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`phone_no` varchar(10) NOT NULL, 
`province_code` varchar(10) NOT NULL, 
PRIMARY KEY (`id`),
INDEX province_code (`province_code`)
) ENGINE=MyISAM  DEFAULT CHARACTER SET = ascii COLLATE = ascii_general_ci; 

load data local infile 'D:/Province_lab/All/Merged/Filtered/all.txt' into table `province_code_all_filtered` 
fields 
terminated by ','
lines terminated by '\n'
(`phone_no`, `province_code`);

CREATE TABLE IF NOT EXISTS `province_name_list` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`province_code` varchar(10) NOT NULL, 
`province_name` varchar(200) NOT NULL, 
PRIMARY KEY (`id`),
INDEX province_code (`province_code`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci; 

load data local infile 'D:/Province_lab/Metafiles/provinces_metafile.csv' into table `province_name_list` 
fields 
terminated by ';'
lines terminated by '\n'
(`province_code`, `province_name`);

CREATE TABLE IF NOT EXISTS `province_city_name_list` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`city_code` varchar(10) NOT NULL, 
`city_name` varchar(200) NOT NULL, 
PRIMARY KEY (`id`),
INDEX city_code (`city_code`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci; 

load data local infile 'D:/Province_lab/Metafiles/cities_metafile.csv' into table `province_city_name_list` 
fields 
terminated by ';'
lines terminated by '\n'
(`city_code`, `city_name`);