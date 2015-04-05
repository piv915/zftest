-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: zftest
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provider_id` int(10) unsigned DEFAULT NULL,
  `sysid` char(32) NOT NULL,
  `title` varchar(64) NOT NULL,
  `en_title` varchar(64) NOT NULL,
  `de_title` varchar(64) NOT NULL,
  `class_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(3) unsigned DEFAULT '1',
  `logotype` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sysid` (`sysid`),
  KEY `fk_payment_provider_id` (`provider_id`),
  KEY `fk_currency_class_id` (`class_id`),
  CONSTRAINT `currency_ibfk_1` FOREIGN KEY (`provider_id`) REFERENCES `payment_provider` (`id`),
  CONSTRAINT `currency_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `currency_class` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (1,NULL,'UNIT','у.е.','','',1,1,NULL),(2,NULL,'RUR','рубль','','',2,1,NULL),(3,NULL,'USD','доллар США','','',2,1,NULL),(4,NULL,'EUR','евро','','',2,1,NULL),(11,1,'ROBOX_Termin','Элекснет','Elecsnet','',3,1,NULL),(12,1,'ROBOX_Yandex','Яндекс.Деньги','Yandex.Money','',3,1,'yandex_money.png'),(13,1,'ROBOX_Elecsn','RUR Кошелек Элекснет','RUR Elecsnet Wallet','',3,1,NULL),(14,1,'ROBOX_W1Ocea','Единый Кошелек','W1','',3,1,NULL),(15,1,'ROBOX_W1UniM','W1 Uni','W1 Uni','',3,1,NULL),(16,1,'ROBOX_BANKOC','RUR Банковская карта','RUR Bank Card','',3,1,NULL),(17,1,'ROBOX_AlfaBa','Альфа-Клик','Alfa-Click','',3,1,NULL),(18,1,'ROBOX_Russia','RUR Банк Русский Стандарт','RUR Russian Standard Bank','',3,1,NULL),(19,1,'ROBOX_Svyazn','Связной QBank','QBank','',3,1,NULL),(20,1,'ROBOX_PSKBR','Промсвязьбанк','Промсвязьбанк','',3,1,NULL),(21,1,'ROBOX_VTB24R','ВТБ24','VTB24','',3,1,NULL),(22,1,'ROBOX_OceanB','Океан Банк','Ocean Bank','',3,1,NULL),(23,1,'ROBOX_HandyB','HandyBank','HandyBank','',3,1,NULL),(25,1,'ROBOX_HandyB14251','Банк «Богородский»','Банк «Богородский»','',3,1,NULL),(26,1,'ROBOX_HandyB14893','Банк «Образование»','Банк «Образование»','',3,1,NULL),(27,1,'ROBOX_HandyB45595','ФлексБанк','ФлексБанк','',3,1,NULL),(28,1,'ROBOX_HandyB76367','АКБ «ФЬЮЧЕР»','АКБ «ФЬЮЧЕР»','',3,1,NULL),(29,1,'ROBOX_HandyB64289','АКБ «Кранбанк»','АКБ «Кранбанк»','',3,1,NULL),(30,1,'ROBOX_HandyB25369','Костромаселькомбанк','Костромаселькомбанк','',3,1,NULL),(31,1,'ROBOX_HandyB59995','Липецкий областной банк','Липецкий областной банк','',3,1,NULL),(32,1,'ROBOX_HandyB73933','«НС Банк»','«НС Банк»','',3,1,NULL),(33,1,'ROBOX_HandyB95061','Русский Трастовый Банк','Русский Трастовый Банк','',3,1,NULL),(34,1,'ROBOX_HandyB23019','Вестинтербанк','Вестинтербанк','',3,1,NULL),(35,1,'ROBOX_MINBan54009','RUR Московский Индустриальный Банк','RUR Moscow Industrial Bank','',3,1,NULL),(36,1,'ROBOX_Factur94200','RUR Фактура','RUR Factura','',3,1,NULL),(37,1,'ROBOX_Megafo29968','Мегафон','Megafon','',3,1,NULL),(38,1,'ROBOX_Rapida70651','RUR Евросеть','RUR Euroset','',3,1,NULL),(39,1,'ROBOX_Rapida80167','RUR Связной','RUR Svyaznoy','',3,1,NULL),(40,1,'ROBOX_BANKOC59753','Мобильная ROBOKASSA','Mobile ROBOKASSA','',3,1,NULL);
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency_class`
--

DROP TABLE IF EXISTS `currency_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency_class` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency_class`
--

