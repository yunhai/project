/*
SQLyog Enterprise - MySQL GUI v8.12 
MySQL - 5.0.77 : Database - dongbacjsc
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `vsf_util_exchange` */

DROP TABLE IF EXISTS `vsf_util_exchange`;

CREATE TABLE `vsf_util_exchange` (
  `exchangeId` tinyint(10) NOT NULL auto_increment,
  `exchangeCode` varchar(3) NOT NULL,
  `exchangeName` varchar(16) NOT NULL,
  `exchangeBuy` double NOT NULL,
  `exchangeTranfer` double NOT NULL,
  `exchangeSell` double NOT NULL,
  `exchangeGetTime` int(10) NOT NULL,
  PRIMARY KEY  (`exchangeId`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `vsf_util_exchange` */

insert  into `vsf_util_exchange`(`exchangeId`,`exchangeCode`,`exchangeName`,`exchangeBuy`,`exchangeTranfer`,`exchangeSell`,`exchangeGetTime`) values (1,'AUD','AUST.DOLLAR',19502.61,19620.33,19955.4,1288406786),(2,'CAD','CANADIAN DOLLAR',19522.5,19699.8,19996.19,1288406786),(3,'CHF','SWISS FRANCE',20254.42,20397.2,20745.54,1288406786),(4,'DKK','DANISH KRONE',0,3743.36,3822.54,1288406786),(5,'EUR','EURO',27913.47,27997.46,28418.7,1288406786),(6,'GBP','BRITISH POUND',31869.01,32093.67,32576.54,1288406786),(7,'HKD','HONGKONG DOLLAR',2575.62,2593.78,2632.8,1288406786),(8,'INR','INDIAN RUPEE',0,448.19,468.79,1288406786),(9,'JPY','JAPANESE YEN',244.72,247.19,252.42,1288406786),(10,'KRW','SOUTH KOREAN WON',0,16.36,20.09,1288406786),(11,'KWD','KUWAITI DINAR',0,71320.99,73121.67,1288406786),(12,'MYR','MALAYSIAN RINGGI',0,6458.31,6594.94,1288406786),(13,'NOK','NORWEGIAN KRONER',0,3404.07,3476.08,1288406786),(14,'RUB','RUSSIAN RUBLE',0,600.19,737.2,1288406786),(15,'SEK','SWEDISH KRONA',0,2977.87,3040.86,1288406786),(16,'SGD','SINGAPORE DOLLAR',15398.93,15507.48,15740.8,1288406786),(17,'THB','THAI BAHT',661.89,661.89,692.31,1288406786),(18,'USD','US DOLLAR',19495,19495,19500,1288406786);

/*Table structure for table `vsf_util_weather` */

DROP TABLE IF EXISTS `vsf_util_weather`;

CREATE TABLE `vsf_util_weather` (
  `weatherId` tinyint(16) NOT NULL auto_increment,
  `weatherCityCode` varchar(6) NOT NULL,
  `weatherCity` varchar(64) NOT NULL,
  `weatherTemp` varchar(3) NOT NULL,
  `weatherDesc` varchar(512) NOT NULL,
  `weatherImage` varchar(128) NOT NULL,
  `weatherGetTime` int(10) NOT NULL,
  PRIMARY KEY  (`weatherId`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `vsf_util_weather` */

insert  into `vsf_util_weather`(`weatherId`,`weatherCityCode`,`weatherCity`,`weatherTemp`,`weatherDesc`,`weatherImage`,`weatherGetTime`) values (1,'Sonla','SÆ¡n La','18','<b>MÃ¢y thay Ä‘á»•i</b><br>&#272;&#7897; &#7849;m 63%<br>GiÃ³ Ä‘Ã´ng nam<br>tá»‘c Ä‘á»™ 2 m/s','http://vnexpress.net/Images/Weather/ngaymaythaydoi.gif',1288409329),(2,'Haipho','Háº£i PhÃ²ng','21','<b>MÃ¢y thay Ä‘á»•i</b><br>&#272;&#7897; &#7849;m 51%<br>GiÃ³ báº¯c<br>tá»‘c Ä‘á»™ 3 m/s','http://vnexpress.net/Images/Weather/ngaymaythaydoi.gif',1288409329),(3,'Hanoi','HÃ  NÃ´i','22','<b>Ãt mÃ¢y</b><br>&#272;&#7897; &#7849;m 49%<br>GiÃ³ Ä‘Ã´ng báº¯c<br>tá»‘c Ä‘á»™ 2 m/s','http://vnexpress.net/Images/Weather/i_troinang.gif',1288409329),(4,'Vinh','Vinh','21','<b>Nhiá»u mÃ¢y</b><br>&#272;&#7897; &#7849;m 61%<br>GiÃ³ tÃ¢y báº¯c<br>tá»‘c Ä‘á»™ 3 m/s','http://vnexpress.net/Images/Weather/i_nhieumay.gif',1288409329),(5,'Danang','ÄÃ  Náºµng','21','<b>CÃ³ mÆ°a</b><br>&#272;&#7897; &#7849;m 85%<br>GiÃ³ Ä‘Ã´ng báº¯c<br>tá»‘c Ä‘á»™ 3 m/s','http://vnexpress.net/Images/Weather/coluccomua.gif',1288409329),(6,'Nhatra','Nha Trang','22','<b>CÃ³ mÆ°a</b><br>&#272;&#7897; &#7849;m 93%<br>GiÃ³ tÃ¢y<br>tá»‘c Ä‘á»™ 1 m/s','http://vnexpress.net/Images/Weather/coluccomua.gif',1288409329),(7,'Pleicu','Pleiku','20','<b>Nhiá»u mÃ¢y</b><br>&#272;&#7897; &#7849;m 79%<br>GiÃ³ báº¯c Ä‘Ã´ng báº¯c<br>tá»‘c Ä‘á»™ 4 m/s','http://vnexpress.net/Images/Weather/i_nhieumay.gif',1288409329),(8,'HCM','Tp. Há»“ ChÃ­ Minh','23','<b>CÃ³ mÆ°a</b><br>&#272;&#7897; &#7849;m 95%<br>GiÃ³ báº¯c tÃ¢y báº¯c<br>tá»‘c Ä‘á»™ 10 m/s','http://vnexpress.net/Images/Weather/coluccomua.gif',1288409329);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
