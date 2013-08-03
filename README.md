house2trade
===========
03.08.2013
ALTER TABLE `match` ADD `mailing_date` DATE NULL DEFAULT NULL AFTER `create_date` ;
INSERT INTO `housetrade_db2`.`mails`(`id`,`subject`,`file_path`)VALUES('12','New Match','admin_interface/mails/new-match');