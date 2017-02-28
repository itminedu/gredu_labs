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
-- Table structure for table `applicationform`
--

DROP TABLE IF EXISTS `applicationform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicationform` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(11) unsigned NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `submitted` int(11) unsigned NOT NULL,
  `submitted_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `received_ts` timestamp NULL,
  `received_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `approved` int(11) unsigned NOT NULL DEFAULT 0,
  `approved_date` int(11)  unsigned NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_applicationform_school` (`school_id`),
  CONSTRAINT `c_fk_applicationform_school_id` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
CREATE INDEX `index_applicationform_submitted` ON `applicationform`(`submitted`);
CREATE INDEX `index_applicationform_received_ts` ON `applicationform`(`received_ts`);

--
-- Dumping data for table `applicationform`
--

LOCK TABLES `applicationform` WRITE;
/*!40000 ALTER TABLE `applicationform` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicationform` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicationformitem`
--

DROP TABLE IF EXISTS `applicationformitem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applicationformitem` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `itemcategory_id` int(11) unsigned NOT NULL,
  `qty` int(11) unsigned NOT NULL,
  `qtyacquired` int(11) unsigned DEFAULT 0,
  `qtyreceived` int(11) unsigned DEFAULT 0,
  `reasons` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `applicationform_id` int(11) unsigned NOT NULL,
  `lab_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_applicationformitem_itemcategory` (`itemcategory_id`),
  KEY `index_foreignkey_applicationformitem_applicationform` (`applicationform_id`),
  KEY `index_foreignkey_applicationformitem_lab` (`lab_id`),
  CONSTRAINT `c_fk_applicationformitem_itemcategory_id` FOREIGN KEY (`itemcategory_id`) REFERENCES `itemcategory` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `c_fk_applicationformitem_applicationform_id` FOREIGN KEY (`applicationform_id`) REFERENCES `applicationform` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `c_fk_applicationformitem_lab_id` FOREIGN KEY (`lab_id`) REFERENCES `lab` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
--
-- Dumping data for table `applicationformitem`
--

LOCK TABLES `applicationformitem` WRITE;
/*!40000 ALTER TABLE `applicationformitem` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicationformitem` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
