-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: origamidb
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1-log

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
-- Current Database: `origamidb`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `origamidb` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `origamidb`;

--
-- Table structure for table `aggiornamento_config_ori`
--

DROP TABLE IF EXISTS `aggiornamento_config_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aggiornamento_config_ori` (
  `id` int(11) NOT NULL,
  `parametro` varchar(255) DEFAULT NULL,
  `valore` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `descrizione` varchar(255) DEFAULT NULL,
  `abilitato` tinyint(1) DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aggiornamento_config_ori`
--

LOCK TABLES `aggiornamento_config_ori` WRITE;
/*!40000 ALTER TABLE `aggiornamento_config_ori` DISABLE KEYS */;
INSERT INTO `aggiornamento_config_ori` VALUES (1,'field.delimiter',';','Ambiente','Carattere di delimitazione dei campi',1,'2012-08-03 12:49:52'),(2,'out.file.pfx','OUT','Ambiente','Prefisso del file xml in uscita ',1,'2012-08-03 12:49:52'),(3,'in.file.pfx','IN','Ambiente','Prefisso del file xml in entrata ',1,'2012-08-03 12:49:52'),(4,'jaxb.index.file.name','jaxb.index','Ambiente','Nome del file utile alla creazione del JAXBContext',1,'2012-08-03 12:49:52'),(5,'macchina.jaxb.package.name','it/personalfactory/fabcloud/macchina/entity','Macchina','Path al package del  jaxb.index.file.name della macchina Linux',1,'2012-09-27 14:18:19'),(6,'macchina.jaxb.output.package.name','it.personalfactory.fabcloud.macchina.entity','Macchina','Nome del package del jaxb.index.file.name utilizzato per il file in uscita',1,'2012-09-27 14:18:37'),(7,'macchina.xml.schema.generate.dir','MacchinaXMLSchema','Macchina','Nome della directory in cui viene generato il file xsd della macchina',1,'2012-08-03 12:49:52'),(8,'macchina.xml.schema.generate.file.name','schema1.xsd','Macchina','Nome di generazione del file xsd della macchina',1,'2012-08-03 12:49:52'),(9,'macchina.xml.schema.copy.build.dir ','/build/classes/META-INF','Macchina','Path della directory di copia del file xsd ??',1,'2012-08-03 12:49:52'),(10,'macchina.xml.schema.dest.file.name','macchina.xsd','Macchina','Nome di destinazione del file xsd della macchina',1,'2012-08-03 12:49:52'),(11,'macchina.xml.data.out.generate.dir','MacchinaXMLDataOut','Macchina','Directory  in cui vengono generati i file xml in uscita',1,'2012-08-03 12:49:52'),(12,'macchina.xml.data.out.compress.dir','MacchinaXMLDataZipOut','Macchina','Directory in cui vengono salvati temporaneamente i file compressi in uscita ??',1,'2012-08-03 12:49:52'),(13,'macchina.xml.data.out.transfered.dir','MacchinaFTPTransferOut','Macchina','Directory contenente i file trasferiti sul server FTP',1,'2012-08-03 12:49:52'),(14,'macchina.xml.data.in.downloaded.dir','MacchinaFTPDownloadIn','Macchina','Directory in cui vengono scaricati i file .zip provenienti dal server',1,'2012-08-03 12:49:52'),(15,'macchina.xml.data.in.uncompress.dir','MacchinaXMLDataIn','Macchina','Directory contenente i file decompressi provenienti dal server',1,'2012-08-03 12:49:52'),(16,'macchina.xml.data.in.compress.dir','MacchinaXMLDataZipIn','Macchina','Directory in cui vengono archiviati i file compressi provenienti dal server dopo la decompressione',1,'2012-08-03 12:49:52'),(17,'macchina.ftp.server.out.dir','agg','Macchina','Nome della directory del server FTP contenente i file in uscita dalla macchina (è la stessa per tutte le macchine)  ',1,'2013-01-08 10:34:47'),(18,'macchina.ftp.server.in.dir','s2m','Macchina','Directory del server FTP contenente i file in entrata provenienti dal server',1,'2012-08-03 12:49:52'),(19,'macchina.ftp.server.in.dir.old','old','Macchina','Directory di backup sul server FTP dei file in entrata provenienti dal server',1,'2012-08-03 12:49:52'),(20,'xsd.macchina.file','META-INF/macchina.xsd','Macchina','Path del file xsd della macchina Linux',1,'2012-08-03 12:49:52'),(21,'ftp.server.name','195.110.124.133','FTP','Indirizzo IP del server FTP di scambio',1,'2012-08-03 12:49:52'),(22,'ftp.server.port','21','FTP','Porta del server FTP',1,'2012-08-03 12:49:52'),(23,'ftp.server.mirror.list','195.110.124.133','FTP','Lista dei server FTP di mirror',1,'2014-10-14 09:15:08'),(24,'windows.macchina.jaxb.package.name','it\\personalfactory\\syncorigami\\server\\entity','Macchina','Path al package del  jaxb.index.file.name della macchina Windows',1,'2012-08-03 12:49:52'),(25,'windows.macchina.xml.schema.copy.build.dir','\\build\\classes\\META-INF','Macchina','Path della directory di copia del file xsd Windows??',1,'2012-08-03 12:49:52'),(26,'windows.xsd.macchina.file','META-INF\\macchina.xsd','Macchina','Path del file xsd della macchina Windows',1,'2012-08-03 12:49:52'),(27,'bkp.file.pfx','BKP','Server','Prefisso del file di backup costruito dalla macchina',1,'2012-08-03 12:49:52'),(28,'macchina.ftp.server.out.bkp.dir','bkp','Macchina','Nome della directory del server FTP contenente i file di backup in uscita dalla macchina (è la stessa per tutte le macchine)  ',1,'2012-08-03 12:49:52'),(29,'server.ftp.server.user','server_simbario','FTP','Username per l\'accesso alla cartella del FTP contenente tutti i file in entrata',1,'2012-10-01 09:52:20'),(30,'server.ftp.server.password','Tssfnc79_','FTP','Password per l\'accesso alla cartella del FTP contenente tutti i file in entrata',1,'2012-10-01 09:52:22'),(31,'ftp.file.separator','/','FTP','File separator utilizzato in fase di download per rinominare e spostare i file nella cartella old',1,'2012-10-01 09:53:22'),(32,'data.default','02/01/1970 - 00:00:00','Ambiente','Valore di default utilizzato per i campi data',1,'2012-10-01 09:53:22'),(33,'macchina.db.name','origamidb','Macchina','Nome del database a bordo macchina',1,'2012-12-06 17:00:24'),(34,'bkp.zero.file.pfx','BKP0','Macchina-Server','Prefisso del file di backup zero costruito dalla macchina',1,'2012-12-03 12:15:06'),(35,'macchina.ftp.server.in.bkp0.dir','bkp0','FTP','Nome della cartella del server FTP contenente i fle di bkp0 inviati dal server alla macchina',1,'2012-12-03 12:15:08'),(36,'macchina.data.sql.ripristino','Ripristino','Macchina','Directory contenente il file di backup0 decompresso proveniente dal server',1,'2012-12-12 13:17:52'),(37,'syncorigami.log.file.name','syncorigami.log','Macchina','Nome del file di log di syncorigami',1,'2012-12-18 14:46:44'),(38,'macchina.log.dir','log','Macchina','Directory contente i file di log',1,'2012-12-06 17:00:44'),(39,'macchina.jar.dir','dist','Macchina','Directory contente il file jar',1,'2012-12-06 17:00:44'),(40,'sync.file.log.pfx','SYN','Macchina','Prefisso del file di log di syncorigami',1,'2012-12-12 10:53:24'),(41,'proc.file.log.pfx','PRO','Macchina','Prefisso del file di log del processo',1,'2012-12-12 10:52:14'),(42,'macchina.ftp.log.dir','log','FTP','Directory del server ftp contenente i file di log ',1,'2012-12-12 10:52:14'),(43,'log4j.file.name','log4j.properties','Ambiente','Nome del file di configurazione di log4j',1,'2012-12-12 10:52:14'),(44,'processo.log.file.name','processo.log','Macchina','Nome del file di log del processo',1,'2012-12-18 14:47:45'),(45,'macchina.ftp.server.in.jar.dir','sft','Macchina','Nome della directory del server FTP da cui scaricare il file jar di CloudFab',1,'2015-01-28 10:58:18'),(46,'macchina.jar.file.in.download.dir','software_update','Macchina','Nome della directory in cui scaricare il jar sulla macchina',1,'2014-05-26 17:54:56'),(47,'mail.sender.user','syncorigami@isolmix.com','Notifiche','Username per l invio delle notifiche via mail',1,'2014-05-23 16:13:44'),(48,'mail.sender.password','syncorigamimail','Notifiche','Password dell account che invia le notifiche',1,'2014-05-23 16:23:27'),(49,'mail.host','smtp.gmail.com','Notifiche','Host per l invio mail',1,'2014-05-23 16:23:27'),(50,'mail.address.sender','syncorigami@isolmix.com','Notifiche','Indirizzo e-mail mittente',1,'2014-05-23 16:28:03'),(51,'mail.address.receiver','syncorigami@isolmix.com','Notifiche','Indirizzo e-mail destinatario',1,'2014-05-23 16:28:56'),(52,'mail.object','ERRORE SYNCORIGAMI MACCHINA','Notifiche','Oggetto della mail di notifica',1,'2014-05-23 16:31:05'),(53,'mail.path.file','dist/log/syncorigami.log','Notifiche','Percorso del file allegato alla mail per Linux',1,'2014-05-23 16:31:58'),(54,'windows.mail.path.file','dist\\log\\syoncorigami.log','Notifiche','Percorso del file allegato alla mail per windows',1,'2014-05-23 16:32:39');
/*!40000 ALTER TABLE `aggiornamento_config_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aggiornamento_ori`
--

DROP TABLE IF EXISTS `aggiornamento_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aggiornamento_ori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(10) DEFAULT NULL,
  `dt_aggiornamento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `versione` int(11) DEFAULT NULL,
  `nome_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aggiornamento_ori`
--

LOCK TABLES `aggiornamento_ori` WRITE;
/*!40000 ALTER TABLE `aggiornamento_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `aggiornamento_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria_ori`
--

DROP TABLE IF EXISTS `categoria_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria_ori` (
  `id_cat` int(11) NOT NULL,
  `nome_categoria` varchar(100) DEFAULT NULL,
  `descri_categoria` varchar(255) DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria_ori`
--

LOCK TABLES `categoria_ori` WRITE;
/*!40000 ALTER TABLE `categoria_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `categoria_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chimica_ori`
--

DROP TABLE IF EXISTS `chimica_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chimica_ori` (
  `id_chimica` int(11) NOT NULL,
  `cod_chimica` varchar(255) DEFAULT NULL,
  `stato_ch` tinyint(1) DEFAULT NULL,
  `num_bolla` int(11) DEFAULT NULL,
  `cod_lotto` varchar(50) DEFAULT NULL,
  `descri_formula` varchar(255) DEFAULT NULL,
  `dt_bolla` date DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_chimica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chimica_ori`
--

LOCK TABLES `chimica_ori` WRITE;
/*!40000 ALTER TABLE `chimica_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `chimica_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente_ori`
--

DROP TABLE IF EXISTS `cliente_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente_ori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente_ori`
--

LOCK TABLES `cliente_ori` WRITE;
/*!40000 ALTER TABLE `cliente_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `cliente_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colore_base_ori`
--

DROP TABLE IF EXISTS `colore_base_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colore_base_ori` (
  `id_colore_base` int(11) NOT NULL,
  `nome_colore_base` varchar(50) DEFAULT NULL,
  `cod_colore_base` varchar(50) DEFAULT NULL,
  `costo_colore_base` double DEFAULT NULL,
  `toll_perc` double DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_colore_base`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colore_base_ori`
--

LOCK TABLES `colore_base_ori` WRITE;
/*!40000 ALTER TABLE `colore_base_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `colore_base_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colore_ori`
--

DROP TABLE IF EXISTS `colore_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colore_ori` (
  `id_colore` int(11) NOT NULL AUTO_INCREMENT,
  `cod_colore` varchar(50) DEFAULT NULL,
  `nome_colore` varchar(100) DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_colore`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colore_ori`
--

LOCK TABLES `colore_ori` WRITE;
/*!40000 ALTER TABLE `colore_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `colore_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `componente_ori`
--

DROP TABLE IF EXISTS `componente_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `componente_ori` (
  `id_comp` int(11) NOT NULL,
  `cod_componente` varchar(50) DEFAULT NULL,
  `descri_componente` varchar(255) DEFAULT NULL,
  `abilitato` tinyint(1) DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_comp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `componente_ori`
--

LOCK TABLES `componente_ori` WRITE;
/*!40000 ALTER TABLE `componente_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `componente_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `componente_prodotto_ori`
--

DROP TABLE IF EXISTS `componente_prodotto_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `componente_prodotto_ori` (
  `id_comp_prod` int(11) NOT NULL,
  `id_comp` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `quantita` double DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_comp_prod`),
  KEY `IndexProdotto` (`id_prodotto`),
  KEY `IndexComp` (`id_comp`),
  CONSTRAINT `componente_prodotto_ori_ibfk_1` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotto_ori` (`id_prodotto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `componente_prodotto_ori_ibfk_2` FOREIGN KEY (`id_comp`) REFERENCES `componente_ori` (`id_comp`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `componente_prodotto_ori`
--

LOCK TABLES `componente_prodotto_ori` WRITE;
/*!40000 ALTER TABLE `componente_prodotto_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `componente_prodotto_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dizionario_ori`
--

DROP TABLE IF EXISTS `dizionario_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dizionario_ori` (
  `id_dizionario` int(11) NOT NULL AUTO_INCREMENT,
  `id_diz_tipo` int(11) NOT NULL,
  `nome_dizionario_tipo` varchar(255) DEFAULT NULL,
  `id_lingua` int(11) NOT NULL,
  `nome_lingua` varchar(255) DEFAULT NULL,
  `id_vocabolo` int(11) DEFAULT NULL,
  `vocabolo` text,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_dizionario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dizionario_ori`
--

LOCK TABLES `dizionario_ori` WRITE;
/*!40000 ALTER TABLE `dizionario_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `dizionario_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `macchina_ori`
--

DROP TABLE IF EXISTS `macchina_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `macchina_ori` (
  `id_macchina` int(11) NOT NULL DEFAULT '0',
  `cod_stab` varchar(50) DEFAULT NULL,
  `descri_stab` varchar(50) DEFAULT NULL,
  `ragso1` varchar(50) DEFAULT NULL,
  `user_origami` varchar(50) DEFAULT NULL,
  `user_server` varchar(50) DEFAULT NULL,
  `pass_origami` varchar(50) DEFAULT NULL,
  `pass_server` varchar(50) DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ftp_user` varchar(255) DEFAULT NULL,
  `ftp_password` varchar(255) DEFAULT NULL,
  `zip_password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_macchina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `macchina_ori`
--

LOCK TABLES `macchina_ori` WRITE;
/*!40000 ALTER TABLE `macchina_ori` DISABLE KEYS */;
INSERT INTO `macchina_ori` VALUES (58,'000000152','ARORFO HOLDINGS LTD','ARORFO HOLDINGS LTD','3','3','3','',1,'2016-04-06 09:03:19','macchina58','krXPATk1pnpPg','macchinaXY_pwd');
/*!40000 ALTER TABLE `macchina_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mazzetta_col_sing_mac_ori`
--

DROP TABLE IF EXISTS `mazzetta_col_sing_mac_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mazzetta_col_sing_mac_ori` (
  `id_maz_sing_mac` int(11) NOT NULL AUTO_INCREMENT,
  `id_mazzetta` int(11) NOT NULL,
  `cod_colore` varchar(255) NOT NULL DEFAULT '',
  `id_colore_base` int(11) NOT NULL,
  `quantita` int(11) DEFAULT NULL,
  `abilitato` tinyint(1) unsigned NOT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_maz_sing_mac`),
  KEY `id_mazzetta` (`id_mazzetta`),
  KEY `id_colore` (`cod_colore`),
  KEY `id_colore_base` (`id_colore_base`),
  CONSTRAINT `mcsmo_id_colore_base` FOREIGN KEY (`id_colore_base`) REFERENCES `colore_base_ori` (`id_colore_base`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mcsmo_id_mazzetta` FOREIGN KEY (`id_mazzetta`) REFERENCES `mazzetta_ori` (`id_mazzetta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mazzetta_col_sing_mac_ori`
--

LOCK TABLES `mazzetta_col_sing_mac_ori` WRITE;
/*!40000 ALTER TABLE `mazzetta_col_sing_mac_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `mazzetta_col_sing_mac_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mazzetta_colorata_ori`
--

DROP TABLE IF EXISTS `mazzetta_colorata_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mazzetta_colorata_ori` (
  `id_maz_col` int(11) NOT NULL,
  `id_colore` int(11) NOT NULL,
  `id_colore_base` int(11) NOT NULL,
  `id_mazzetta` int(11) NOT NULL,
  `quantita` int(11) DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_maz_col`),
  KEY `IndexMazzetta` (`id_mazzetta`),
  KEY `IndexColore` (`id_colore`),
  KEY `IndexColoreBase` (`id_colore_base`),
  CONSTRAINT `mazzetta_colorata_ori_ibfk_1` FOREIGN KEY (`id_mazzetta`) REFERENCES `mazzetta_ori` (`id_mazzetta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mazzetta_colorata_ori_ibfk_2` FOREIGN KEY (`id_colore`) REFERENCES `colore_ori` (`id_colore`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mazzetta_colorata_ori_ibfk_3` FOREIGN KEY (`id_colore_base`) REFERENCES `colore_base_ori` (`id_colore_base`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mazzetta_colorata_ori`
--

LOCK TABLES `mazzetta_colorata_ori` WRITE;
/*!40000 ALTER TABLE `mazzetta_colorata_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `mazzetta_colorata_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mazzetta_ori`
--

DROP TABLE IF EXISTS `mazzetta_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mazzetta_ori` (
  `id_mazzetta` int(11) NOT NULL,
  `cod_mazzetta` varchar(50) DEFAULT NULL,
  `nome_mazzetta` varchar(255) DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_mazzetta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mazzetta_ori`
--

LOCK TABLES `mazzetta_ori` WRITE;
/*!40000 ALTER TABLE `mazzetta_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `mazzetta_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `num_sacchetto_ori`
--

DROP TABLE IF EXISTS `num_sacchetto_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `num_sacchetto_ori` (
  `id_num_sac` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `num_sacchetti` int(11) DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_num_sac`),
  KEY `id_cat` (`id_cat`),
  CONSTRAINT `Categoria` FOREIGN KEY (`id_cat`) REFERENCES `categoria_ori` (`id_cat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `num_sacchetto_ori`
--

LOCK TABLES `num_sacchetto_ori` WRITE;
/*!40000 ALTER TABLE `num_sacchetto_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `num_sacchetto_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametro_comp_prod_ori`
--

DROP TABLE IF EXISTS `parametro_comp_prod_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametro_comp_prod_ori` (
  `id_par_comp` int(11) NOT NULL,
  `nome_variabile` varchar(255) DEFAULT NULL,
  `descri_variabile` varchar(255) DEFAULT NULL,
  `valore_base` varchar(255) DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_par_comp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametro_comp_prod_ori`
--

LOCK TABLES `parametro_comp_prod_ori` WRITE;
/*!40000 ALTER TABLE `parametro_comp_prod_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `parametro_comp_prod_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametro_glob_mac_ori`
--

DROP TABLE IF EXISTS `parametro_glob_mac_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametro_glob_mac_ori` (
  `id_par_gm` int(11) NOT NULL,
  `nome_variabile` varchar(255) DEFAULT NULL,
  `descri_variabile` varchar(255) DEFAULT NULL,
  `valore_variabile` varchar(255) DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_par_gm`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametro_glob_mac_ori`
--

LOCK TABLES `parametro_glob_mac_ori` WRITE;
/*!40000 ALTER TABLE `parametro_glob_mac_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `parametro_glob_mac_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presa_ori`
--

DROP TABLE IF EXISTS `presa_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `presa_ori` (
  `id_presa` int(11) NOT NULL,
  `presa` varchar(255) DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_presa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presa_ori`
--

LOCK TABLES `presa_ori` WRITE;
/*!40000 ALTER TABLE `presa_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `presa_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `processo_ori`
--

DROP TABLE IF EXISTS `processo_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `processo_ori` (
  `id_processo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cod_prodotto` varchar(255) DEFAULT '',
  `cod_chimica` varchar(255) DEFAULT '',
  `cod_sacco` varchar(255) DEFAULT '',
  `peso_reale_sacco` int(11) DEFAULT '0',
  `cod_comp_peso` varchar(255) DEFAULT '',
  `cod_colore` varchar(255) DEFAULT '',
  `cliente` varchar(255) DEFAULT '',
  `dt_produzione` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_operatore` varchar(255) DEFAULT '',
  `cod_comp_in` varchar(255) DEFAULT '',
  `tipo_processo` int(11) DEFAULT '0',
  `info1` varchar(255) DEFAULT '',
  `info2` varchar(255) DEFAULT '',
  `info3` varchar(255) DEFAULT '',
  `info4` varchar(255) DEFAULT '',
  `info5` varchar(255) DEFAULT '',
  PRIMARY KEY (`id_processo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `processo_ori`
--

LOCK TABLES `processo_ori` WRITE;
/*!40000 ALTER TABLE `processo_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `processo_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prodotto_ori`
--

DROP TABLE IF EXISTS `prodotto_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prodotto_ori` (
  `id_prodotto` int(11) NOT NULL,
  `cod_prodotto` varchar(50) DEFAULT NULL,
  `nome_prodotto` varchar(255) DEFAULT NULL,
  `id_mazzetta` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `id_codice` int(11) NOT NULL,
  `tipo_famiglia` varchar(50) DEFAULT NULL,
  `descri_famiglia` varchar(255) DEFAULT NULL,
  `colorato` varchar(50) DEFAULT NULL,
  `lim_colore` varchar(50) DEFAULT NULL,
  `fattore_div` varchar(50) DEFAULT NULL,
  `fascia` varchar(50) DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_prodotto`),
  KEY `IndexCategoria` (`id_cat`),
  KEY `IndexMazzetta` (`id_mazzetta`),
  CONSTRAINT `prodotto_ori_ibfk_1` FOREIGN KEY (`id_mazzetta`) REFERENCES `mazzetta_ori` (`id_mazzetta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prodotto_ori_ibfk_2` FOREIGN KEY (`id_cat`) REFERENCES `categoria_ori` (`id_cat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prodotto_ori`
--

LOCK TABLES `prodotto_ori` WRITE;
/*!40000 ALTER TABLE `prodotto_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `prodotto_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valore_par_comp_ori`
--

DROP TABLE IF EXISTS `valore_par_comp_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valore_par_comp_ori` (
  `id_val_comp` int(11) NOT NULL,
  `id_comp` int(11) NOT NULL,
  `id_par_comp` int(11) NOT NULL,
  `valore_variabile` varchar(255) DEFAULT NULL,
  `valore_iniziale` varchar(255) DEFAULT NULL,
  `dt_valore_iniziale` timestamp NOT NULL DEFAULT '1970-01-01 23:00:00',
  `dt_modifica_mac` timestamp NOT NULL DEFAULT '1970-01-01 23:00:00',
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT '1970-01-01 23:00:00',
  PRIMARY KEY (`id_val_comp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valore_par_comp_ori`
--

LOCK TABLES `valore_par_comp_ori` WRITE;
/*!40000 ALTER TABLE `valore_par_comp_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `valore_par_comp_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valore_par_prod_mac_ori`
--

DROP TABLE IF EXISTS `valore_par_prod_mac_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valore_par_prod_mac_ori` (
  `id_val_pm` int(11) NOT NULL,
  `id_par_pm` int(11) DEFAULT NULL,
  `id_prodotto` int(11) DEFAULT NULL,
  `valore_variabile` varchar(255) DEFAULT '',
  `abilitato` int(11) DEFAULT NULL,
  `dt_abilitato` timestamp NULL DEFAULT '1970-01-01 22:00:00',
  PRIMARY KEY (`id_val_pm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valore_par_prod_mac_ori`
--

LOCK TABLES `valore_par_prod_mac_ori` WRITE;
/*!40000 ALTER TABLE `valore_par_prod_mac_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `valore_par_prod_mac_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valore_par_prod_ori`
--

DROP TABLE IF EXISTS `valore_par_prod_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valore_par_prod_ori` (
  `id_val_par_pr` int(11) NOT NULL,
  `id_par_prod` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `valore_variabile` varchar(255) DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_val_par_pr`),
  KEY `IndexCategoria` (`id_cat`),
  CONSTRAINT `valore_par_prod_ori_ibfk_1` FOREIGN KEY (`id_cat`) REFERENCES `categoria_ori` (`id_cat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valore_par_prod_ori`
--

LOCK TABLES `valore_par_prod_ori` WRITE;
/*!40000 ALTER TABLE `valore_par_prod_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `valore_par_prod_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valore_par_sacchetto_ori`
--

DROP TABLE IF EXISTS `valore_par_sacchetto_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valore_par_sacchetto_ori` (
  `id_val_par_sac` int(11) NOT NULL,
  `id_par_sac` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `id_num_sac` int(11) NOT NULL,
  `sacchetto` int(11) DEFAULT NULL,
  `valore_variabile` varchar(255) DEFAULT NULL,
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nome_par_sac` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_val_par_sac`),
  KEY `vpso_IndexCategoria` (`id_cat`),
  KEY `vpso_id_num_sac` (`id_num_sac`),
  CONSTRAINT `valore_par_sacchetto_ori_ibfk_1` FOREIGN KEY (`id_num_sac`) REFERENCES `num_sacchetto_ori` (`id_num_sac`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `valore_par_sacchetto_ori_ibfk_2` FOREIGN KEY (`id_cat`) REFERENCES `categoria_ori` (`id_cat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valore_par_sacchetto_ori`
--

LOCK TABLES `valore_par_sacchetto_ori` WRITE;
/*!40000 ALTER TABLE `valore_par_sacchetto_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `valore_par_sacchetto_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valore_par_sing_mac_ori`
--

DROP TABLE IF EXISTS `valore_par_sing_mac_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valore_par_sing_mac_ori` (
  `id_val_par_sm` int(11) NOT NULL,
  `id_par_sm` int(11) NOT NULL,
  `valore_variabile` varchar(255) DEFAULT NULL,
  `valore_iniziale` varchar(255) DEFAULT NULL,
  `dt_valore_iniziale` timestamp NOT NULL DEFAULT '1970-01-01 23:00:00',
  `dt_modifica_mac` timestamp NOT NULL DEFAULT '1970-01-01 23:00:00',
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT '1970-01-01 23:00:00',
  PRIMARY KEY (`id_val_par_sm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valore_par_sing_mac_ori`
--

LOCK TABLES `valore_par_sing_mac_ori` WRITE;
/*!40000 ALTER TABLE `valore_par_sing_mac_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `valore_par_sing_mac_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valore_prodotto_ori`
--

DROP TABLE IF EXISTS `valore_prodotto_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valore_prodotto_ori` (
  `id_val_pr` int(11) NOT NULL,
  `id_par_prod` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `valore_variabile` varchar(255) DEFAULT NULL,
  `abilitato` int(11) DEFAULT NULL,
  `dt_abilitato` timestamp NULL DEFAULT '1970-01-01 22:00:00',
  PRIMARY KEY (`id_val_pr`),
  KEY `fk_valore_prodotto_ori_1_idx` (`id_prodotto`),
  CONSTRAINT `fk_valore_prodotto_ori_1` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotto_ori` (`id_prodotto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valore_prodotto_ori`
--

LOCK TABLES `valore_prodotto_ori` WRITE;
/*!40000 ALTER TABLE `valore_prodotto_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `valore_prodotto_ori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valore_ripristino_ori`
--

DROP TABLE IF EXISTS `valore_ripristino_ori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valore_ripristino_ori` (
  `id_valore_ripristino` int(11) NOT NULL,
  `id_par_ripristino` int(11) NOT NULL,
  `valore_variabile` varchar(255) DEFAULT NULL,
  `id_pro_corso` int(11) DEFAULT NULL,
  `dt_registrato` timestamp NOT NULL DEFAULT '1970-01-01 23:00:00',
  `abilitato` tinyint(1) unsigned DEFAULT NULL,
  `dt_abilitato` timestamp NOT NULL DEFAULT '1970-01-01 23:00:00',
  PRIMARY KEY (`id_valore_ripristino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valore_ripristino_ori`
--

LOCK TABLES `valore_ripristino_ori` WRITE;
/*!40000 ALTER TABLE `valore_ripristino_ori` DISABLE KEYS */;
/*!40000 ALTER TABLE `valore_ripristino_ori` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-06 11:03:19