LOCK TABLES `currency_class` WRITE;
/*!40000 ALTER TABLE `currency_class` DISABLE KEYS */;
INSERT INTO `currency_class` VALUES (3,'ELECTRONIC'),(1,'INTERNAL'),(2,'REAL');
/*!40000 ALTER TABLE `currency_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency_course`
--

DROP TABLE IF EXISTS `currency_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency_course` (
  `currency_id_from` int(10) unsigned NOT NULL,
  `currency_id_to` int(10) unsigned NOT NULL,
  `course` decimal(14,8) NOT NULL,
  PRIMARY KEY (`currency_id_from`,`currency_id_to`),
  KEY `fk_to_id` (`currency_id_to`),
  CONSTRAINT `currency_course_ibfk_1` FOREIGN KEY (`currency_id_from`) REFERENCES `currency` (`id`),
  CONSTRAINT `currency_course_ibfk_2` FOREIGN KEY (`currency_id_to`) REFERENCES `currency` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency_course`
--

LOCK TABLES `currency_course` WRITE;
/*!40000 ALTER TABLE `currency_course` DISABLE KEYS */;
INSERT INTO `currency_course` VALUES (1,2,1.00000000),(2,1,1.00000000);
/*!40000 ALTER TABLE `currency_course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_create` datetime NOT NULL,
  `cost_units` decimal(10,4) NOT NULL,
  `payment_id` int(10) unsigned DEFAULT NULL,
  `status_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_status_id` (`status_id`),
  KEY `fk_users_id` (`user_id`),
  KEY `fk_payment_id` (`payment_id`),
  CONSTRAINT `order_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `order_status` (`id`),
  CONSTRAINT `order_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `order_ibfk_3` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (2,45,'2015-04-02 03:37:31',46200.0000,NULL,1),(3,45,'2015-04-02 03:42:14',46200.0000,NULL,1),(4,45,'2015-04-02 03:44:21',46200.0000,NULL,1),(5,45,'2015-04-02 03:46:11',46200.0000,NULL,1),(6,45,'2015-04-02 03:47:05',46200.0000,NULL,1),(7,45,'2015-04-02 03:48:05',46200.0000,NULL,1),(8,45,'2015-04-02 04:34:33',46200.0000,NULL,1),(9,45,'2015-04-02 12:43:54',100.0000,NULL,1),(10,45,'2015-04-02 12:44:31',100.0000,NULL,1),(11,45,'2015-04-02 12:45:14',100.0000,NULL,1),(12,45,'2015-04-02 12:45:39',100.0000,NULL,1),(13,45,'2015-04-02 12:46:04',500.0000,NULL,1),(14,45,'2015-04-02 12:46:14',1.0000,NULL,1),(15,45,'2015-04-04 00:25:15',1.0000,NULL,1),(16,45,'2015-04-04 02:44:33',1.0000,NULL,1),(17,45,'2015-04-04 05:02:08',1.0000,NULL,1);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `items_count` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_order_id` (`order_id`),
  KEY `fk_product_id` (`product_id`),
  CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_product`
--

LOCK TABLES `order_product` WRITE;
/*!40000 ALTER TABLE `order_product` DISABLE KEYS */;
INSERT INTO `order_product` VALUES (1,2,1,2),(2,2,2,1),(3,2,4,5),(4,3,1,2),(5,3,2,1),(6,3,4,5),(7,4,1,2),(8,4,2,1),(9,4,4,5),(10,5,1,2),(11,5,2,1),(12,5,4,5),(13,6,1,2),(14,6,2,1),(15,6,4,5),(16,7,1,2),(17,7,2,1),(18,7,4,5),(19,8,1,2),(20,8,2,1),(21,8,4,5),(22,9,1,1),(23,10,1,1),(24,11,1,1),(25,12,1,1),(26,13,1,5),(27,14,5,1),(28,15,5,1),(29,16,5,1),(30,17,5,1);
/*!40000 ALTER TABLE `order_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL,
  `en_title` varchar(32) NOT NULL,
  `de_title` varchar(32) NOT NULL,
  `sysid` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sysid` (`sysid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status`
--

LOCK TABLES `order_status` WRITE;
/*!40000 ALTER TABLE `order_status` DISABLE KEYS */;
INSERT INTO `order_status` VALUES (1,'Новый','New order','','NEW'),(2,'Оплачен','','','PAYDONE'),(3,'Ожидается оплата','','','PAYWAIT'),(4,'Отменен','','','CANCELLED'),(5,'Выполнен','','','DONE'),(6,'Архивирован','','','ARCHIVED');
/*!40000 ALTER TABLE `order_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time_received` datetime NOT NULL,
  `currency_input` int(10) unsigned NOT NULL,
  `currency_amount` decimal(10,4) NOT NULL,
  `units_amount` decimal(10,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_currency_input_id` (`currency_input`),
  CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`currency_input`) REFERENCES `currency` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_provider`
--

DROP TABLE IF EXISTS `payment_provider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_provider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `prefix` varchar(16) NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `prefix` (`prefix`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_provider`
--

LOCK TABLES `payment_provider` WRITE;
/*!40000 ALTER TABLE `payment_provider` DISABLE KEYS */;
INSERT INTO `payment_provider` VALUES (1,'ROBOX','robox',1);
/*!40000 ALTER TABLE `payment_provider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `en_title` varchar(255) NOT NULL,
  `de_title` varchar(255) NOT NULL,
  `cost_units` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT 'internal currency -- units',
  `onsale` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Бейсболка','','',100.0000,1),(2,'VIP-подписка на 1 месяц','','',1000.0000,1),(3,'VIP-подписка на 3 месяца','','',2500.0000,1),(4,'VIP-подписка на год','','',9000.0000,1),(5,'Рубильник','','',1.0000,1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_robox_currency`
--

DROP TABLE IF EXISTS `ps_robox_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ps_robox_currency` (
  `id` int(10) unsigned NOT NULL,
  `mark` char(32) NOT NULL,
  `ru_name` varchar(64) DEFAULT NULL,
  `en_name` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mark` (`mark`),
  CONSTRAINT `ps_robox_currency_ibfk_1` FOREIGN KEY (`id`) REFERENCES `currency` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_robox_currency`
--

LOCK TABLES `ps_robox_currency` WRITE;
/*!40000 ALTER TABLE `ps_robox_currency` DISABLE KEYS */;
INSERT INTO `ps_robox_currency` VALUES (11,'TerminalsElecsnetOceanR','Элекснет','Elecsnet'),(12,'YandexMerchantOceanR','Яндекс.Деньги','Yandex.Money'),(13,'ElecsnetWalletR','RUR Кошелек Элекснет','RUR Elecsnet Wallet'),(14,'W1OceanR','Единый Кошелек','W1'),(15,'W1UniMoneyOceanR','W1 Uni','W1 Uni'),(16,'BANKOCEAN2R','RUR Банковская карта','RUR Bank Card'),(17,'AlfaBankOceanR','Альфа-Клик','Alfa-Click'),(18,'RussianStandardBankR','RUR Банк Русский Стандарт','RUR Russian Standard Bank'),(19,'SvyaznoyR','Связной QBank','QBank'),(20,'PSKBR','Промсвязьбанк','Промсвязьбанк'),(21,'VTB24R','ВТБ24','VTB24'),(22,'OceanBankOceanR','Океан Банк','Ocean Bank'),(23,'HandyBankMerchantOceanR','HandyBank','HandyBank'),(25,'HandyBankBB','Банк «Богородский»','Банк «Богородский»'),(26,'HandyBankBO','Банк «Образование»','Банк «Образование»'),(27,'HandyBankFB','ФлексБанк','ФлексБанк'),(28,'HandyBankFU','АКБ «ФЬЮЧЕР»','АКБ «ФЬЮЧЕР»'),(29,'HandyBankKB','АКБ «Кранбанк»','АКБ «Кранбанк»'),(30,'HandyBankKSB','Костромаселькомбанк','Костромаселькомбанк'),(31,'HandyBankLOB','Липецкий областной банк','Липецкий областной банк'),(32,'HandyBankNSB','«НС Банк»','«НС Банк»'),(33,'HandyBankTB','Русский Трастовый Банк','Русский Трастовый Банк'),(34,'HandyBankVIB','Вестинтербанк','Вестинтербанк'),(35,'MINBankR','RUR Московский Индустриальный Банк','RUR Moscow Industrial Bank'),(36,'FacturaR','RUR Фактура','RUR Factura'),(37,'MegafonR','Мегафон','Megafon'),(38,'RapidaOceanEurosetR','RUR Евросеть','RUR Euroset'),(39,'RapidaOceanSvyaznoyR','RUR Связной','RUR Svyaznoy'),(40,'BANKOCEAN2CHECKR','Мобильная ROBOKASSA','Mobile ROBOKASSA');
/*!40000 ALTER TABLE `ps_robox_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_robox_invoice`
--

DROP TABLE IF EXISTS `ps_robox_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ps_robox_invoice` (
  `order_id` int(10) unsigned NOT NULL,
  `invoice_id` char(20) NOT NULL,
  `time_create` datetime NOT NULL,
  `time_check` datetime NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `currency_mark` char(32) NOT NULL,
  UNIQUE KEY `invoice_id` (`invoice_id`),
  KEY `fk_order_id` (`order_id`),
  KEY `fk_robox_currency` (`currency_mark`),
  CONSTRAINT `ps_robox_invoice_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  CONSTRAINT `ps_robox_invoice_ibfk_2` FOREIGN KEY (`currency_mark`) REFERENCES `ps_robox_currency` (`mark`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_robox_invoice`
--

LOCK TABLES `ps_robox_invoice` WRITE;
/*!40000 ALTER TABLE `ps_robox_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_robox_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `verif_code` varchar(255) NOT NULL,
  `verif_code_actual` date NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` int(1) NOT NULL,
  `attempts_count` int(11) NOT NULL DEFAULT '0',
  `avatar` varchar(255) NOT NULL,
  `orderid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` int(4) NOT NULL,
  `birthday` date DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `badge` int(11) DEFAULT NULL,
  `badge_received_when` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `invitation_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `country_id` (`country_id`),
  KEY `city_id` (`city_id`),
  KEY `i` (`type_id`),
  KEY `badge` (`badge`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `bb_roles` (`id`),
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`),
  CONSTRAINT `users_ibfk_3` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  CONSTRAINT `users_ibfk_4` FOREIGN KEY (`type_id`) REFERENCES `user_type` (`id`),
  CONSTRAINT `users_ibfk_9` FOREIGN KEY (`badge`) REFERENCES `badges` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (45,'aandrej@rambler.com','b5c85991a445673d417ede5995ae93d5:cLGJsOX9PrfgA5konCbIazB3l8yZphY1',5,'','0000-00-00','2015-02-17 17:11:56',1,0,'',0,'fasdfjadklf',1,'1980-01-11',20,41413,1,NULL,'',NULL,'0000-00-00 00:00:00','2015-02-17 21:11:56','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-04  5:08:11
