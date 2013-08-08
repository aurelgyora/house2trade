house2trade
===========
03.08.2013
ALTER TABLE `match` ADD `mailing_date` DATE NULL DEFAULT NULL AFTER `create_date` ;
INSERT INTO `housetrade_db2`.`mails`(`id`,`subject`,`file_path`)VALUES('12','New Match','admin_interface/mails/new-match');

#UPDATE `properties` SET `broker`=9,`owner`=3 WHERE `id` IN (4,46,543,256,512,1024,321,432,832,893,1843,1633)
#SELECT * FROM `properties` WHERE `id` IN (4,46,543,256,512,1024,321,432,832,893,1843,1633)