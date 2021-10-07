CREATE DATABASE  IF NOT EXISTS `api_mutant` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `api_mutant`;
--
-- Table structure for table `stats`
--

DROP TABLE IF EXISTS `stats`;
CREATE TABLE `stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mutant` int(1) NOT NULL DEFAULT '0',
  `human` int(1) NOT NULL DEFAULT '0',
  `dna` varchar(500) NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stats`
--

LOCK TABLES `stats` WRITE;
/*!40000 ALTER TABLE `stats` DISABLE KEYS */;
INSERT INTO `stats` VALUES (8,1,0,'ATGCGA,CAGTGC,TTATGT,AGAAGG,CCCCTA,TCACTG','2021-10-07 01:31:52'),(9,0,1,'ATGCGA,CAGTGC,TTATTT,AGACGG,GCGTCA,TCACTG','2021-10-07 01:33:22');
/*!40000 ALTER TABLE `stats` ENABLE KEYS */;
UNLOCK TABLES;
