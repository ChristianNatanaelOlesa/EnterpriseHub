-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: enterprisehub
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_07_08_085540_create_sc_role_table',1),(5,'2026_07_08_090115_create_sc_menu_table',1),(6,'2026_07_08_091215_create_sc_role_menu_table',1),(7,'2026_07_08_091900_create_sc_user_table',1),(8,'2026_07_29_093151_create_sc_user_role_table',1),(9,'2026_07_29_093217_create_sc_login_log_table',1),(10,'2026_07_29_095652_create_ms_company_table',1),(11,'2026_07_29_095655_create_ms_directorate_table',1),(12,'2026_07_29_095659_create_ms_division_table',1),(13,'2026_07_29_095702_create_ms_department_table',1),(14,'2026_07_29_100158_create_sc_user_comp_table',1),(15,'2026_07_29_100203_create_sc_user_dir_table',1),(16,'2026_07_29_100208_create_sc_user_div_table',1),(17,'2026_07_29_100212_create_sc_user_dept_table',1),(18,'2026_09_14_140152_create_wf_process_table',2),(19,'2026_09_14_140433_create_wf_process_dept_table',3),(20,'2026_09_14_140603_create_wf_group_table',4),(21,'2026_09_14_140711_create_wf_group_member_table',5),(22,'2026_09_14_140736_create_wf_action_table',6),(23,'2026_09_14_140835_create_wf_action_target_table',7),(24,'2026_09_14_141018_create_wf_state_table',8),(25,'2026_09_14_141117_create_wf_transition_table',9),(26,'2026_09_14_141139_create_wf_trans_action_table',10),(27,'2026_09_14_141359_alter_wf_action_to_match_master',11),(28,'2026_09_14_141428_alter_wf_trans_action_to_match_master',12),(29,'2026_09_14_144513_fix_wf_trans_action_transition_reference',13),(30,'2026_09_14_144804_fix_wf_transition_structure',14),(31,'2026_09_14_152617_create_tr_form_hco_req_table',15),(32,'2026_09_14_160552_create_tr_form_hco_action_table',16),(33,'2026_09_14_160624_create_tr_form_hco_file_table',17),(34,'2026_09_14_160650_create_tr_form_hco_note_table',18),(35,'2026_09_14_144453_fix_wf_transition_structure',19),(36,'2026_09_17_100902_create_tr_emp_form_table',19),(37,'2026_09_17_105336_create_ms_country_table',19),(38,'2026_09_17_105439_create_ms_province_table',19),(39,'2026_09_17_105742_create_ms_city_table',19),(40,'2026_09_17_105840_create_ms_district_table',19),(41,'2026_09_17_105959_create_ms_village_table',19),(42,'2026_09_17_110247_create_ms_religion_table',19);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_city`
--

DROP TABLE IF EXISTS `ms_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_city` (
  `CityID` varchar(10) NOT NULL,
  `ProvinceID` varchar(10) NOT NULL,
  `City` varchar(100) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `InputDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModifUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `ModifDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DeletedBy` varchar(50) DEFAULT NULL,
  `DeletedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`CityID`),
  KEY `ms_city_provinceid_index` (`ProvinceID`),
  KEY `ms_city_isactive_index` (`IsActive`),
  CONSTRAINT `ms_city_provinceid_foreign` FOREIGN KEY (`ProvinceID`) REFERENCES `ms_province` (`ProvinceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_city`
--

LOCK TABLES `ms_city` WRITE;
/*!40000 ALTER TABLE `ms_city` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_company`
--

DROP TABLE IF EXISTS `ms_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_company` (
  `CompanyID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CompanyCode` varchar(20) NOT NULL,
  `CompanyName` varchar(100) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Phone` varchar(30) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `InputDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModifUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `ModifDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DeletedBy` varchar(50) DEFAULT NULL,
  `DeletedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`CompanyID`),
  UNIQUE KEY `ms_company_companycode_unique` (`CompanyCode`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_company`
--

LOCK TABLES `ms_company` WRITE;
/*!40000 ALTER TABLE `ms_company` DISABLE KEYS */;
INSERT INTO `ms_company` VALUES (1,'HO','Head Office','Jakarta','021000000','admin@enterprisehub.local',1,'Admin','2026-08-04 03:46:30','Admin','2026-09-14 03:34:40',NULL,NULL);
/*!40000 ALTER TABLE `ms_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_country`
--

DROP TABLE IF EXISTS `ms_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_country` (
  `CountryID` varchar(3) NOT NULL,
  `Country` varchar(100) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `InputDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModifUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `ModifDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DeletedBy` varchar(50) DEFAULT NULL,
  `DeletedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`CountryID`),
  KEY `ms_country_isactive_index` (`IsActive`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_country`
--

LOCK TABLES `ms_country` WRITE;
/*!40000 ALTER TABLE `ms_country` DISABLE KEYS */;
INSERT INTO `ms_country` VALUES ('ABW','Aruba',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('AFG','Afghanistan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('AGO','Angola',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('AIA','Anguilla',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ALA','Åland Islands',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ALB','Albania',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('AND','Andorra',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ARE','United Arab Emirates',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ARG','Argentina',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ARM','Armenia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ASM','American Samoa',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ATA','Antarctica',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ATF','French Southern Territories',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ATG','Antigua and Barbuda',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('AUS','Australia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('AUT','Austria',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('AZE','Azerbaijan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BDI','Burundi',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BEL','Belgium',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BEN','Benin',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BES','Bonaire, Sint Eustatius and Saba',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BFA','Burkina Faso',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BGD','Bangladesh',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BGR','Bulgaria',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BHR','Bahrain',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BHS','Bahamas',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BIH','Bosnia and Herzegovina',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BLM','Saint Barthélemy',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BLR','Belarus',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BLZ','Belize',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BMU','Bermuda',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BOL','Bolivia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BRA','Brazil',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BRB','Barbados',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BRN','Brunei',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BTN','Bhutan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BVT','Bouvet Island',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('BWA','Botswana',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CAF','Central African Republic',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CAN','Canada',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CCK','Cocos (Keeling) Islands',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CHE','Switzerland',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CHL','Chile',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CHN','China',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CIV','Côte d\'Ivoire',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CMR','Cameroon',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('COD','Democratic Republic of the Congo',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('COG','Republic of the Congo',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('COK','Cook Islands',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('COL','Colombia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('COM','Comoros',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CPV','Cape Verde',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CRI','Costa Rica',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CUB','Cuba',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CUW','Curaçao',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CXR','Christmas Island',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CYM','Cayman Islands',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CYP','Cyprus',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('CZE','Czech Republic',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('DEU','Germany',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('DJI','Djibouti',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('DMA','Dominica',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('DNK','Denmark',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('DOM','Dominican Republic',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('DZA','Algeria',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ECU','Ecuador',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('EGY','Egypt',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ERI','Eritrea',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ESH','Western Sahara',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ESP','Spain',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('EST','Estonia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ETH','Ethiopia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('FIN','Finland',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('FJI','Fiji',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('FLK','Falkland Islands (Malvinas)',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('FRA','France',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('FRO','Faroe Islands',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('FSM','Micronesia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GAB','Gabon',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GBR','United Kingdom',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GEO','Georgia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GGY','Guernsey',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GHA','Ghana',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GIB','Gibraltar',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GIN','Guinea',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GLP','Guadeloupe',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GMB','Gambia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GNB','Guinea-Bissau',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GNQ','Equatorial Guinea',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GRC','Greece',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GRD','Grenada',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GRL','Greenland',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GTM','Guatemala',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GUF','French Guiana',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GUM','Guam',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('GUY','Guyana',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('HKG','Hong Kong',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('HMD','Heard Island and McDonald Islands',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('HND','Honduras',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('HRV','Croatia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('HTI','Haiti',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('HUN','Hungary',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('IDN','Indonesia',1,'1','2026-09-18 09:14:21','Admin','2026-09-18 09:14:21',NULL,NULL),('IMN','Isle of Man',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('IND','India',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('IOT','British Indian Ocean Territory',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('IRL','Ireland',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('IRN','Iran',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('IRQ','Iraq',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ISL','Iceland',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ISR','Israel',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ITA','Italy',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('JAM','Jamaica',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('JEY','Jersey',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('JOR','Jordan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('JPN','Japan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('KAZ','Kazakhstan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('KEN','Kenya',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('KGZ','Kyrgyzstan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('KHM','Cambodia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('KIR','Kiribati',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('KNA','Saint Kitts and Nevis',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('KOR','South Korea',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('KWT','Kuwait',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('LAO','Laos',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('LBN','Lebanon',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('LBR','Liberia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('LBY','Libya',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('LCA','Saint Lucia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('LIE','Liechtenstein',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('LKA','Sri Lanka',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('LSO','Lesotho',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('LTU','Lithuania',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('LUX','Luxembourg',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('LVA','Latvia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MAC','Macao',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MAF','Saint Martin (French part)',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MAR','Morocco',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MCO','Monaco',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MDA','Moldova',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MDG','Madagascar',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MDV','Maldives',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MEX','Mexico',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MHL','Marshall Islands',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MKD','North Macedonia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MLI','Mali',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MLT','Malta',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MMR','Myanmar',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MNE','Montenegro',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MNG','Mongolia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MNP','Northern Mariana Islands',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MOZ','Mozambique',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MRT','Mauritania',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MSR','Montserrat',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MTQ','Martinique',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MUS','Mauritius',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MWI','Malawi',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MYS','Malaysia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('MYT','Mayotte',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('NAM','Namibia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('NCL','New Caledonia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('NER','Niger',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('NFK','Norfolk Island',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('NGA','Nigeria',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('NIC','Nicaragua',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('NIU','Niue',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('NLD','Netherlands',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('NOR','Norway',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('NPL','Nepal',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('NRU','Nauru',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('NZL','New Zealand',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('OMN','Oman',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('PAK','Pakistan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('PAN','Panama',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('PCN','Pitcairn',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('PER','Peru',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('PHL','Philippines',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('PLW','Palau',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('PNG','Papua New Guinea',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('POL','Poland',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('PRI','Puerto Rico',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('PRK','North Korea',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('PRT','Portugal',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('PRY','Paraguay',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('PSE','Palestine',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('PYF','French Polynesia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('QAT','Qatar',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('REU','Réunion',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ROU','Romania',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('RUS','Russia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('RWA','Rwanda',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SAU','Saudi Arabia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SDN','Sudan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SEN','Senegal',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SGP','Singapore',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SGS','South Georgia and the South Sandwich Islands',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SHN','Saint Helena, Ascension and Tristan da Cunha',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SJM','Svalbard and Jan Mayen',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SLB','Solomon Islands',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SLE','Sierra Leone',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SLV','El Salvador',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SMR','San Marino',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SOM','Somalia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SPM','Saint Pierre and Miquelon',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SRB','Serbia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SSD','South Sudan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('STP','São Tomé and Príncipe',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SUR','Suriname',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SVK','Slovakia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SVN','Slovenia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SWE','Sweden',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SWZ','Eswatini',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SXM','Sint Maarten (Dutch part)',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SYC','Seychelles',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('SYR','Syria',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TCA','Turks and Caicos Islands',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TCD','Chad',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TGO','Togo',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('THA','Thailand',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TJK','Tajikistan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TKL','Tokelau',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TKM','Turkmenistan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TLS','Timor-Leste',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TON','Tonga',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TTO','Trinidad and Tobago',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TUN','Tunisia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TUR','Turkey',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TUV','Tuvalu',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TWN','Taiwan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('TZA','Tanzania',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('UGA','Uganda',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('UKR','Ukraine',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('UMI','United States Minor Outlying Islands',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('URY','Uruguay',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('USA','United States',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('UZB','Uzbekistan',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('VAT','Vatican City',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('VCT','Saint Vincent and the Grenadines',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('VEN','Venezuela',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('VGB','Virgin Islands, British',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('VIR','Virgin Islands, U.S.',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('VNM','Vietnam',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('VUT','Vanuatu',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('WLF','Wallis and Futuna',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('WSM','Samoa',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('YEM','Yemen',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ZAF','South Africa',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ZMB','Zambia',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL),('ZWE','Zimbabwe',1,'Admin','2026-09-18 09:18:44','Admin','2026-09-18 09:18:44',NULL,NULL);
/*!40000 ALTER TABLE `ms_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_department`
--

DROP TABLE IF EXISTS `ms_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_department` (
  `DepartmentID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `DivisionID` bigint(20) unsigned NOT NULL,
  `DepartmentCode` varchar(20) NOT NULL,
  `DepartmentName` varchar(200) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `InputDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModifUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `ModifDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DeletedBy` varchar(50) DEFAULT NULL,
  `DeletedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`DepartmentID`),
  KEY `ms_department_divisionid_foreign` (`DivisionID`),
  CONSTRAINT `ms_department_divisionid_foreign` FOREIGN KEY (`DivisionID`) REFERENCES `ms_division` (`DivisionID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_department`
--

LOCK TABLES `ms_department` WRITE;
/*!40000 ALTER TABLE `ms_department` DISABLE KEYS */;
INSERT INTO `ms_department` VALUES (2,2,'ITS','IT Services',1,'Admin','2026-09-14 04:32:46','Admin','2026-09-17 07:22:19',NULL,NULL);
/*!40000 ALTER TABLE `ms_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_directorate`
--

DROP TABLE IF EXISTS `ms_directorate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_directorate` (
  `DirectorateID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CompanyID` bigint(20) unsigned NOT NULL,
  `DirectorateCode` varchar(20) NOT NULL,
  `DirectorateName` varchar(200) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `InputDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModifUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `ModifDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DeletedBy` varchar(50) DEFAULT NULL,
  `DeletedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`DirectorateID`),
  KEY `ms_directorate_companyid_foreign` (`CompanyID`),
  CONSTRAINT `ms_directorate_companyid_foreign` FOREIGN KEY (`CompanyID`) REFERENCES `ms_company` (`CompanyID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_directorate`
--

LOCK TABLES `ms_directorate` WRITE;
/*!40000 ALTER TABLE `ms_directorate` DISABLE KEYS */;
INSERT INTO `ms_directorate` VALUES (2,1,'SUP','Finance',1,'Admin','2026-09-14 04:17:14','Admin','2026-09-17 07:23:08',NULL,NULL);
/*!40000 ALTER TABLE `ms_directorate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_district`
--

DROP TABLE IF EXISTS `ms_district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_district` (
  `DistrictID` varchar(10) NOT NULL,
  `CityID` varchar(10) NOT NULL,
  `District` varchar(100) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `InputDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModifUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `ModifDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DeletedBy` varchar(50) DEFAULT NULL,
  `DeletedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`DistrictID`),
  KEY `ms_district_cityid_index` (`CityID`),
  KEY `ms_district_isactive_index` (`IsActive`),
  CONSTRAINT `ms_district_cityid_foreign` FOREIGN KEY (`CityID`) REFERENCES `ms_city` (`CityID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_district`
--

LOCK TABLES `ms_district` WRITE;
/*!40000 ALTER TABLE `ms_district` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_district` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_division`
--

DROP TABLE IF EXISTS `ms_division`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_division` (
  `DivisionID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `DirectorateID` bigint(20) unsigned NOT NULL,
  `DivisionCode` varchar(20) NOT NULL,
  `DivisionName` varchar(200) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `InputDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModifUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `ModifDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DeletedBy` varchar(50) DEFAULT NULL,
  `DeletedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`DivisionID`),
  KEY `ms_division_directorateid_foreign` (`DirectorateID`),
  CONSTRAINT `ms_division_directorateid_foreign` FOREIGN KEY (`DirectorateID`) REFERENCES `ms_directorate` (`DirectorateID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_division`
--

LOCK TABLES `ms_division` WRITE;
/*!40000 ALTER TABLE `ms_division` DISABLE KEYS */;
INSERT INTO `ms_division` VALUES (2,2,'INT','Information Technology',1,'Admin','2026-09-14 04:18:43','Admin','2026-09-17 07:23:46',NULL,NULL);
/*!40000 ALTER TABLE `ms_division` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_province`
--

DROP TABLE IF EXISTS `ms_province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_province` (
  `ProvinceID` varchar(10) NOT NULL,
  `CountryID` varchar(3) NOT NULL,
  `Province` varchar(100) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `InputDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModifUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `ModifDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DeletedBy` varchar(50) DEFAULT NULL,
  `DeletedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ProvinceID`),
  KEY `ms_province_countryid_index` (`CountryID`),
  KEY `ms_province_isactive_index` (`IsActive`),
  CONSTRAINT `ms_province_countryid_foreign` FOREIGN KEY (`CountryID`) REFERENCES `ms_country` (`CountryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_province`
--

LOCK TABLES `ms_province` WRITE;
/*!40000 ALTER TABLE `ms_province` DISABLE KEYS */;
INSERT INTO `ms_province` VALUES ('ID-AC','IDN','Aceh',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-BA','IDN','Bali',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-BB','IDN','Kepulauan Bangka Belitung',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-BE','IDN','Bengkulu',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-BT','IDN','Banten',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-GO','IDN','Gorontalo',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-JA','IDN','Jambi',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-JB','IDN','Jawa Barat',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-JI','IDN','Jawa Timur',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-JK','IDN','DKI Jakarta',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-JT','IDN','Jawa Tengah',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-KB','IDN','Kalimantan Barat',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-KI','IDN','Kalimantan Timur',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-KR','IDN','Kepulauan Riau',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-KS','IDN','Kalimantan Selatan',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-KT','IDN','Kalimantan Tengah',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-KU','IDN','Kalimantan Utara',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-LA','IDN','Lampung',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-MA','IDN','Maluku',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-MU','IDN','Maluku Utara',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-NB','IDN','Nusa Tenggara Barat',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-NT','IDN','Nusa Tenggara Timur',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-PA','IDN','Papua',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-PB','IDN','Papua Barat',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-PD','IDN','Papua Barat Daya',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-PE','IDN','Papua Tengah',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-PS','IDN','Papua Selatan',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-PT','IDN','Papua Pegunungan',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-RI','IDN','Riau',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-SA','IDN','Sulawesi Utara',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-SB','IDN','Sumatera Barat',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-SG','IDN','Sulawesi Tenggara',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-SM','IDN','Sumatera Selatan',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-SN','IDN','Sulawesi Selatan',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-SR','IDN','Sulawesi Barat',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-ST','IDN','Sulawesi Tengah',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-SU','IDN','Sumatera Utara',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL),('ID-YO','IDN','DI Yogyakarta',1,'Admin','2026-09-18 09:58:56','Admin','2026-09-18 09:58:56',NULL,NULL);
/*!40000 ALTER TABLE `ms_province` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_religion`
--

DROP TABLE IF EXISTS `ms_religion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_religion` (
  `ReligionID` varchar(3) NOT NULL,
  `Religion` varchar(100) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `InputDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModifUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `ModifDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DeletedBy` varchar(50) DEFAULT NULL,
  `DeletedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ReligionID`),
  KEY `ms_religion_isactive_index` (`IsActive`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_religion`
--

LOCK TABLES `ms_religion` WRITE;
/*!40000 ALTER TABLE `ms_religion` DISABLE KEYS */;
INSERT INTO `ms_religion` VALUES ('BDH','Buddha',1,'Admin','2026-09-17 06:17:30','Admin','2026-09-17 07:24:41',NULL,NULL),('CAT','Katolik',1,'Admin','2026-09-17 06:26:04','Admin','2026-09-17 07:24:41',NULL,NULL),('CHR','Kristen',1,'Admin','2026-09-17 06:17:04','Admin','2026-09-17 07:24:41',NULL,NULL),('HIN','Hindu',1,'Admin','2026-09-17 06:25:23','Admin','2026-09-17 07:24:41',NULL,NULL),('ISL','Islam',1,'Admin','2026-09-17 06:17:17','Admin','2026-09-17 07:24:41',NULL,NULL),('UNK','Unknown',1,'Admin','2026-09-17 06:26:22','Admin','2026-09-17 07:24:41',NULL,NULL);
/*!40000 ALTER TABLE `ms_religion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ms_village`
--

DROP TABLE IF EXISTS `ms_village`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ms_village` (
  `VillageID` int(10) unsigned NOT NULL,
  `DistrictID` varchar(10) NOT NULL,
  `Village` varchar(100) NOT NULL,
  `PostalCode` varchar(10) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `InputDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModifUser` varchar(50) NOT NULL DEFAULT 'Admin',
  `ModifDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DeletedBy` varchar(50) DEFAULT NULL,
  `DeletedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`VillageID`),
  KEY `ms_village_districtid_index` (`DistrictID`),
  KEY `ms_village_postalcode_index` (`PostalCode`),
  KEY `ms_village_isactive_index` (`IsActive`),
  CONSTRAINT `ms_village_districtid_foreign` FOREIGN KEY (`DistrictID`) REFERENCES `ms_district` (`DistrictID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ms_village`
--

LOCK TABLES `ms_village` WRITE;
/*!40000 ALTER TABLE `ms_village` DISABLE KEYS */;
/*!40000 ALTER TABLE `ms_village` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_login_log`
--

DROP TABLE IF EXISTS `sc_login_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_login_log` (
  `LoginLogID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` bigint(20) unsigned NOT NULL,
  `IPAddress` varchar(45) NOT NULL,
  `Browser` varchar(100) DEFAULT NULL,
  `Platform` varchar(100) DEFAULT NULL,
  `LoginDate` datetime NOT NULL DEFAULT current_timestamp(),
  `LogoutDate` datetime DEFAULT NULL,
  `IsSuccess` tinyint(1) NOT NULL DEFAULT 1,
  `Remarks` text DEFAULT NULL,
  `CreatedBy` bigint(20) unsigned DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` bigint(20) unsigned DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` bigint(20) unsigned DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`LoginLogID`),
  KEY `sc_login_log_userid_index` (`UserID`),
  KEY `sc_login_log_logindate_index` (`LoginDate`),
  CONSTRAINT `sc_login_log_userid_foreign` FOREIGN KEY (`UserID`) REFERENCES `sc_user` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_login_log`
--

LOCK TABLES `sc_login_log` WRITE;
/*!40000 ALTER TABLE `sc_login_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `sc_login_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_menu`
--

DROP TABLE IF EXISTS `sc_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_menu` (
  `MenuID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ParentID` bigint(20) unsigned DEFAULT NULL,
  `Code` varchar(30) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Route` varchar(255) DEFAULT NULL,
  `URL` varchar(255) DEFAULT NULL,
  `Icon` varchar(100) DEFAULT NULL,
  `SortOrder` int(11) NOT NULL DEFAULT 0,
  `IsMenu` tinyint(1) NOT NULL DEFAULT 1,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedBy` bigint(20) unsigned DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` bigint(20) unsigned DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` bigint(20) unsigned DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`MenuID`),
  UNIQUE KEY `sc_menu_code_unique` (`Code`),
  KEY `sc_menu_parentid_index` (`ParentID`),
  KEY `sc_menu_code_index` (`Code`),
  KEY `sc_menu_isactive_index` (`IsActive`),
  KEY `sc_menu_sortorder_index` (`SortOrder`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_menu`
--

LOCK TABLES `sc_menu` WRITE;
/*!40000 ALTER TABLE `sc_menu` DISABLE KEYS */;
INSERT INTO `sc_menu` VALUES (1,NULL,'DASHBOARD','Dashboard','dashboard',NULL,'bi bi-speedometer2',1,1,1,NULL,'2026-08-14 11:16:00',NULL,'2026-09-17 13:44:22',NULL,NULL),(2,NULL,'MASTER','Master',NULL,NULL,'bi bi-database',10,1,1,NULL,'2026-08-14 11:16:00',NULL,'2026-09-17 13:44:22',NULL,NULL),(3,2,'MASTER_COMPANY','Company','master.company.index',NULL,'bi bi-building',11,1,1,NULL,'2026-08-14 11:16:00',NULL,'2026-09-17 13:44:22',NULL,NULL),(4,NULL,'SECURITY','Security',NULL,NULL,'bi bi-shield-lock',20,1,1,NULL,'2026-08-14 11:16:00',NULL,'2026-09-17 13:44:22',NULL,NULL),(5,4,'SECURITY_USERS','Users','security.users.index',NULL,'bi bi-people',21,1,1,NULL,'2026-08-14 11:16:00',NULL,'2026-09-17 13:44:22',NULL,NULL),(6,4,'SECURITY_ROLES','Roles','security.roles.index',NULL,'bi bi-person-badge',22,1,1,NULL,'2026-08-14 11:16:00',NULL,'2026-09-17 13:44:22',NULL,NULL),(7,4,'SECURITY_MENUS','Menus','security.menus.index',NULL,'bi bi-list',23,1,1,NULL,'2026-08-14 11:16:00',NULL,'2026-09-17 13:44:22',NULL,NULL),(8,2,'MASTER_DIRECTORATE','Directorate','master.directorate.index',NULL,'bi bi-diagram-3',13,1,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-17 13:44:22',NULL,NULL),(9,2,'MASTER_DIVISION','Division','master.division.index',NULL,'bi bi-diagram-2',14,1,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-17 13:44:22',NULL,NULL),(10,2,'MASTER_DEPARTMENT','Department','master.department.index',NULL,'bi bi-building-gear',15,1,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-17 13:44:22',NULL,NULL),(11,2,'MASTER_RELIGION','Religion','master.religion.index',NULL,'bi bi-person-heart',12,1,1,NULL,'2026-09-17 11:25:20',NULL,'2026-09-17 13:44:22',NULL,NULL),(12,2,'MASTER_COUNTRY','Country','master.country.index',NULL,'bi bi-globe2',12,1,1,NULL,'2026-09-17 12:21:57',NULL,'2026-09-17 13:44:22',NULL,NULL),(13,2,'MASTER_PROVINCE','Province','master.province.index',NULL,'bi bi-globe2',12,1,1,NULL,'2026-09-17 13:44:22',NULL,'2026-09-17 13:44:22',NULL,NULL);
/*!40000 ALTER TABLE `sc_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_role`
--

DROP TABLE IF EXISTS `sc_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_role` (
  `RoleID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Code` varchar(30) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedBy` bigint(20) unsigned DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` bigint(20) unsigned DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` bigint(20) unsigned DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`RoleID`),
  UNIQUE KEY `sc_role_code_unique` (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_role`
--

LOCK TABLES `sc_role` WRITE;
/*!40000 ALTER TABLE `sc_role` DISABLE KEYS */;
INSERT INTO `sc_role` VALUES (1,'SCR','Security Test','Security Test',0,1,'2026-08-04 14:31:03',1,'2026-08-04 14:45:30',1,'2026-08-04 14:45:35'),(2,'ADMIN','Administrator','System Administrator',1,1,'2026-08-04 14:32:52',1,'2026-08-14 11:35:15',NULL,NULL),(3,'SUPERADMIN','Super Administrator','Full access to all modules and features.',1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-14 10:34:40',NULL,NULL),(4,'TEST','Test Role','Testing Permission',1,1,'2026-09-14 13:26:03',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `sc_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_role_menu`
--

DROP TABLE IF EXISTS `sc_role_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_role_menu` (
  `RoleMenuID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `RoleID` bigint(20) unsigned NOT NULL,
  `MenuID` bigint(20) unsigned NOT NULL,
  `CanOpen` tinyint(1) NOT NULL DEFAULT 0,
  `CanAdd` tinyint(1) NOT NULL DEFAULT 0,
  `CanEdit` tinyint(1) NOT NULL DEFAULT 0,
  `CanDelete` tinyint(1) NOT NULL DEFAULT 0,
  `CanPrint` tinyint(1) NOT NULL DEFAULT 0,
  `CanExport` tinyint(1) NOT NULL DEFAULT 0,
  `CanApprove` tinyint(1) NOT NULL DEFAULT 0,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedBy` bigint(20) unsigned DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` bigint(20) unsigned DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` bigint(20) unsigned DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`RoleMenuID`),
  UNIQUE KEY `sc_role_menu_roleid_menuid_unique` (`RoleID`,`MenuID`),
  KEY `sc_role_menu_roleid_index` (`RoleID`),
  KEY `sc_role_menu_menuid_index` (`MenuID`),
  KEY `sc_role_menu_isactive_index` (`IsActive`),
  CONSTRAINT `sc_role_menu_menuid_foreign` FOREIGN KEY (`MenuID`) REFERENCES `sc_menu` (`MenuID`),
  CONSTRAINT `sc_role_menu_roleid_foreign` FOREIGN KEY (`RoleID`) REFERENCES `sc_role` (`RoleID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_role_menu`
--

LOCK TABLES `sc_role_menu` WRITE;
/*!40000 ALTER TABLE `sc_role_menu` DISABLE KEYS */;
INSERT INTO `sc_role_menu` VALUES (1,2,2,1,1,1,1,0,0,0,1,NULL,'2026-08-14 11:35:15',1,'2026-08-14 11:35:15',NULL,NULL),(2,2,5,1,1,1,1,0,0,0,1,NULL,'2026-08-14 11:35:15',1,'2026-08-14 11:35:15',NULL,NULL),(3,2,6,1,1,1,1,0,0,0,1,NULL,'2026-08-14 11:35:15',1,'2026-08-14 11:35:15',NULL,NULL),(4,2,7,1,1,1,1,0,0,0,1,NULL,'2026-08-14 11:35:15',1,'2026-08-14 11:35:15',NULL,NULL),(5,3,1,1,1,1,1,1,1,1,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-17 13:44:26',NULL,NULL),(6,3,2,1,1,1,1,1,1,1,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-17 13:44:26',NULL,NULL),(7,3,3,1,1,1,1,1,1,1,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-17 13:44:26',NULL,NULL),(8,3,4,1,1,1,1,1,1,1,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-17 13:44:26',NULL,NULL),(9,3,5,1,1,1,1,1,1,1,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-17 13:44:26',NULL,NULL),(10,3,6,1,1,1,1,1,1,1,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-17 13:44:26',NULL,NULL),(11,3,7,1,1,1,1,1,1,1,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-17 13:44:26',NULL,NULL),(12,3,8,1,1,1,1,1,1,1,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-17 13:44:26',NULL,NULL),(13,3,9,1,1,1,1,1,1,1,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-17 13:44:26',NULL,NULL),(14,3,10,1,1,1,1,1,1,1,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-17 13:44:26',NULL,NULL),(15,4,3,1,0,0,0,0,0,0,1,1,'2026-09-14 13:26:03',1,'2026-09-14 13:26:03',NULL,NULL),(16,3,11,1,1,1,1,1,1,1,1,NULL,'2026-09-17 11:25:26',NULL,'2026-09-17 13:44:26',NULL,NULL),(17,3,12,1,1,1,1,1,1,1,1,NULL,'2026-09-17 12:22:01',NULL,'2026-09-17 13:44:26',NULL,NULL),(18,3,13,1,1,1,1,1,1,1,1,NULL,'2026-09-17 13:44:26',NULL,'2026-09-17 13:44:26',NULL,NULL);
/*!40000 ALTER TABLE `sc_role_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_user`
--

DROP TABLE IF EXISTS `sc_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_user` (
  `UserID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `RoleID` bigint(20) unsigned DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `PhoneNumber` varchar(30) DEFAULT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `LastLogin` datetime DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedBy` bigint(20) unsigned DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` bigint(20) unsigned DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` bigint(20) unsigned DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `sc_user_username_unique` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_user`
--

LOCK TABLES `sc_user` WRITE;
/*!40000 ALTER TABLE `sc_user` DISABLE KEYS */;
INSERT INTO `sc_user` VALUES (1,'admin','Administrator','$2y$12$5KkzZQ6UqtN8N1YI8BNj3Ohd/w7vUBy0K3t8XeIzuLoNP//cg8dmy',1,'administrator@enterprisehub.com','123456789',NULL,NULL,1,NULL,'2026-08-04 10:46:30',1,'2026-09-14 10:34:40',NULL,NULL),(2,'testUser','Test User','$2y$12$QYklSilx0aTBdfktJlvnreITMrER9GlxdH9BAXMh7dTXVBCduW9KO',1,'test@test.com','08123456789',NULL,NULL,1,1,'2026-08-04 11:34:40',1,'2026-09-14 13:32:43',NULL,NULL),(3,'userdelete','User Delete','$2y$12$r2qq.kus2547rMGqtDkZH.qXyOeNxD.54I1o8Cvp6XWRx2kb/v9wG',1,'user@delete.com','0123456789',NULL,NULL,0,1,'2026-08-04 13:30:03',NULL,NULL,1,'2026-08-04 13:30:12'),(4,'userReset1','User Reset 1','$2y$12$zHz.DccVUZu8dLMAJtMnk.S08zzwjN7fmDgRa2cOfSBB67e/b9dWu',1,'user@reset.com','0321654987',NULL,NULL,1,1,'2026-08-04 13:35:01',1,'2026-08-04 14:14:37',NULL,NULL),(5,'Christian','Christian Natanael Olesa','$2y$12$VrB3Lw/xuS9EnTdKln8FeeDYobnKwjambg7p2an1VN2TC0bT0TfWC',NULL,'cnatanael96@gmail.com','085894453547',NULL,NULL,1,1,'2026-09-14 15:08:59',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `sc_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_user_comp`
--

DROP TABLE IF EXISTS `sc_user_comp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_user_comp` (
  `UserCompID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` bigint(20) unsigned NOT NULL,
  `CompanyID` bigint(20) unsigned NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedBy` bigint(20) unsigned DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` bigint(20) unsigned DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` bigint(20) unsigned DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`UserCompID`),
  UNIQUE KEY `sc_user_comp_userid_companyid_unique` (`UserID`,`CompanyID`),
  KEY `sc_user_comp_userid_index` (`UserID`),
  KEY `sc_user_comp_companyid_index` (`CompanyID`),
  KEY `sc_user_comp_isactive_index` (`IsActive`),
  CONSTRAINT `sc_user_comp_companyid_foreign` FOREIGN KEY (`CompanyID`) REFERENCES `ms_company` (`CompanyID`),
  CONSTRAINT `sc_user_comp_userid_foreign` FOREIGN KEY (`UserID`) REFERENCES `sc_user` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_user_comp`
--

LOCK TABLES `sc_user_comp` WRITE;
/*!40000 ALTER TABLE `sc_user_comp` DISABLE KEYS */;
/*!40000 ALTER TABLE `sc_user_comp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_user_dept`
--

DROP TABLE IF EXISTS `sc_user_dept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_user_dept` (
  `UserDeptID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` bigint(20) unsigned NOT NULL,
  `DepartmentID` bigint(20) unsigned NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedBy` bigint(20) unsigned DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` bigint(20) unsigned DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` bigint(20) unsigned DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`UserDeptID`),
  UNIQUE KEY `sc_user_dept_userid_departmentid_unique` (`UserID`,`DepartmentID`),
  KEY `sc_user_dept_userid_index` (`UserID`),
  KEY `sc_user_dept_departmentid_index` (`DepartmentID`),
  KEY `sc_user_dept_isactive_index` (`IsActive`),
  CONSTRAINT `sc_user_dept_departmentid_foreign` FOREIGN KEY (`DepartmentID`) REFERENCES `ms_department` (`DepartmentID`),
  CONSTRAINT `sc_user_dept_userid_foreign` FOREIGN KEY (`UserID`) REFERENCES `sc_user` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_user_dept`
--

LOCK TABLES `sc_user_dept` WRITE;
/*!40000 ALTER TABLE `sc_user_dept` DISABLE KEYS */;
/*!40000 ALTER TABLE `sc_user_dept` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_user_dir`
--

DROP TABLE IF EXISTS `sc_user_dir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_user_dir` (
  `UserDirID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` bigint(20) unsigned NOT NULL,
  `DirectorateID` bigint(20) unsigned NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedBy` bigint(20) unsigned DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` bigint(20) unsigned DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` bigint(20) unsigned DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`UserDirID`),
  UNIQUE KEY `sc_user_dir_userid_directorateid_unique` (`UserID`,`DirectorateID`),
  KEY `sc_user_dir_userid_index` (`UserID`),
  KEY `sc_user_dir_directorateid_index` (`DirectorateID`),
  KEY `sc_user_dir_isactive_index` (`IsActive`),
  CONSTRAINT `sc_user_dir_directorateid_foreign` FOREIGN KEY (`DirectorateID`) REFERENCES `ms_directorate` (`DirectorateID`),
  CONSTRAINT `sc_user_dir_userid_foreign` FOREIGN KEY (`UserID`) REFERENCES `sc_user` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_user_dir`
--

LOCK TABLES `sc_user_dir` WRITE;
/*!40000 ALTER TABLE `sc_user_dir` DISABLE KEYS */;
/*!40000 ALTER TABLE `sc_user_dir` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_user_div`
--

DROP TABLE IF EXISTS `sc_user_div`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_user_div` (
  `UserDivID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` bigint(20) unsigned NOT NULL,
  `DivisionID` bigint(20) unsigned NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedBy` bigint(20) unsigned DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` bigint(20) unsigned DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` bigint(20) unsigned DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`UserDivID`),
  UNIQUE KEY `sc_user_div_userid_divisionid_unique` (`UserID`,`DivisionID`),
  KEY `sc_user_div_userid_index` (`UserID`),
  KEY `sc_user_div_divisionid_index` (`DivisionID`),
  KEY `sc_user_div_isactive_index` (`IsActive`),
  CONSTRAINT `sc_user_div_divisionid_foreign` FOREIGN KEY (`DivisionID`) REFERENCES `ms_division` (`DivisionID`),
  CONSTRAINT `sc_user_div_userid_foreign` FOREIGN KEY (`UserID`) REFERENCES `sc_user` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_user_div`
--

LOCK TABLES `sc_user_div` WRITE;
/*!40000 ALTER TABLE `sc_user_div` DISABLE KEYS */;
/*!40000 ALTER TABLE `sc_user_div` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_user_role`
--

DROP TABLE IF EXISTS `sc_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_user_role` (
  `UserRoleID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `UserID` bigint(20) unsigned NOT NULL,
  `RoleID` bigint(20) unsigned NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedBy` bigint(20) unsigned DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedBy` bigint(20) unsigned DEFAULT NULL,
  `UpdatedDate` datetime DEFAULT NULL,
  `DeletedBy` bigint(20) unsigned DEFAULT NULL,
  `DeletedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`UserRoleID`),
  UNIQUE KEY `sc_user_role_userid_roleid_unique` (`UserID`,`RoleID`),
  KEY `sc_user_role_userid_index` (`UserID`),
  KEY `sc_user_role_roleid_index` (`RoleID`),
  KEY `sc_user_role_isactive_index` (`IsActive`),
  CONSTRAINT `sc_user_role_roleid_foreign` FOREIGN KEY (`RoleID`) REFERENCES `sc_role` (`RoleID`),
  CONSTRAINT `sc_user_role_userid_foreign` FOREIGN KEY (`UserID`) REFERENCES `sc_user` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_user_role`
--

LOCK TABLES `sc_user_role` WRITE;
/*!40000 ALTER TABLE `sc_user_role` DISABLE KEYS */;
INSERT INTO `sc_user_role` VALUES (1,1,3,1,NULL,'2026-09-14 10:33:51',NULL,'2026-09-14 10:34:40',NULL,NULL),(2,2,4,1,1,'2026-09-14 13:32:32',1,'2026-09-14 13:32:32',NULL,NULL),(3,5,3,1,1,'2026-09-14 15:08:59',1,'2026-09-14 15:08:59',NULL,NULL);
/*!40000 ALTER TABLE `sc_user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_empform`
--

DROP TABLE IF EXISTS `tr_empform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_empform` (
  `EmpFormID` varchar(13) NOT NULL,
  `FirstName` varchar(300) NOT NULL,
  `LastName` varchar(300) DEFAULT NULL,
  `MobileNo` varchar(30) DEFAULT NULL,
  `BirthDate` date DEFAULT NULL,
  `NIP` varchar(30) DEFAULT NULL,
  `MaritalStatus` varchar(1) DEFAULT NULL,
  `ReligionID` varchar(3) DEFAULT NULL,
  `JoinDate` date DEFAULT NULL,
  `VillageID` int(10) unsigned DEFAULT NULL,
  `Address` varchar(1000) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `InputDate` datetime DEFAULT NULL,
  `InputUser` varchar(50) DEFAULT NULL,
  `ModifDate` datetime DEFAULT NULL,
  `ModifUser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`EmpFormID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_empform`
--

LOCK TABLES `tr_empform` WRITE;
/*!40000 ALTER TABLE `tr_empform` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_empform` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_form_hco_action`
--

DROP TABLE IF EXISTS `tr_form_hco_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_form_hco_action` (
  `FormHCOActionID` varchar(15) NOT NULL,
  `FormHCOReqID` varchar(12) NOT NULL,
  `ActionID` varchar(12) NOT NULL,
  `TransitionID` varchar(22) NOT NULL,
  `Comments` varchar(500) NOT NULL,
  `IsActive` tinyint(1) DEFAULT NULL,
  `IsComplete` tinyint(1) DEFAULT NULL,
  `CompletedBy` varchar(50) DEFAULT NULL,
  `DueDateOrg` date NOT NULL,
  `DueDate` date NOT NULL,
  `ApvDate` date NOT NULL,
  `QRCodeLoc` varchar(200) DEFAULT NULL,
  `Keys` varchar(5) DEFAULT NULL,
  `EncryptQRCode` varchar(500) DEFAULT NULL,
  `InputDate` datetime DEFAULT NULL,
  `InputUser` varchar(50) DEFAULT NULL,
  `ModifDate` datetime DEFAULT NULL,
  `ModifUser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`FormHCOActionID`),
  KEY `tr_form_hco_action_formhcoreqid_index` (`FormHCOReqID`),
  KEY `tr_form_hco_action_actionid_index` (`ActionID`),
  KEY `tr_form_hco_action_transitionid_index` (`TransitionID`),
  KEY `tr_form_hco_action_completedby_index` (`CompletedBy`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_form_hco_action`
--

LOCK TABLES `tr_form_hco_action` WRITE;
/*!40000 ALTER TABLE `tr_form_hco_action` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_form_hco_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_form_hco_file`
--

DROP TABLE IF EXISTS `tr_form_hco_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_form_hco_file` (
  `FormHCOFileID` varchar(16) NOT NULL,
  `FormHCOReqID` varchar(13) NOT NULL,
  `FolderPathID` int(11) NOT NULL,
  `UserID` varchar(3) NOT NULL,
  `UploadDate` date NOT NULL,
  `FileName` varchar(500) NOT NULL,
  `ExtID` smallint(6) NOT NULL,
  `FileSize` double NOT NULL,
  `Remarks` varchar(500) NOT NULL,
  `GDriveID` varchar(300) NOT NULL,
  `UrlPath` varchar(300) NOT NULL,
  `InputDate` datetime NOT NULL,
  `InputUser` varchar(50) NOT NULL,
  `ModifDate` datetime NOT NULL,
  `ModifUser` varchar(50) NOT NULL,
  PRIMARY KEY (`FormHCOFileID`),
  KEY `tr_form_hco_file_formhcoreqid_index` (`FormHCOReqID`),
  KEY `tr_form_hco_file_userid_index` (`UserID`),
  KEY `tr_form_hco_file_folderpathid_index` (`FolderPathID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_form_hco_file`
--

LOCK TABLES `tr_form_hco_file` WRITE;
/*!40000 ALTER TABLE `tr_form_hco_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_form_hco_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_form_hco_note`
--

DROP TABLE IF EXISTS `tr_form_hco_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_form_hco_note` (
  `FormHCONoteID` varchar(16) NOT NULL,
  `FormHCOReqID` varchar(13) NOT NULL,
  `ActionTypeID` varchar(3) NOT NULL,
  `UserID` varchar(3) NOT NULL,
  `Notes` varchar(3000) NOT NULL,
  `InputDate` datetime DEFAULT NULL,
  `InputUser` varchar(50) DEFAULT NULL,
  `ModifDate` datetime DEFAULT NULL,
  `ModifUser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`FormHCONoteID`),
  KEY `tr_form_hco_note_formhcoreqid_index` (`FormHCOReqID`),
  KEY `tr_form_hco_note_actiontypeid_index` (`ActionTypeID`),
  KEY `tr_form_hco_note_userid_index` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_form_hco_note`
--

LOCK TABLES `tr_form_hco_note` WRITE;
/*!40000 ALTER TABLE `tr_form_hco_note` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_form_hco_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_form_hco_req`
--

DROP TABLE IF EXISTS `tr_form_hco_req`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_form_hco_req` (
  `FormHCOReqID` varchar(12) NOT NULL,
  `CategoryHCID` varchar(5) NOT NULL,
  `ReqDivID` varchar(3) DEFAULT NULL,
  `PayReqID` varchar(18) DEFAULT NULL,
  `CBTransType` varchar(1) NOT NULL,
  `BankID` varchar(4) NOT NULL,
  `RefAccNo` varchar(50) NOT NULL,
  `RefAccName` varchar(500) NOT NULL,
  `PaidTo` varchar(500) NOT NULL,
  `ReqUser` varchar(50) DEFAULT NULL,
  `RequestDate` date NOT NULL,
  `EFAType` varchar(200) DEFAULT NULL,
  `Purpose` varchar(500) DEFAULT NULL,
  `Relation` varchar(20) DEFAULT NULL,
  `GlassesType` varchar(100) DEFAULT NULL,
  `TotalCost` decimal(18,2) NOT NULL DEFAULT 0.00,
  `ParkingType` varchar(50) DEFAULT NULL,
  `PlateNo` varchar(10) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `BirthPlace` varchar(100) DEFAULT NULL,
  `BirthDate` date NOT NULL,
  `Education` varchar(50) DEFAULT NULL,
  `EduLevel` varchar(50) DEFAULT NULL,
  `SchoolName` varchar(200) DEFAULT NULL,
  `LeaveYear` varchar(4) DEFAULT NULL,
  `LeaveTotal` smallint(6) DEFAULT NULL,
  `LeaveNote` varchar(3000) DEFAULT NULL,
  `Status` varchar(10) DEFAULT NULL,
  `UserID` varchar(3) DEFAULT NULL,
  `ProcessID` varchar(9) DEFAULT NULL,
  `CurrentStateID` varchar(11) DEFAULT NULL,
  `InputDate` datetime DEFAULT NULL,
  `InputUser` varchar(50) DEFAULT NULL,
  `ModifDate` datetime DEFAULT NULL,
  `ModifUser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`FormHCOReqID`),
  KEY `tr_form_hco_req_categoryhcid_index` (`CategoryHCID`),
  KEY `tr_form_hco_req_requser_index` (`ReqUser`),
  KEY `tr_form_hco_req_payreqid_index` (`PayReqID`),
  KEY `tr_form_hco_req_userid_index` (`UserID`),
  KEY `tr_form_hco_req_processid_index` (`ProcessID`),
  KEY `tr_form_hco_req_currentstateid_index` (`CurrentStateID`),
  KEY `tr_form_hco_req_status_index` (`Status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_form_hco_req`
--

LOCK TABLES `tr_form_hco_req` WRITE;
/*!40000 ALTER TABLE `tr_form_hco_req` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_form_hco_req` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wf_action`
--

DROP TABLE IF EXISTS `wf_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wf_action` (
  `ActionID` varchar(50) NOT NULL,
  `Keterangan` text DEFAULT NULL,
  `ProcessID` varchar(50) NOT NULL,
  `ActionTypeID` varchar(20) DEFAULT NULL,
  `Action` varchar(255) NOT NULL,
  `ActionDesc` text DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputDate` datetime DEFAULT NULL,
  `InputUser` varchar(100) DEFAULT NULL,
  `ModifDate` datetime DEFAULT NULL,
  `ModifUser` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ActionID`),
  KEY `wf_action_processid_index` (`ProcessID`),
  CONSTRAINT `wf_action_processid_foreign` FOREIGN KEY (`ProcessID`) REFERENCES `wf_process` (`ProcessID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wf_action`
--

LOCK TABLES `wf_action` WRITE;
/*!40000 ALTER TABLE `wf_action` DISABLE KEYS */;
INSERT INTO `wf_action` VALUES ('HCR032301-01',NULL,'HCR032301','SBM','Submit Oleh Requester','=D2',1,NULL,'5',NULL,'5'),('HCR032301-02',NULL,'HCR032301','CCL','Cancel Oleh Requester','=D3',1,NULL,'5',NULL,'5'),('HCR032301-03',NULL,'HCR032301','APV','Approve Oleh Kadiv Terkait','=D4',1,NULL,'5',NULL,'5'),('HCR032301-04',NULL,'HCR032301','DCL','Decline Oleh Kadiv Terkait','=D5',1,NULL,'5',NULL,'5'),('HCR032301-05',NULL,'HCR032301','CCL','Cancel Oleh Kadiv Terkait','=D6',1,NULL,'5',NULL,'5'),('HCR032301-06',NULL,'HCR032301','APV','Approve Oleh Kabag HCGA','=D7',1,NULL,'5',NULL,'5'),('HCR032301-07',NULL,'HCR032301','DCL','Decline Oleh Kabag HCGA','=D8',1,NULL,'5',NULL,'5'),('HCR032301-08',NULL,'HCR032301','CCL','Cancel Oleh Kabag HCGA','=D9',1,NULL,'5',NULL,'5'),('HCR032301-09',NULL,'HCR032301','APV','Approve Oleh Kadiv HCGA','=D10',1,NULL,'5',NULL,'5'),('HCR032301-10',NULL,'HCR032301','DCL','Decline Oleh Kadiv HCGA','=D11',1,NULL,'5',NULL,'5'),('HCR032301-11',NULL,'HCR032301','CCL','Cancel Oleh Kadiv HCGA','=D12',1,NULL,'5',NULL,'5'),('HCR032302-01',NULL,'HCR032302','SBM','Submit Oleh Requester','=D13',1,NULL,'5',NULL,'5'),('HCR032302-02',NULL,'HCR032302','CCL','Cancel Oleh Requester','=D14',1,NULL,'5',NULL,'5'),('HCR032302-03',NULL,'HCR032302','APV','Approve Oleh Direktur Terkait','=D15',1,NULL,'5',NULL,'5'),('HCR032302-04',NULL,'HCR032302','DCL','Decline Oleh Direktur Terkait','=D16',1,NULL,'5',NULL,'5'),('HCR032302-05',NULL,'HCR032302','CCL','Cancel Oleh Direktur Terkait','=D17',1,NULL,'5',NULL,'5'),('HCR032302-06',NULL,'HCR032302','APV','Approve Oleh Kabag HCGA','=D18',1,NULL,'5',NULL,'5'),('HCR032302-07',NULL,'HCR032302','DCL','Decline Oleh Kabag HCGA','=D19',1,NULL,'5',NULL,'5'),('HCR032302-08',NULL,'HCR032302','CCL','Cancel Oleh Kabag HCGA','=D20',1,NULL,'5',NULL,'5'),('HCR032302-09',NULL,'HCR032302','APV','Approve Oleh Kadiv HCGA','=D21',1,NULL,'5',NULL,'5'),('HCR032302-10',NULL,'HCR032302','DCL','Decline Oleh Kadiv HCGA','=D22',1,NULL,'5',NULL,'5'),('HCR032302-11',NULL,'HCR032302','CCL','Cancel Oleh Kadiv HCGA','=D23',1,NULL,'5',NULL,'5'),('HCR032303-01',NULL,'HCR032303','SBM','Submit Oleh Requester','=D24',1,NULL,'5',NULL,'5'),('HCR032303-02',NULL,'HCR032303','CCL','Cancel Oleh Requester','=D25',1,NULL,'5',NULL,'5'),('HCR032303-03',NULL,'HCR032303','APV','Approve Oleh Kabag HCGA','=D26',1,NULL,'5',NULL,'5'),('HCR032303-04',NULL,'HCR032303','DCL','Decline Oleh Kabag HCGA','=D27',1,NULL,'5',NULL,'5'),('HCR032303-05',NULL,'HCR032303','CCL','Cancel Oleh Kabag HCGA','=D28',1,NULL,'5',NULL,'5'),('HCR032303-06',NULL,'HCR032303','APV','Approve Oleh Kadiv HCGA','=D29',1,NULL,'5',NULL,'5'),('HCR032303-07',NULL,'HCR032303','DCL','Decline Oleh Kadiv HCGA','=D30',1,NULL,'5',NULL,'5'),('HCR032303-08',NULL,'HCR032303','CCL','Cancel Oleh Kadiv HCGA','=D31',1,NULL,'5',NULL,'5');
/*!40000 ALTER TABLE `wf_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wf_action_target`
--

DROP TABLE IF EXISTS `wf_action_target`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wf_action_target` (
  `ActionTargetID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ActionID` varchar(50) NOT NULL,
  `TargetID` varchar(20) NOT NULL,
  `GroupID` varchar(50) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputDate` datetime DEFAULT NULL,
  `InputUser` varchar(100) DEFAULT NULL,
  `ModifDate` datetime DEFAULT NULL,
  `ModifUser` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ActionTargetID`),
  KEY `wf_action_target_groupid_foreign` (`GroupID`),
  KEY `wf_action_target_targetid_index` (`TargetID`),
  KEY `wf_action_target_actionid_groupid_index` (`ActionID`,`GroupID`),
  CONSTRAINT `wf_action_target_actionid_foreign` FOREIGN KEY (`ActionID`) REFERENCES `wf_action` (`ActionID`) ON UPDATE CASCADE,
  CONSTRAINT `wf_action_target_groupid_foreign` FOREIGN KEY (`GroupID`) REFERENCES `wf_group` (`GroupID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40799 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wf_action_target`
--

LOCK TABLES `wf_action_target` WRITE;
/*!40000 ALTER TABLE `wf_action_target` DISABLE KEYS */;
INSERT INTO `wf_action_target` VALUES (40407,'HCR032301-01','STK','HCR032301-G03',1,NULL,'5',NULL,'5'),(40408,'HCR032301-02','STK','HCR032301-G03',1,NULL,'5',NULL,'5'),(40409,'HCR032301-02','GRP','HCR032301-G04',1,NULL,'5',NULL,'5'),(40410,'HCR032301-03','STK','HCR032301-G04',1,NULL,'5',NULL,'5'),(40411,'HCR032301-04','STK','HCR032301-G04',1,NULL,'5',NULL,'5'),(40412,'HCR032301-05','STK','HCR032301-G04',1,NULL,'5',NULL,'5'),(40413,'HCR032301-06','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40414,'HCR032301-07','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40415,'HCR032301-08','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40416,'HCR032301-08','GRP','HCR032301-G04',1,NULL,'5',NULL,'5'),(40417,'HCR032301-09','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40418,'HCR032301-09','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40419,'HCR032301-09','GRP','HCR032301-G04',1,NULL,'5',NULL,'5'),(40420,'HCR032301-10','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40421,'HCR032301-11','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40422,'HCR032301-11','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40423,'HCR032301-11','GRP','HCR032301-G04',1,NULL,'5',NULL,'5'),(40424,'HCR032301-01','STK','HCR032301-G05',1,NULL,'5',NULL,'5'),(40425,'HCR032301-02','STK','HCR032301-G05',1,NULL,'5',NULL,'5'),(40426,'HCR032301-02','GRP','HCR032301-G06',1,NULL,'5',NULL,'5'),(40427,'HCR032301-03','STK','HCR032301-G06',1,NULL,'5',NULL,'5'),(40428,'HCR032301-04','STK','HCR032301-G06',1,NULL,'5',NULL,'5'),(40429,'HCR032301-05','STK','HCR032301-G06',1,NULL,'5',NULL,'5'),(40430,'HCR032301-06','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40431,'HCR032301-07','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40432,'HCR032301-08','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40433,'HCR032301-08','GRP','HCR032301-G06',1,NULL,'5',NULL,'5'),(40434,'HCR032301-09','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40435,'HCR032301-09','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40436,'HCR032301-09','GRP','HCR032301-G06',1,NULL,'5',NULL,'5'),(40437,'HCR032301-10','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40438,'HCR032301-11','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40439,'HCR032301-11','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40440,'HCR032301-11','GRP','HCR032301-G06',1,NULL,'5',NULL,'5'),(40441,'HCR032301-01','STK','HCR032301-G07',1,NULL,'5',NULL,'5'),(40442,'HCR032301-02','STK','HCR032301-G07',1,NULL,'5',NULL,'5'),(40443,'HCR032301-02','GRP','HCR032301-G08',1,NULL,'5',NULL,'5'),(40444,'HCR032301-03','STK','HCR032301-G08',1,NULL,'5',NULL,'5'),(40445,'HCR032301-04','STK','HCR032301-G08',1,NULL,'5',NULL,'5'),(40446,'HCR032301-05','STK','HCR032301-G08',1,NULL,'5',NULL,'5'),(40447,'HCR032301-06','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40448,'HCR032301-07','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40449,'HCR032301-08','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40450,'HCR032301-08','GRP','HCR032301-G08',1,NULL,'5',NULL,'5'),(40451,'HCR032301-09','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40452,'HCR032301-09','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40453,'HCR032301-09','GRP','HCR032301-G08',1,NULL,'5',NULL,'5'),(40454,'HCR032301-10','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40455,'HCR032301-11','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40456,'HCR032301-11','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40457,'HCR032301-11','GRP','HCR032301-G08',1,NULL,'5',NULL,'5'),(40458,'HCR032301-01','STK','HCR032301-G09',1,NULL,'5',NULL,'5'),(40459,'HCR032301-02','STK','HCR032301-G09',1,NULL,'5',NULL,'5'),(40460,'HCR032301-02','GRP','HCR032301-G10',1,NULL,'5',NULL,'5'),(40461,'HCR032301-03','STK','HCR032301-G10',1,NULL,'5',NULL,'5'),(40462,'HCR032301-04','STK','HCR032301-G10',1,NULL,'5',NULL,'5'),(40463,'HCR032301-05','STK','HCR032301-G10',1,NULL,'5',NULL,'5'),(40464,'HCR032301-06','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40465,'HCR032301-07','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40466,'HCR032301-08','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40467,'HCR032301-08','GRP','HCR032301-G10',1,NULL,'5',NULL,'5'),(40468,'HCR032301-09','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40469,'HCR032301-09','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40470,'HCR032301-09','GRP','HCR032301-G10',1,NULL,'5',NULL,'5'),(40471,'HCR032301-10','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40472,'HCR032301-11','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40473,'HCR032301-11','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40474,'HCR032301-11','GRP','HCR032301-G10',1,NULL,'5',NULL,'5'),(40475,'HCR032301-01','STK','HCR032301-G11',1,NULL,'5',NULL,'5'),(40476,'HCR032301-02','STK','HCR032301-G11',1,NULL,'5',NULL,'5'),(40477,'HCR032301-02','GRP','HCR032301-G12',1,NULL,'5',NULL,'5'),(40478,'HCR032301-03','STK','HCR032301-G12',1,NULL,'5',NULL,'5'),(40479,'HCR032301-04','STK','HCR032301-G12',1,NULL,'5',NULL,'5'),(40480,'HCR032301-05','STK','HCR032301-G12',1,NULL,'5',NULL,'5'),(40481,'HCR032301-06','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40482,'HCR032301-07','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40483,'HCR032301-08','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40484,'HCR032301-08','GRP','HCR032301-G12',1,NULL,'5',NULL,'5'),(40485,'HCR032301-09','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40486,'HCR032301-09','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40487,'HCR032301-09','GRP','HCR032301-G12',1,NULL,'5',NULL,'5'),(40488,'HCR032301-10','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40489,'HCR032301-11','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40490,'HCR032301-11','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40491,'HCR032301-11','GRP','HCR032301-G12',1,NULL,'5',NULL,'5'),(40492,'HCR032301-01','STK','HCR032301-G13',1,NULL,'5',NULL,'5'),(40493,'HCR032301-02','STK','HCR032301-G13',1,NULL,'5',NULL,'5'),(40494,'HCR032301-02','GRP','HCR032301-G14',1,NULL,'5',NULL,'5'),(40495,'HCR032301-03','STK','HCR032301-G14',1,NULL,'5',NULL,'5'),(40496,'HCR032301-04','STK','HCR032301-G14',1,NULL,'5',NULL,'5'),(40497,'HCR032301-05','STK','HCR032301-G14',1,NULL,'5',NULL,'5'),(40498,'HCR032301-06','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40499,'HCR032301-07','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40500,'HCR032301-08','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40501,'HCR032301-08','GRP','HCR032301-G14',1,NULL,'5',NULL,'5'),(40502,'HCR032301-09','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40503,'HCR032301-09','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40504,'HCR032301-09','GRP','HCR032301-G14',1,NULL,'5',NULL,'5'),(40505,'HCR032301-10','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40506,'HCR032301-11','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40507,'HCR032301-11','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40508,'HCR032301-11','GRP','HCR032301-G14',1,NULL,'5',NULL,'5'),(40509,'HCR032301-01','STK','HCR032301-G15',1,NULL,'5',NULL,'5'),(40510,'HCR032301-02','STK','HCR032301-G15',1,NULL,'5',NULL,'5'),(40511,'HCR032301-02','GRP','HCR032301-G16',1,NULL,'5',NULL,'5'),(40512,'HCR032301-03','STK','HCR032301-G16',1,NULL,'5',NULL,'5'),(40513,'HCR032301-04','STK','HCR032301-G16',1,NULL,'5',NULL,'5'),(40514,'HCR032301-05','STK','HCR032301-G16',1,NULL,'5',NULL,'5'),(40515,'HCR032301-06','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40516,'HCR032301-07','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40517,'HCR032301-08','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40518,'HCR032301-08','GRP','HCR032301-G16',1,NULL,'5',NULL,'5'),(40519,'HCR032301-09','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40520,'HCR032301-09','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40521,'HCR032301-09','GRP','HCR032301-G16',1,NULL,'5',NULL,'5'),(40522,'HCR032301-10','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40523,'HCR032301-11','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40524,'HCR032301-11','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40525,'HCR032301-11','GRP','HCR032301-G16',1,NULL,'5',NULL,'5'),(40526,'HCR032301-01','STK','HCR032301-G17',1,NULL,'5',NULL,'5'),(40527,'HCR032301-02','STK','HCR032301-G17',1,NULL,'5',NULL,'5'),(40528,'HCR032301-02','GRP','HCR032301-G18',1,NULL,'5',NULL,'5'),(40529,'HCR032301-03','STK','HCR032301-G18',1,NULL,'5',NULL,'5'),(40530,'HCR032301-04','STK','HCR032301-G18',1,NULL,'5',NULL,'5'),(40531,'HCR032301-05','STK','HCR032301-G18',1,NULL,'5',NULL,'5'),(40532,'HCR032301-06','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40533,'HCR032301-07','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40534,'HCR032301-08','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40535,'HCR032301-08','GRP','HCR032301-G18',1,NULL,'5',NULL,'5'),(40536,'HCR032301-09','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40537,'HCR032301-09','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40538,'HCR032301-09','GRP','HCR032301-G18',1,NULL,'5',NULL,'5'),(40539,'HCR032301-10','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40540,'HCR032301-11','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40541,'HCR032301-11','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40542,'HCR032301-11','GRP','HCR032301-G18',1,NULL,'5',NULL,'5'),(40543,'HCR032301-01','STK','HCR032301-G19',1,NULL,'5',NULL,'5'),(40544,'HCR032301-02','STK','HCR032301-G19',1,NULL,'5',NULL,'5'),(40545,'HCR032301-02','GRP','HCR032301-G20',1,NULL,'5',NULL,'5'),(40546,'HCR032301-03','STK','HCR032301-G20',1,NULL,'5',NULL,'5'),(40547,'HCR032301-04','STK','HCR032301-G20',1,NULL,'5',NULL,'5'),(40548,'HCR032301-05','STK','HCR032301-G20',1,NULL,'5',NULL,'5'),(40549,'HCR032301-06','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40550,'HCR032301-07','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40551,'HCR032301-08','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40552,'HCR032301-08','GRP','HCR032301-G20',1,NULL,'5',NULL,'5'),(40553,'HCR032301-09','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40554,'HCR032301-09','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40555,'HCR032301-09','GRP','HCR032301-G20',1,NULL,'5',NULL,'5'),(40556,'HCR032301-10','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40557,'HCR032301-11','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40558,'HCR032301-11','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40559,'HCR032301-11','GRP','HCR032301-G20',1,NULL,'5',NULL,'5'),(40560,'HCR032301-01','STK','HCR032301-G21',1,NULL,'5',NULL,'5'),(40561,'HCR032301-02','STK','HCR032301-G21',1,NULL,'5',NULL,'5'),(40562,'HCR032301-02','GRP','HCR032301-G22',1,NULL,'5',NULL,'5'),(40563,'HCR032301-03','STK','HCR032301-G22',1,NULL,'5',NULL,'5'),(40564,'HCR032301-04','STK','HCR032301-G22',1,NULL,'5',NULL,'5'),(40565,'HCR032301-05','STK','HCR032301-G22',1,NULL,'5',NULL,'5'),(40566,'HCR032301-06','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40567,'HCR032301-07','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40568,'HCR032301-08','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40569,'HCR032301-08','GRP','HCR032301-G22',1,NULL,'5',NULL,'5'),(40570,'HCR032301-09','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40571,'HCR032301-09','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40572,'HCR032301-09','GRP','HCR032301-G22',1,NULL,'5',NULL,'5'),(40573,'HCR032301-10','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40574,'HCR032301-11','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40575,'HCR032301-11','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40576,'HCR032301-11','GRP','HCR032301-G22',1,NULL,'5',NULL,'5'),(40577,'HCR032302-01','STK','HCR032302-G03',1,NULL,'5',NULL,'5'),(40578,'HCR032302-02','STK','HCR032302-G03',1,NULL,'5',NULL,'5'),(40579,'HCR032302-02','GRP','HCR032302-G04',1,NULL,'5',NULL,'5'),(40580,'HCR032302-03','STK','HCR032302-G04',1,NULL,'5',NULL,'5'),(40581,'HCR032302-04','STK','HCR032302-G04',1,NULL,'5',NULL,'5'),(40582,'HCR032302-05','STK','HCR032302-G04',1,NULL,'5',NULL,'5'),(40583,'HCR032302-06','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40584,'HCR032302-07','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40585,'HCR032302-08','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40586,'HCR032302-08','GRP','HCR032302-G04',1,NULL,'5',NULL,'5'),(40587,'HCR032302-09','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40588,'HCR032302-09','GRP','HCR032302-G02',1,NULL,'5',NULL,'5'),(40589,'HCR032302-09','GRP','HCR032302-G04',1,NULL,'5',NULL,'5'),(40590,'HCR032302-10','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40591,'HCR032302-11','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40592,'HCR032302-11','GRP','HCR032302-G02',1,NULL,'5',NULL,'5'),(40593,'HCR032302-11','GRP','HCR032302-G04',1,NULL,'5',NULL,'5'),(40594,'HCR032302-01','STK','HCR032302-G05',1,NULL,'5',NULL,'5'),(40595,'HCR032302-02','STK','HCR032302-G05',1,NULL,'5',NULL,'5'),(40596,'HCR032302-02','GRP','HCR032302-G06',1,NULL,'5',NULL,'5'),(40597,'HCR032302-03','STK','HCR032302-G06',1,NULL,'5',NULL,'5'),(40598,'HCR032302-04','STK','HCR032302-G06',1,NULL,'5',NULL,'5'),(40599,'HCR032302-05','STK','HCR032302-G06',1,NULL,'5',NULL,'5'),(40600,'HCR032302-06','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40601,'HCR032302-07','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40602,'HCR032302-08','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40603,'HCR032302-08','GRP','HCR032302-G06',1,NULL,'5',NULL,'5'),(40604,'HCR032302-09','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40605,'HCR032302-09','GRP','HCR032302-G02',1,NULL,'5',NULL,'5'),(40606,'HCR032302-09','GRP','HCR032302-G06',1,NULL,'5',NULL,'5'),(40607,'HCR032302-10','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40608,'HCR032302-11','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40609,'HCR032302-11','GRP','HCR032302-G02',1,NULL,'5',NULL,'5'),(40610,'HCR032302-11','GRP','HCR032302-G06',1,NULL,'5',NULL,'5'),(40611,'HCR032302-01','STK','HCR032302-G07',1,NULL,'5',NULL,'5'),(40612,'HCR032302-02','STK','HCR032302-G07',1,NULL,'5',NULL,'5'),(40613,'HCR032302-02','GRP','HCR032302-G08',1,NULL,'5',NULL,'5'),(40614,'HCR032302-03','STK','HCR032302-G08',1,NULL,'5',NULL,'5'),(40615,'HCR032302-04','STK','HCR032302-G08',1,NULL,'5',NULL,'5'),(40616,'HCR032302-05','STK','HCR032302-G08',1,NULL,'5',NULL,'5'),(40617,'HCR032302-06','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40618,'HCR032302-07','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40619,'HCR032302-08','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40620,'HCR032302-08','GRP','HCR032302-G08',1,NULL,'5',NULL,'5'),(40621,'HCR032302-09','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40622,'HCR032302-09','GRP','HCR032302-G02',1,NULL,'5',NULL,'5'),(40623,'HCR032302-09','GRP','HCR032302-G08',1,NULL,'5',NULL,'5'),(40624,'HCR032302-10','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40625,'HCR032302-11','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40626,'HCR032302-11','GRP','HCR032302-G02',1,NULL,'5',NULL,'5'),(40627,'HCR032302-11','GRP','HCR032302-G08',1,NULL,'5',NULL,'5'),(40628,'HCR032302-01','STK','HCR032302-G09',1,NULL,'5',NULL,'5'),(40629,'HCR032302-02','STK','HCR032302-G09',1,NULL,'5',NULL,'5'),(40630,'HCR032302-02','GRP','HCR032302-G10',1,NULL,'5',NULL,'5'),(40631,'HCR032302-03','STK','HCR032302-G10',1,NULL,'5',NULL,'5'),(40632,'HCR032302-04','STK','HCR032302-G10',1,NULL,'5',NULL,'5'),(40633,'HCR032302-05','STK','HCR032302-G10',1,NULL,'5',NULL,'5'),(40634,'HCR032302-06','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40635,'HCR032302-07','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40636,'HCR032302-08','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40637,'HCR032302-08','GRP','HCR032302-G10',1,NULL,'5',NULL,'5'),(40638,'HCR032302-09','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40639,'HCR032302-09','GRP','HCR032302-G02',1,NULL,'5',NULL,'5'),(40640,'HCR032302-09','GRP','HCR032302-G10',1,NULL,'5',NULL,'5'),(40641,'HCR032302-10','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40642,'HCR032302-11','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40643,'HCR032302-11','GRP','HCR032302-G02',1,NULL,'5',NULL,'5'),(40644,'HCR032302-11','GRP','HCR032302-G10',1,NULL,'5',NULL,'5'),(40645,'HCR032302-01','STK','HCR032302-G11',1,NULL,'5',NULL,'5'),(40646,'HCR032302-02','STK','HCR032302-G11',1,NULL,'5',NULL,'5'),(40647,'HCR032302-02','GRP','HCR032302-G12',1,NULL,'5',NULL,'5'),(40648,'HCR032302-03','STK','HCR032302-G12',1,NULL,'5',NULL,'5'),(40649,'HCR032302-04','STK','HCR032302-G12',1,NULL,'5',NULL,'5'),(40650,'HCR032302-05','STK','HCR032302-G12',1,NULL,'5',NULL,'5'),(40651,'HCR032302-06','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40652,'HCR032302-07','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40653,'HCR032302-08','STK','HCR032302-G02',1,NULL,'5',NULL,'5'),(40654,'HCR032302-08','GRP','HCR032302-G12',1,NULL,'5',NULL,'5'),(40655,'HCR032302-09','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40656,'HCR032302-09','GRP','HCR032302-G02',1,NULL,'5',NULL,'5'),(40657,'HCR032302-09','GRP','HCR032302-G12',1,NULL,'5',NULL,'5'),(40658,'HCR032302-10','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40659,'HCR032302-11','STK','HCR032302-G01',1,NULL,'5',NULL,'5'),(40660,'HCR032302-11','GRP','HCR032302-G02',1,NULL,'5',NULL,'5'),(40661,'HCR032302-11','GRP','HCR032302-G12',1,NULL,'5',NULL,'5'),(40662,'HCR032303-01','STK','HCR032303-G03',1,NULL,'5',NULL,'5'),(40663,'HCR032303-02','STK','HCR032303-G03',1,NULL,'5',NULL,'5'),(40664,'HCR032303-02','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40665,'HCR032303-03','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40666,'HCR032303-04','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40667,'HCR032303-05','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40668,'HCR032303-06','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40669,'HCR032303-07','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40670,'HCR032303-08','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40671,'HCR032303-08','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40672,'HCR032303-01','STK','HCR032303-G04',1,NULL,'5',NULL,'5'),(40673,'HCR032303-02','STK','HCR032303-G04',1,NULL,'5',NULL,'5'),(40674,'HCR032303-02','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40675,'HCR032303-03','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40676,'HCR032303-04','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40677,'HCR032303-05','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40678,'HCR032303-06','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40679,'HCR032303-07','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40680,'HCR032303-08','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40681,'HCR032303-08','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40682,'HCR032303-01','STK','HCR032303-G05',1,NULL,'5',NULL,'5'),(40683,'HCR032303-02','STK','HCR032303-G05',1,NULL,'5',NULL,'5'),(40684,'HCR032303-02','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40685,'HCR032303-03','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40686,'HCR032303-04','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40687,'HCR032303-05','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40688,'HCR032303-06','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40689,'HCR032303-07','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40690,'HCR032303-08','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40691,'HCR032303-08','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40692,'HCR032303-01','STK','HCR032303-G06',1,NULL,'5',NULL,'5'),(40693,'HCR032303-02','STK','HCR032303-G06',1,NULL,'5',NULL,'5'),(40694,'HCR032303-02','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40695,'HCR032303-03','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40696,'HCR032303-04','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40697,'HCR032303-05','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40698,'HCR032303-06','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40699,'HCR032303-07','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40700,'HCR032303-08','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40701,'HCR032303-08','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40702,'HCR032303-01','STK','HCR032303-G07',1,NULL,'5',NULL,'5'),(40703,'HCR032303-02','STK','HCR032303-G07',1,NULL,'5',NULL,'5'),(40704,'HCR032303-02','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40705,'HCR032303-03','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40706,'HCR032303-04','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40707,'HCR032303-05','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40708,'HCR032303-06','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40709,'HCR032303-07','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40710,'HCR032303-08','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40711,'HCR032303-08','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40712,'HCR032303-01','STK','HCR032303-G08',1,NULL,'5',NULL,'5'),(40713,'HCR032303-02','STK','HCR032303-G08',1,NULL,'5',NULL,'5'),(40714,'HCR032303-02','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40715,'HCR032303-03','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40716,'HCR032303-04','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40717,'HCR032303-05','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40718,'HCR032303-06','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40719,'HCR032303-07','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40720,'HCR032303-08','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40721,'HCR032303-08','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40722,'HCR032303-01','STK','HCR032303-G09',1,NULL,'5',NULL,'5'),(40723,'HCR032303-02','STK','HCR032303-G09',1,NULL,'5',NULL,'5'),(40724,'HCR032303-02','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40725,'HCR032303-03','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40726,'HCR032303-04','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40727,'HCR032303-05','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40728,'HCR032303-06','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40729,'HCR032303-07','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40730,'HCR032303-08','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40731,'HCR032303-08','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40732,'HCR032303-01','STK','HCR032303-G10',1,NULL,'5',NULL,'5'),(40733,'HCR032303-02','STK','HCR032303-G10',1,NULL,'5',NULL,'5'),(40734,'HCR032303-02','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40735,'HCR032303-03','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40736,'HCR032303-04','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40737,'HCR032303-05','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40738,'HCR032303-06','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40739,'HCR032303-07','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40740,'HCR032303-08','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40741,'HCR032303-08','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40742,'HCR032303-01','STK','HCR032303-G11',1,NULL,'5',NULL,'5'),(40743,'HCR032303-02','STK','HCR032303-G11',1,NULL,'5',NULL,'5'),(40744,'HCR032303-02','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40745,'HCR032303-03','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40746,'HCR032303-04','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40747,'HCR032303-05','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40748,'HCR032303-06','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40749,'HCR032303-07','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40750,'HCR032303-08','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40751,'HCR032303-08','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40752,'HCR032303-01','STK','HCR032303-G12',1,NULL,'5',NULL,'5'),(40753,'HCR032303-02','STK','HCR032303-G12',1,NULL,'5',NULL,'5'),(40754,'HCR032303-02','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40755,'HCR032303-03','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40756,'HCR032303-04','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40757,'HCR032303-05','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40758,'HCR032303-06','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40759,'HCR032303-07','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40760,'HCR032303-08','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40761,'HCR032303-08','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40762,'HCR032303-01','STK','HCR032303-G13',1,NULL,'5',NULL,'5'),(40763,'HCR032303-02','STK','HCR032303-G13',1,NULL,'5',NULL,'5'),(40764,'HCR032303-02','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40765,'HCR032303-03','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40766,'HCR032303-04','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40767,'HCR032303-05','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40768,'HCR032303-06','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40769,'HCR032303-07','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40770,'HCR032303-08','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40771,'HCR032303-08','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40772,'HCR032303-01','STK','HCR032303-G14',1,NULL,'5',NULL,'5'),(40773,'HCR032303-02','STK','HCR032303-G14',1,NULL,'5',NULL,'5'),(40774,'HCR032303-02','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40775,'HCR032303-03','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40776,'HCR032303-04','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40777,'HCR032303-05','STK','HCR032303-G02',1,NULL,'5',NULL,'5'),(40778,'HCR032303-06','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40779,'HCR032303-07','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40780,'HCR032303-08','STK','HCR032303-G01',1,NULL,'5',NULL,'5'),(40781,'HCR032303-08','GRP','HCR032303-G02',1,NULL,'5',NULL,'5'),(40782,'HCR032301-01','STK','HCR032301-G23',1,NULL,'5',NULL,'5'),(40783,'HCR032301-02','STK','HCR032301-G23',1,NULL,'5',NULL,'5'),(40784,'HCR032301-02','GRP','HCR032301-G24',1,NULL,'5',NULL,'5'),(40785,'HCR032301-03','STK','HCR032301-G24',1,NULL,'5',NULL,'5'),(40786,'HCR032301-04','STK','HCR032301-G24',1,NULL,'5',NULL,'5'),(40787,'HCR032301-05','STK','HCR032301-G24',1,NULL,'5',NULL,'5'),(40788,'HCR032301-06','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40789,'HCR032301-07','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40790,'HCR032301-08','STK','HCR032301-G02',1,NULL,'5',NULL,'5'),(40791,'HCR032301-08','GRP','HCR032301-G24',1,NULL,'5',NULL,'5'),(40792,'HCR032301-09','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40793,'HCR032301-09','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40794,'HCR032301-09','GRP','HCR032301-G24',1,NULL,'5',NULL,'5'),(40795,'HCR032301-10','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40796,'HCR032301-11','STK','HCR032301-G01',1,NULL,'5',NULL,'5'),(40797,'HCR032301-11','GRP','HCR032301-G02',1,NULL,'5',NULL,'5'),(40798,'HCR032301-11','GRP','HCR032301-G24',1,NULL,'5',NULL,'5');
/*!40000 ALTER TABLE `wf_action_target` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wf_group`
--

DROP TABLE IF EXISTS `wf_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wf_group` (
  `GroupID` varchar(50) NOT NULL,
  `ProcessID` varchar(50) NOT NULL,
  `GroupName` varchar(255) NOT NULL,
  `DivID` varchar(50) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputDate` datetime DEFAULT NULL,
  `InputUser` varchar(100) DEFAULT NULL,
  `ModifDate` datetime DEFAULT NULL,
  `ModifUser` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`GroupID`),
  KEY `wf_group_divid_index` (`DivID`),
  KEY `wf_group_processid_index` (`ProcessID`),
  CONSTRAINT `wf_group_processid_foreign` FOREIGN KEY (`ProcessID`) REFERENCES `wf_process` (`ProcessID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wf_group`
--

LOCK TABLES `wf_group` WRITE;
/*!40000 ALTER TABLE `wf_group` DISABLE KEYS */;
INSERT INTO `wf_group` VALUES ('HCR032301-G01','HCR032301','Kadiv HCGA','ALL',1,NULL,'5',NULL,'5'),('HCR032301-G02','HCR032301','Kabag HCGA','ALL',1,NULL,'5',NULL,'5'),('HCR032301-G03','HCR032301','Requester Claim Service & Loss Adjusting - General','GAC',1,NULL,'5',NULL,'5'),('HCR032301-G04','HCR032301','Kadiv Claim Service & Loss Adjusting - General','GAC',1,NULL,'5',NULL,'5'),('HCR032301-G05','HCR032301','Requester Client Services & Post Acquisition Support - General','GCP',1,NULL,'5',NULL,'5'),('HCR032301-G06','HCR032301','Kadiv Client Services & Post Acquisition Support - General','GCP',1,NULL,'5',NULL,'5'),('HCR032301-G07','HCR032301','Requester Facultative - General','GMC',1,NULL,'5',NULL,'5'),('HCR032301-G08','HCR032301','Kadiv Facultative - General','GMC',1,NULL,'5',NULL,'5'),('HCR032301-G09','HCR032301','Requester Treaty, Retrocession & Risk Management','GUW',1,NULL,'5',NULL,'5'),('HCR032301-G10','HCR032301','Kadiv Treaty, Retrocession & Risk Management','GUW',1,NULL,'5',NULL,'5'),('HCR032301-G11','HCR032301','Requester HC GA','HTC',1,NULL,'5',NULL,'5'),('HCR032301-G12','HCR032301','Kadiv HC GA','HTC',1,NULL,'5',NULL,'5'),('HCR032301-G13','HCR032301','Requester Information Technology','INT',1,NULL,'5',NULL,'5'),('HCR032301-G14','HCR032301','Kadiv Information Technology','INT',1,NULL,'5',NULL,'5'),('HCR032301-G15','HCR032301','Requester Client Services & Post Acquisition Support - Life','LAC',1,NULL,'5',NULL,'5'),('HCR032301-G16','HCR032301','Kadiv Client Services & Post Acquisition Support - Life','LAC',1,NULL,'5',NULL,'5'),('HCR032301-G17','HCR032301','Requester Sharia Reinsurance Unit','LRS',1,NULL,'5',NULL,'5'),('HCR032301-G18','HCR032301','Kadiv Sharia Reinsurance Unit','LRS',1,NULL,'5',NULL,'5'),('HCR032301-G19','HCR032301','Requester Technical & Operation Life','LTL',1,NULL,'5',NULL,'5'),('HCR032301-G20','HCR032301','Kadiv Technical & Operation Life','LTL',1,NULL,'5',NULL,'5'),('HCR032301-G21','HCR032301','Requester Technical Accounting & Collection','TAC',1,NULL,'5',NULL,'5'),('HCR032301-G22','HCR032301','Kadiv Technical Accounting & Collection','TAC',1,NULL,'5',NULL,'5'),('HCR032301-G23','HCR032301','Requester Corporate Actuaries','CAC',1,NULL,'5',NULL,'5'),('HCR032301-G24','HCR032301','Kadiv Corporate Actuaries','CAC',1,NULL,'5',NULL,'5'),('HCR032302-G01','HCR032302','Kadiv HCGA','ALL',1,NULL,'5',NULL,'5'),('HCR032302-G02','HCR032302','Kabag HCGA','ALL',1,NULL,'5',NULL,'5'),('HCR032302-G03','HCR032302','Requester Risk Management & Compliance','CMP',1,NULL,'5',NULL,'5'),('HCR032302-G04','HCR032302','Direktur Risk Management & Compliance','CMP',1,NULL,'5',NULL,'5'),('HCR032302-G05','HCR032302','Requester Corporate Secretary','CSC',1,NULL,'5',NULL,'5'),('HCR032302-G06','HCR032302','Direktur Corporate Secretary','CSC',1,NULL,'5',NULL,'5'),('HCR032302-G07','HCR032302','Requester Finance Accounting & Sharia','FAS',1,NULL,'5',NULL,'5'),('HCR032302-G08','HCR032302','Direktur Finance Accounting & Sharia','FAS',1,NULL,'5',NULL,'5'),('HCR032302-G09','HCR032302','Requester Legal','GRC',1,NULL,'5',NULL,'5'),('HCR032302-G10','HCR032302','Direktur Legal','GRC',1,NULL,'5',NULL,'5'),('HCR032302-G11','HCR032302','Requester Internal Auditor (Unit)','IAU',1,NULL,'5',NULL,'5'),('HCR032302-G12','HCR032302','Direktur Internal Auditor (Unit)','IAU',1,NULL,'5',NULL,'5'),('HCR032303-G01','HCR032303','Kadiv HCGA','ALL',1,NULL,'5',NULL,'5'),('HCR032303-G02','HCR032303','Kabag HCGA','ALL',1,NULL,'5',NULL,'5'),('HCR032303-G03','HCR032303','Requester Board Of Director','BOD',1,NULL,'5',NULL,'5'),('HCR032303-G04','HCR032303','Requester Corporate Actuaries','CAC',1,NULL,'5',NULL,'5'),('HCR032303-G05','HCR032303','Requester Claim Service & Loss Adjusting - General','GAC',1,NULL,'5',NULL,'5'),('HCR032303-G06','HCR032303','Requester Client Services & Post Acquisition Support - General','GCP',1,NULL,'5',NULL,'5'),('HCR032303-G07','HCR032303','Requester Facultative - General','GMC',1,NULL,'5',NULL,'5'),('HCR032303-G08','HCR032303','Requester Treaty, Retrocession & Risk Management','GUW',1,NULL,'5',NULL,'5'),('HCR032303-G09','HCR032303','Requester HC GA','HTC',1,NULL,'5',NULL,'5'),('HCR032303-G10','HCR032303','Requester Information Technology','INT',1,NULL,'5',NULL,'5'),('HCR032303-G11','HCR032303','Requester Client Services & Post Acquisition Support - Life','LAC',1,NULL,'5',NULL,'5'),('HCR032303-G12','HCR032303','Requester Sharia Reinsurance Unit','LRS',1,NULL,'5',NULL,'5'),('HCR032303-G13','HCR032303','Requester Technical & Operation Life','LTL',1,NULL,'5',NULL,'5'),('HCR032303-G14','HCR032303','Requester Technical Accounting & Collection','TAC',1,NULL,'5',NULL,'5');
/*!40000 ALTER TABLE `wf_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wf_group_member`
--

DROP TABLE IF EXISTS `wf_group_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wf_group_member` (
  `GroupMemberID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `GroupID` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `IsDefault` tinyint(1) NOT NULL DEFAULT 0,
  `InputDate` datetime DEFAULT NULL,
  `InputUser` varchar(100) DEFAULT NULL,
  `ModifDate` datetime DEFAULT NULL,
  `ModifUser` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`GroupMemberID`),
  KEY `wf_group_member_userid_index` (`UserID`),
  KEY `wf_group_member_groupid_userid_index` (`GroupID`,`UserID`),
  CONSTRAINT `wf_group_member_groupid_foreign` FOREIGN KEY (`GroupID`) REFERENCES `wf_group` (`GroupID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wf_group_member`
--

LOCK TABLES `wf_group_member` WRITE;
/*!40000 ALTER TABLE `wf_group_member` DISABLE KEYS */;
INSERT INTO `wf_group_member` VALUES (1,'HCR032301-G01','242',1,1,NULL,'5',NULL,'5'),(2,'HCR032301-G02','043',1,1,NULL,'5',NULL,'5'),(3,'HCR032301-G23','193',1,1,NULL,'5',NULL,'5'),(4,'HCR032301-G24','166',1,1,NULL,'5',NULL,'5'),(5,'HCR032301-G03','033',1,1,NULL,'5',NULL,'5'),(6,'HCR032301-G03','011',1,1,NULL,'5',NULL,'5'),(7,'HCR032301-G03','118',1,1,NULL,'5',NULL,'5'),(8,'HCR032301-G03','214',1,1,NULL,'5',NULL,'5'),(9,'HCR032301-G03','294',1,1,NULL,'5',NULL,'5'),(10,'HCR032301-G03','093',1,1,NULL,'5',NULL,'5'),(11,'HCR032301-G03','065',1,1,NULL,'5',NULL,'5'),(12,'HCR032301-G03','271',1,1,NULL,'5',NULL,'5'),(13,'HCR032301-G03','117',1,1,NULL,'5',NULL,'5'),(14,'HCR032301-G03','036',1,1,NULL,'5',NULL,'5'),(15,'HCR032301-G03','008',1,1,NULL,'5',NULL,'5'),(16,'HCR032301-G03','179',1,1,NULL,'5',NULL,'5'),(17,'HCR032301-G03','283',1,1,NULL,'5',NULL,'5'),(18,'HCR032301-G03','019',1,1,NULL,'5',NULL,'5'),(19,'HCR032301-G04','062',1,1,NULL,'5',NULL,'5'),(20,'HCR032301-G05','068',1,1,NULL,'5',NULL,'5'),(21,'HCR032301-G05','076',1,1,NULL,'5',NULL,'5'),(22,'HCR032301-G05','013',1,1,NULL,'5',NULL,'5'),(23,'HCR032301-G05','023',1,1,NULL,'5',NULL,'5'),(24,'HCR032301-G05','082',1,1,NULL,'5',NULL,'5'),(25,'HCR032301-G05','129',1,1,NULL,'5',NULL,'5'),(26,'HCR032301-G05','176',1,1,NULL,'5',NULL,'5'),(27,'HCR032301-G05','177',1,1,NULL,'5',NULL,'5'),(28,'HCR032301-G05','229',1,1,NULL,'5',NULL,'5'),(29,'HCR032301-G05','123',1,1,NULL,'5',NULL,'5'),(30,'HCR032301-G05','253',1,1,NULL,'5',NULL,'5'),(31,'HCR032301-G06','032',1,1,NULL,'5',NULL,'5'),(32,'HCR032301-G07','258',1,1,NULL,'5',NULL,'5'),(33,'HCR032301-G07','209',1,1,NULL,'5',NULL,'5'),(34,'HCR032301-G07','035',1,1,NULL,'5',NULL,'5'),(35,'HCR032301-G07','211',1,1,NULL,'5',NULL,'5'),(36,'HCR032301-G07','050',1,1,NULL,'5',NULL,'5'),(37,'HCR032301-G07','047',1,1,NULL,'5',NULL,'5'),(38,'HCR032301-G07','112',1,1,NULL,'5',NULL,'5'),(39,'HCR032301-G07','232',1,1,NULL,'5',NULL,'5'),(40,'HCR032301-G07','025',1,1,NULL,'5',NULL,'5'),(41,'HCR032301-G08','121',1,1,NULL,'5',NULL,'5'),(42,'HCR032301-G09','007',1,1,NULL,'5',NULL,'5'),(43,'HCR032301-G09','184',1,1,NULL,'5',NULL,'5'),(44,'HCR032301-G09','079',1,1,NULL,'5',NULL,'5'),(45,'HCR032301-G09','111',1,1,NULL,'5',NULL,'5'),(46,'HCR032301-G09','250',1,1,NULL,'5',NULL,'5'),(47,'HCR032301-G09','295',1,1,NULL,'5',NULL,'5'),(48,'HCR032301-G09','273',1,1,NULL,'5',NULL,'5'),(49,'HCR032301-G09','119',1,1,NULL,'5',NULL,'5'),(50,'HCR032301-G09','098',1,1,NULL,'5',NULL,'5'),(51,'HCR032301-G09','056',1,1,NULL,'5',NULL,'5'),(52,'HCR032301-G09','255',1,1,NULL,'5',NULL,'5'),(53,'HCR032301-G10','094',1,1,NULL,'5',NULL,'5'),(54,'HCR032301-G11','280',1,1,NULL,'5',NULL,'5'),(55,'HCR032301-G11','219',1,1,NULL,'5',NULL,'5'),(56,'HCR032301-G11','043',1,1,NULL,'5',NULL,'5'),(57,'HCR032301-G11','027',1,1,NULL,'5',NULL,'5'),(58,'HCR032301-G11','045',1,1,NULL,'5',NULL,'5'),(59,'HCR032301-G11','014',1,1,NULL,'5',NULL,'5'),(60,'HCR032301-G11','151',1,1,NULL,'5',NULL,'5'),(61,'HCR032301-G11','152',1,1,NULL,'5',NULL,'5'),(62,'HCR032301-G11','153',1,1,NULL,'5',NULL,'5'),(63,'HCR032301-G11','154',1,1,NULL,'5',NULL,'5'),(64,'HCR032301-G11','158',1,1,NULL,'5',NULL,'5'),(65,'HCR032301-G11','170',1,1,NULL,'5',NULL,'5'),(66,'HCR032301-G11','269',1,1,NULL,'5',NULL,'5'),(67,'HCR032301-G11','268',1,1,NULL,'5',NULL,'5'),(68,'HCR032301-G12','242',1,1,NULL,'5',NULL,'5'),(69,'HCR032301-G13','134',1,1,NULL,'5',NULL,'5'),(70,'HCR032301-G13','135',1,1,NULL,'5',NULL,'5'),(71,'HCR032301-G13','247',1,1,NULL,'5',NULL,'5'),(72,'HCR032301-G13','053',1,1,NULL,'5',NULL,'5'),(73,'HCR032301-G13','143',1,1,NULL,'5',NULL,'5'),(74,'HCR032301-G13','272',1,1,NULL,'5',NULL,'5'),(75,'HCR032301-G13','173',1,1,NULL,'5',NULL,'5'),(76,'HCR032301-G13','026',1,1,NULL,'5',NULL,'5'),(77,'HCR032301-G13','270',1,1,NULL,'5',NULL,'5'),(78,'HCR032301-G13','064',1,1,NULL,'5',NULL,'5'),(79,'HCR032301-G13','257',1,1,NULL,'5',NULL,'5'),(80,'HCR032301-G13','078',1,1,NULL,'5',NULL,'5'),(81,'HCR032301-G13','120',1,1,NULL,'5',NULL,'5'),(82,'HCR032301-G13','244',1,1,NULL,'5',NULL,'5'),(83,'HCR032301-G13','286',1,1,NULL,'5',NULL,'5'),(84,'HCR032301-G13','290',1,1,NULL,'5',NULL,'5'),(85,'HCR032301-G14','002',1,1,NULL,'5',NULL,'5'),(86,'HCR032301-G15','004',1,1,NULL,'5',NULL,'5'),(87,'HCR032301-G15','126',1,1,NULL,'5',NULL,'5'),(88,'HCR032301-G15','067',1,1,NULL,'5',NULL,'5'),(89,'HCR032301-G15','239',1,1,NULL,'5',NULL,'5'),(90,'HCR032301-G15','285',1,1,NULL,'5',NULL,'5'),(91,'HCR032301-G15','289',1,1,NULL,'5',NULL,'5'),(92,'HCR032301-G15','041',1,1,NULL,'5',NULL,'5'),(93,'HCR032301-G15','069',1,1,NULL,'5',NULL,'5'),(94,'HCR032301-G15','201',1,1,NULL,'5',NULL,'5'),(95,'HCR032301-G15','259',1,1,NULL,'5',NULL,'5'),(96,'HCR032301-G15','284',1,1,NULL,'5',NULL,'5'),(97,'HCR032301-G15','122',1,1,NULL,'5',NULL,'5'),(98,'HCR032301-G15','161',1,1,NULL,'5',NULL,'5'),(99,'HCR032301-G16','016',1,1,NULL,'5',NULL,'5'),(100,'HCR032301-G17','216',1,1,NULL,'5',NULL,'5'),(101,'HCR032301-G17','104',1,1,NULL,'5',NULL,'5'),(102,'HCR032301-G17','235',1,1,NULL,'5',NULL,'5'),(103,'HCR032301-G17','278',1,1,NULL,'5',NULL,'5'),(104,'HCR032301-G17','055',1,1,NULL,'5',NULL,'5'),(105,'HCR032301-G17','274',1,1,NULL,'5',NULL,'5'),(106,'HCR032301-G17','277',1,1,NULL,'5',NULL,'5'),(107,'HCR032301-G18','116',1,1,NULL,'5',NULL,'5'),(108,'HCR032301-G19','028',1,1,NULL,'5',NULL,'5'),(109,'HCR032301-G19','057',1,1,NULL,'5',NULL,'5'),(110,'HCR032301-G19','073',1,1,NULL,'5',NULL,'5'),(111,'HCR032301-G19','089',1,1,NULL,'5',NULL,'5'),(112,'HCR032301-G19','071',1,1,NULL,'5',NULL,'5'),(113,'HCR032301-G19','172',1,1,NULL,'5',NULL,'5'),(114,'HCR032301-G19','228',1,1,NULL,'5',NULL,'5'),(115,'HCR032301-G19','088',1,1,NULL,'5',NULL,'5'),(116,'HCR032301-G19','124',1,1,NULL,'5',NULL,'5'),(117,'HCR032301-G19','234',1,1,NULL,'5',NULL,'5'),(118,'HCR032301-G20','072',1,1,NULL,'5',NULL,'5'),(119,'HCR032301-G21','048',1,1,NULL,'5',NULL,'5'),(120,'HCR032301-G21','225',1,1,NULL,'5',NULL,'5'),(121,'HCR032301-G21','077',1,1,NULL,'5',NULL,'5'),(122,'HCR032301-G21','034',1,1,NULL,'5',NULL,'5'),(123,'HCR032301-G21','031',1,1,NULL,'5',NULL,'5'),(124,'HCR032301-G21','263',1,1,NULL,'5',NULL,'5'),(125,'HCR032301-G21','100',1,1,NULL,'5',NULL,'5'),(126,'HCR032301-G22','030',1,1,NULL,'5',NULL,'5'),(127,'HCR032302-G01','242',1,1,NULL,'5',NULL,'5'),(128,'HCR032302-G02','043',1,1,NULL,'5',NULL,'5'),(129,'HCR032302-G03','265',1,1,NULL,'5',NULL,'5'),(130,'HCR032302-G03','281',1,1,NULL,'5',NULL,'5'),(131,'HCR032302-G04','039',1,1,NULL,'5',NULL,'5'),(132,'HCR032302-G05','024',1,1,NULL,'5',NULL,'5'),(133,'HCR032302-G05','147',1,1,NULL,'5',NULL,'5'),(134,'HCR032302-G06','292',1,1,NULL,'5',NULL,'5'),(135,'HCR032302-G07','029',1,1,NULL,'5',NULL,'5'),(136,'HCR032302-G07','087',1,1,NULL,'5',NULL,'5'),(137,'HCR032302-G07','108',1,1,NULL,'5',NULL,'5'),(138,'HCR032302-G07','114',1,1,NULL,'5',NULL,'5'),(139,'HCR032302-G07','279',1,1,NULL,'5',NULL,'5'),(140,'HCR032302-G07','167',1,1,NULL,'5',NULL,'5'),(141,'HCR032302-G07','293',1,1,NULL,'5',NULL,'5'),(142,'HCR032302-G07','267',1,1,NULL,'5',NULL,'5'),(143,'HCR032302-G07','015',1,1,NULL,'5',NULL,'5'),(144,'HCR032302-G07','009',1,1,NULL,'5',NULL,'5'),(145,'HCR032302-G07','096',1,1,NULL,'5',NULL,'5'),(146,'HCR032302-G07','282',1,1,NULL,'5',NULL,'5'),(147,'HCR032302-G08','292',1,1,NULL,'5',NULL,'5'),(148,'HCR032302-G09','132',1,1,NULL,'5',NULL,'5'),(149,'HCR032302-G09','164',1,1,NULL,'5',NULL,'5'),(150,'HCR032302-G10','039',1,1,NULL,'5',NULL,'5'),(151,'HCR032302-G11','090',1,1,NULL,'5',NULL,'5'),(152,'HCR032302-G11','240',1,1,NULL,'5',NULL,'5'),(153,'HCR032302-G12','039',1,1,NULL,'5',NULL,'5'),(154,'HCR032303-G01','242',1,1,NULL,'5',NULL,'5'),(155,'HCR032303-G02','043',1,1,NULL,'5',NULL,'5'),(156,'HCR032303-G03','292',1,1,NULL,'5',NULL,'5'),(157,'HCR032303-G03','063',1,1,NULL,'5',NULL,'5'),(158,'HCR032303-G03','039',1,1,NULL,'5',NULL,'5'),(159,'HCR032303-G04','166',1,1,NULL,'5',NULL,'5'),(160,'HCR032303-G05','062',1,1,NULL,'5',NULL,'5'),(161,'HCR032303-G06','032',1,1,NULL,'5',NULL,'5'),(162,'HCR032303-G07','121',1,1,NULL,'5',NULL,'5'),(163,'HCR032303-G08','094',1,1,NULL,'5',NULL,'5'),(164,'HCR032303-G09','242',1,1,NULL,'5',NULL,'5'),(165,'HCR032303-G10','002',1,1,NULL,'5',NULL,'5'),(166,'HCR032303-G11','016',1,1,NULL,'5',NULL,'5'),(167,'HCR032303-G12','116',1,1,NULL,'5',NULL,'5'),(168,'HCR032303-G13','072',1,1,NULL,'5',NULL,'5'),(169,'HCR032303-G14','030',1,1,NULL,'5',NULL,'5');
/*!40000 ALTER TABLE `wf_group_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wf_process`
--

DROP TABLE IF EXISTS `wf_process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wf_process` (
  `ProcessID` varchar(50) NOT NULL,
  `Process` varchar(255) NOT NULL,
  `ProcessDesc` text DEFAULT NULL,
  `CcyID` varchar(10) DEFAULT NULL,
  `LimitMin` decimal(18,2) NOT NULL DEFAULT 0.00,
  `LimitMax` decimal(18,2) NOT NULL DEFAULT 0.00,
  `EffectiveDate` date DEFAULT NULL,
  `SLADays` int(11) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputDate` datetime DEFAULT NULL,
  `InputUser` bigint(20) unsigned DEFAULT NULL,
  `ModifDate` datetime DEFAULT NULL,
  `ModifUser` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`ProcessID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wf_process`
--

LOCK TABLES `wf_process` WRITE;
/*!40000 ALTER TABLE `wf_process` DISABLE KEYS */;
INSERT INTO `wf_process` VALUES ('HCR032301','Workflow Form HCO Staff/Kabag Under Kadiv','Requester (Staff/Kabag Under Kadiv) - Kadiv Terkait / Direktur Terkait - Kabag HCGA - Kadiv HCGA','IDR',0.00,0.00,'2023-02-02',3,1,NULL,5,NULL,5),('HCR032302','Workflow Form HCO Staff/Kabag Under Direktur','Requester (Staff/Kabag Under Direktur) - Kadiv Terkait - Kabag HCGA - Kadiv HCGA','IDR',0.00,0.00,'2023-02-02',3,1,NULL,5,NULL,5),('HCR032303','Workflow Form HCO Kadiv & Direktur','Requester (Kadiv & Direktur) - Kabag HCGA - Kadiv HCGA','IDR',0.00,0.00,'2023-02-02',2,1,NULL,5,NULL,5);
/*!40000 ALTER TABLE `wf_process` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wf_process_dept`
--

DROP TABLE IF EXISTS `wf_process_dept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wf_process_dept` (
  `ProcessDeptID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ProcessID` varchar(50) NOT NULL,
  `DeptID` varchar(50) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputDate` datetime DEFAULT NULL,
  `InputUser` varchar(100) DEFAULT NULL,
  `ModifDate` datetime DEFAULT NULL,
  `ModifUser` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ProcessDeptID`),
  KEY `wf_process_dept_deptid_index` (`DeptID`),
  KEY `wf_process_dept_processid_deptid_index` (`ProcessID`,`DeptID`),
  CONSTRAINT `wf_process_dept_processid_foreign` FOREIGN KEY (`ProcessID`) REFERENCES `wf_process` (`ProcessID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wf_process_dept`
--

LOCK TABLES `wf_process_dept` WRITE;
/*!40000 ALTER TABLE `wf_process_dept` DISABLE KEYS */;
INSERT INTO `wf_process_dept` VALUES (69,'HCR032301','ACT',1,NULL,'5',NULL,'5'),(70,'HCR032301','ANR',1,NULL,'5',NULL,'5'),(71,'HCR032301','BNC',1,NULL,'5',NULL,'5'),(72,'HCR032301','GCS',1,NULL,'5',NULL,'5'),(73,'HCR032301','GFM',1,NULL,'5',NULL,'5'),(74,'HCR032301','GFP',1,NULL,'5',NULL,'5'),(75,'HCR032301','GOS',1,NULL,'5',NULL,'5'),(76,'HCR032301','GRK',1,NULL,'5',NULL,'5'),(77,'HCR032301','GRS',1,NULL,'5',NULL,'5'),(78,'HCR032301','GTY',1,NULL,'5',NULL,'5'),(79,'HCR032301','HCM',1,NULL,'5',NULL,'5'),(80,'HCR032301','HCO',1,NULL,'5',NULL,'5'),(81,'HCR032301','ITD',1,NULL,'5',NULL,'5'),(82,'HCR032301','ITI',1,NULL,'5',NULL,'5'),(83,'HCR032301','ITQ',1,NULL,'5',NULL,'5'),(84,'HCR032301','ITR',1,NULL,'5',NULL,'5'),(85,'HCR032301','ITS',1,NULL,'5',NULL,'5'),(86,'HCR032301','LAD',1,NULL,'5',NULL,'5'),(87,'HCR032301','LAS',1,NULL,'5',NULL,'5'),(88,'HCR032301','LCS',1,NULL,'5',NULL,'5'),(89,'HCR032301','LMK',1,NULL,'5',NULL,'5'),(90,'HCR032301','LPA',1,NULL,'5',NULL,'5'),(91,'HCR032301','LRS',1,NULL,'5',NULL,'5'),(92,'HCR032301','LSA',1,NULL,'5',NULL,'5'),(93,'HCR032301','LSU',1,NULL,'5',NULL,'5'),(94,'HCR032301','LUW',1,NULL,'5',NULL,'5'),(95,'HCR032301','PDS',1,NULL,'5',NULL,'5'),(96,'HCR032301','TAC',1,NULL,'5',NULL,'5'),(97,'HCR032302','IAU',1,NULL,'5',NULL,'5'),(98,'HCR032302','ANT',1,NULL,'5',NULL,'5'),(99,'HCR032302','CSC',1,NULL,'5',NULL,'5'),(100,'HCR032302','FIS',1,NULL,'5',NULL,'5'),(101,'HCR032302','FNT',1,NULL,'5',NULL,'5'),(102,'HCR032302','LGL',1,NULL,'5',NULL,'5'),(103,'HCR032302','RSM',1,NULL,'5',NULL,'5'),(104,'HCR032303','ACT',1,NULL,'5',NULL,'5'),(105,'HCR032303','ANR',1,NULL,'5',NULL,'5'),(106,'HCR032303','BNC',1,NULL,'5',NULL,'5'),(107,'HCR032303','DIR',1,NULL,'5',NULL,'5'),(108,'HCR032303','GCS',1,NULL,'5',NULL,'5'),(109,'HCR032303','GFM',1,NULL,'5',NULL,'5'),(110,'HCR032303','GFP',1,NULL,'5',NULL,'5'),(111,'HCR032303','GOS',1,NULL,'5',NULL,'5'),(112,'HCR032303','GRK',1,NULL,'5',NULL,'5'),(113,'HCR032303','GRS',1,NULL,'5',NULL,'5'),(114,'HCR032303','GTY',1,NULL,'5',NULL,'5'),(115,'HCR032303','HCM',1,NULL,'5',NULL,'5'),(116,'HCR032303','HCO',1,NULL,'5',NULL,'5'),(117,'HCR032303','IAU',1,NULL,'5',NULL,'5'),(118,'HCR032303','ITD',1,NULL,'5',NULL,'5'),(119,'HCR032303','ITI',1,NULL,'5',NULL,'5'),(120,'HCR032303','ITQ',1,NULL,'5',NULL,'5'),(121,'HCR032303','ITR',1,NULL,'5',NULL,'5'),(122,'HCR032303','ITS',1,NULL,'5',NULL,'5'),(123,'HCR032303','LAD',1,NULL,'5',NULL,'5'),(124,'HCR032303','LAS',1,NULL,'5',NULL,'5'),(125,'HCR032303','LCS',1,NULL,'5',NULL,'5'),(126,'HCR032303','LGL',1,NULL,'5',NULL,'5'),(127,'HCR032303','LMK',1,NULL,'5',NULL,'5'),(128,'HCR032303','LPA',1,NULL,'5',NULL,'5'),(129,'HCR032303','LRS',1,NULL,'5',NULL,'5'),(130,'HCR032303','LSA',1,NULL,'5',NULL,'5'),(131,'HCR032303','LSU',1,NULL,'5',NULL,'5'),(132,'HCR032303','LUW',1,NULL,'5',NULL,'5'),(133,'HCR032303','PDS',1,NULL,'5',NULL,'5'),(134,'HCR032303','PRD',1,NULL,'5',NULL,'5'),(135,'HCR032303','RSM',1,NULL,'5',NULL,'5'),(136,'HCR032303','TAC',1,NULL,'5',NULL,'5');
/*!40000 ALTER TABLE `wf_process_dept` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wf_state`
--

DROP TABLE IF EXISTS `wf_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wf_state` (
  `StateID` varchar(50) NOT NULL,
  `ProcessID` varchar(50) NOT NULL,
  `StateTypeID` varchar(20) NOT NULL,
  `StateName` varchar(255) NOT NULL,
  `StateDesc` text DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputDate` datetime DEFAULT NULL,
  `InputUser` varchar(100) DEFAULT NULL,
  `ModifDate` datetime DEFAULT NULL,
  `ModifUser` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`StateID`),
  KEY `wf_state_statetypeid_index` (`StateTypeID`),
  KEY `wf_state_processid_index` (`ProcessID`),
  CONSTRAINT `wf_state_processid_foreign` FOREIGN KEY (`ProcessID`) REFERENCES `wf_process` (`ProcessID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wf_state`
--

LOCK TABLES `wf_state` WRITE;
/*!40000 ALTER TABLE `wf_state` DISABLE KEYS */;
INSERT INTO `wf_state` VALUES ('HCR032301.1','HCR032301','STA','Penginputan Form','Penginputan Form HCO Request',1,NULL,'5',NULL,'5'),('HCR032301.2','HCR032301','NOR','Persetujuan Kadiv Terkait','Persetujuan Kadiv Terkait',1,NULL,'5',NULL,'5'),('HCR032301.3','HCR032301','NOR','Persetujuan Kabag HCGA','Persetujuan Kabag HCGA',1,NULL,'5',NULL,'5'),('HCR032301.4','HCR032301','NOR','Persetujuan Kadiv HCGA','Persetujuan Kadiv HCGA',1,NULL,'5',NULL,'5'),('HCR032301.5','HCR032301','COM','Form HCO Request Dibatalkan Oleh User','Form HCO Request Dibatalkan Oleh User',1,NULL,'5',NULL,'5'),('HCR032301.6','HCR032301','COM','Form HCO Request Ditolak','Form HCO Request Ditolak',1,NULL,'5',NULL,'5'),('HCR032301.7','HCR032301','COM','Form HCO Request Disetujui','Form HCO Request Disetujui',1,NULL,'5',NULL,'5'),('HCR032302.1','HCR032302','STA','Penginputan Form','Penginputan Form HCO Request',1,NULL,'5',NULL,'5'),('HCR032302.2','HCR032302','NOR','Persetujuan Direktur Terkait','Persetujuan Direktur Terkait',1,NULL,'5',NULL,'5'),('HCR032302.3','HCR032302','NOR','Persetujuan Kabag HCGA','Persetujuan Kabag HCGA',1,NULL,'5',NULL,'5'),('HCR032302.4','HCR032302','NOR','Persetujuan Kadiv HCGA','Persetujuan Kadiv HCGA',1,NULL,'5',NULL,'5'),('HCR032302.5','HCR032302','COM','Form HCO Request Dibatalkan Oleh User','Form HCO Request Dibatalkan Oleh User',1,NULL,'5',NULL,'5'),('HCR032302.6','HCR032302','COM','Form HCO Request Ditolak','Form HCO Request Ditolak',1,NULL,'5',NULL,'5'),('HCR032302.7','HCR032302','COM','Form HCO Request Disetujui','Form HCO Request Disetujui',1,NULL,'5',NULL,'5'),('HCR032303.1','HCR032303','STA','Penginputan Form','Penginputan Employee Infra Account Request',1,NULL,'5',NULL,'5'),('HCR032303.2','HCR032303','NOR','Persetujuan Kabag HCGA','Persetujuan Kabag HCGA',1,NULL,'5',NULL,'5'),('HCR032303.3','HCR032303','NOR','Persetujuan Kadiv HCGA','Persetujuan Kadiv HCGA',1,NULL,'5',NULL,'5'),('HCR032303.4','HCR032303','COM','Form HCO Request Dibatalkan Oleh User','Form HCO Request Dibatalkan Oleh User',1,NULL,'5',NULL,'5'),('HCR032303.5','HCR032303','COM','Form HCO Request Ditolak','Form HCO Request Ditolak',1,NULL,'5',NULL,'5'),('HCR032303.6','HCR032303','COM','Form HCO Request Disetujui','Form HCO Request Disetujui',1,NULL,'5',NULL,'5');
/*!40000 ALTER TABLE `wf_state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wf_trans_action`
--

DROP TABLE IF EXISTS `wf_trans_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wf_trans_action` (
  `TransActionID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `TransitionID` varchar(100) NOT NULL,
  `ActionID` varchar(50) NOT NULL,
  `Keterangan` text DEFAULT NULL,
  `InputDate` datetime DEFAULT NULL,
  `InputUser` varchar(100) DEFAULT NULL,
  `ModifDate` datetime DEFAULT NULL,
  `ModifUser` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`TransActionID`),
  UNIQUE KEY `wf_trans_action_transitionid_actionid_unique` (`TransitionID`,`ActionID`),
  KEY `wf_trans_action_transition_index` (`TransitionID`),
  KEY `wf_trans_action_actionid_index` (`ActionID`),
  CONSTRAINT `wf_trans_action_actionid_foreign` FOREIGN KEY (`ActionID`) REFERENCES `wf_action` (`ActionID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wf_trans_action`
--

LOCK TABLES `wf_trans_action` WRITE;
/*!40000 ALTER TABLE `wf_trans_action` DISABLE KEYS */;
INSERT INTO `wf_trans_action` VALUES (1,'HCR032301.1HCR032301.2','HCR032301-01',NULL,NULL,'5',NULL,'5'),(2,'HCR032301.1HCR032301.5','HCR032301-02',NULL,NULL,'5',NULL,'5'),(3,'HCR032301.2HCR032301.3','HCR032301-03',NULL,NULL,'5',NULL,'5'),(4,'HCR032301.2HCR032301.1','HCR032301-04',NULL,NULL,'5',NULL,'5'),(5,'HCR032301.2HCR032301.6','HCR032301-05',NULL,NULL,'5',NULL,'5'),(6,'HCR032301.3HCR032301.4','HCR032301-06',NULL,NULL,'5',NULL,'5'),(7,'HCR032301.3HCR032301.2','HCR032301-07',NULL,NULL,'5',NULL,'5'),(8,'HCR032301.3HCR032301.6','HCR032301-08',NULL,NULL,'5',NULL,'5'),(9,'HCR032301.4HCR032301.7','HCR032301-09',NULL,NULL,'5',NULL,'5'),(10,'HCR032301.4HCR032301.3','HCR032301-10',NULL,NULL,'5',NULL,'5'),(11,'HCR032301.4HCR032301.6','HCR032301-11',NULL,NULL,'5',NULL,'5'),(12,'HCR032302.1HCR032302.2','HCR032302-01',NULL,NULL,'5',NULL,'5'),(13,'HCR032302.1HCR032302.5','HCR032302-02',NULL,NULL,'5',NULL,'5'),(14,'HCR032302.2HCR032302.3','HCR032302-03',NULL,NULL,'5',NULL,'5'),(15,'HCR032302.2HCR032302.1','HCR032302-04',NULL,NULL,'5',NULL,'5'),(16,'HCR032302.2HCR032302.6','HCR032302-05',NULL,NULL,'5',NULL,'5'),(17,'HCR032302.3HCR032302.4','HCR032302-06',NULL,NULL,'5',NULL,'5'),(18,'HCR032302.3HCR032302.2','HCR032302-07',NULL,NULL,'5',NULL,'5'),(19,'HCR032302.3HCR032302.6','HCR032302-08',NULL,NULL,'5',NULL,'5'),(20,'HCR032302.4HCR032302.7','HCR032302-09',NULL,NULL,'5',NULL,'5'),(21,'HCR032302.4HCR032302.3','HCR032302-10',NULL,NULL,'5',NULL,'5'),(22,'HCR032302.4HCR032302.6','HCR032302-11',NULL,NULL,'5',NULL,'5'),(23,'HCR032303.1HCR032303.2','HCR032303-01',NULL,NULL,'5',NULL,'5'),(24,'HCR032303.1HCR032303.4','HCR032303-02',NULL,NULL,'5',NULL,'5'),(25,'HCR032303.2HCR032303.3','HCR032303-03',NULL,NULL,'5',NULL,'5'),(26,'HCR032303.2HCR032303.1','HCR032303-04',NULL,NULL,'5',NULL,'5'),(27,'HCR032303.2HCR032303.5','HCR032303-05',NULL,NULL,'5',NULL,'5'),(28,'HCR032303.3HCR032303.6','HCR032303-06',NULL,NULL,'5',NULL,'5'),(29,'HCR032303.3HCR032303.2','HCR032303-07',NULL,NULL,'5',NULL,'5'),(30,'HCR032303.3HCR032303.5','HCR032303-08',NULL,NULL,'5',NULL,'5');
/*!40000 ALTER TABLE `wf_trans_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wf_transition`
--

DROP TABLE IF EXISTS `wf_transition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wf_transition` (
  `Transition` varchar(100) NOT NULL,
  `ProcessID` varchar(50) NOT NULL,
  `CurrentStateID` varchar(50) NOT NULL,
  `NextStateID` varchar(50) NOT NULL,
  `TransitionDesc` varchar(500) DEFAULT NULL,
  `SLADays` int(11) NOT NULL DEFAULT 0,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `InputDate` datetime DEFAULT NULL,
  `InputUser` varchar(100) DEFAULT NULL,
  `ModifDate` datetime DEFAULT NULL,
  `ModifUser` varchar(100) DEFAULT NULL,
  UNIQUE KEY `wf_transition_process_state_unique` (`ProcessID`,`CurrentStateID`,`NextStateID`),
  KEY `wf_transition_processid_index` (`ProcessID`),
  KEY `wf_transition_currentstateid_index` (`CurrentStateID`),
  KEY `wf_transition_nextstateid_index` (`NextStateID`),
  CONSTRAINT `wf_transition_currentstateid_foreign` FOREIGN KEY (`CurrentStateID`) REFERENCES `wf_state` (`StateID`) ON UPDATE CASCADE,
  CONSTRAINT `wf_transition_nextstateid_foreign` FOREIGN KEY (`NextStateID`) REFERENCES `wf_state` (`StateID`) ON UPDATE CASCADE,
  CONSTRAINT `wf_transition_processid_foreign` FOREIGN KEY (`ProcessID`) REFERENCES `wf_process` (`ProcessID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wf_transition`
--

LOCK TABLES `wf_transition` WRITE;
/*!40000 ALTER TABLE `wf_transition` DISABLE KEYS */;
INSERT INTO `wf_transition` VALUES ('Penginputan Form HCO Request -> Persetujuan Kadiv Terkait (Action : Submit by Requester)','HCR032301','HCR032301.1','HCR032301.2',NULL,0,1,NULL,'5',NULL,'5'),('Penginputan Form HCO Request -> Form HCO Request Dibatalkan Oleh User (Action : Cancel by Requester)','HCR032301','HCR032301.1','HCR032301.5',NULL,0,1,NULL,'5',NULL,'5'),('Persetujuan Kadiv Terkait -> Penginputan Form HCO Request (Action : Decline by Kadiv Terkait)','HCR032301','HCR032301.2','HCR032301.1',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kadiv Terkait -> Persetujuan Kabag HCGA (Action : Approve by Kadiv Terkait)','HCR032301','HCR032301.2','HCR032301.3',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kadiv Terkait -> Form HCO Request Ditolak (Action : Cancel by Kadiv Terkait)','HCR032301','HCR032301.2','HCR032301.6',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kabag HCGA -> Persetujuan Kadiv Terkait (Action : Decline by Kabag HCGA)','HCR032301','HCR032301.3','HCR032301.2',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kabag HCGA -> Persetujuan Kadiv HCGA (Action : Approve by Kabag HCGA)','HCR032301','HCR032301.3','HCR032301.4',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kabag HCGA -> Form HCO Request Ditolak (Action : Cancel by Kabag HCGA)','HCR032301','HCR032301.3','HCR032301.6',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kadiv HCGA -> Persetujuan Kabag HCGA (Action : Decline by Kadiv HCGA)','HCR032301','HCR032301.4','HCR032301.3',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kadiv HCGA -> Form HCO Request Ditolak (Action : Cancel by Kadiv HCGA)','HCR032301','HCR032301.4','HCR032301.6',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kadiv HCGA -> Form HCO Request Disetujui (Action : Approve by Kadiv HCGA)','HCR032301','HCR032301.4','HCR032301.7',NULL,1,1,NULL,'5',NULL,'5'),('Penginputan Form HCO Request -> Persetujuan Direktur Terkait (Action : Submit by Requester)','HCR032302','HCR032302.1','HCR032302.2',NULL,0,1,NULL,'5',NULL,'5'),('Penginputan Form HCO Request -> Form HCO Request Dibatalkan Oleh User (Action : Cancel by Requester)','HCR032302','HCR032302.1','HCR032302.5',NULL,0,1,NULL,'5',NULL,'5'),('Persetujuan Direktur Terkait -> Penginputan Form HCO Request (Action : Decline by Direktur Terkait)','HCR032302','HCR032302.2','HCR032302.1',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Direktur Terkait -> Persetujuan Kabag HCGA (Action : Approve by Direktur Terkait)','HCR032302','HCR032302.2','HCR032302.3',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Direktur Terkait -> Form HCO Request Ditolak (Action : Cancel by Direktur Terkait)','HCR032302','HCR032302.2','HCR032302.6',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kabag HCGA -> Persetujuan Direktur Terkait (Action : Decline by Kabag HCGA)','HCR032302','HCR032302.3','HCR032302.2',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kabag HCGA -> Persetujuan Kadiv HCGA (Action : Approve by Kabag HCGA)','HCR032302','HCR032302.3','HCR032302.4',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kabag HCGA -> Form HCO Request Ditolak (Action : Cancel by Kabag HCGA)','HCR032302','HCR032302.3','HCR032302.6',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kadiv HCGA -> Persetujuan Kabag HCGA (Action : Decline by Kadiv HCGA)','HCR032302','HCR032302.4','HCR032302.3',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kadiv HCGA -> Form HCO Request Ditolak (Action : Cancel by Kadiv HCGA)','HCR032302','HCR032302.4','HCR032302.6',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kadiv HCGA -> Form HCO Request Disetujui (Action : Approve by Kadiv HCGA)','HCR032302','HCR032302.4','HCR032302.7',NULL,1,1,NULL,'5',NULL,'5'),('Penginputan Form HCO Request -> Persetujuan Kabag HCGA (Action : Submit by Requester)','HCR032303','HCR032303.1','HCR032303.2',NULL,0,1,NULL,'5',NULL,'5'),('Penginputan Form HCO Request -> Form HCO Request Dibatalkan Oleh User (Action : Cancel by Requester)','HCR032303','HCR032303.1','HCR032303.4',NULL,0,1,NULL,'5',NULL,'5'),('Persetujuan Kabag HCGA -> Penginputan Form HCO Request (Action : Decline by Kabag HCGA)','HCR032303','HCR032303.2','HCR032303.1',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kabag HCGA  -> Persetujuan Kadiv HCGA (Action : Approve by Kabag HCGA)','HCR032303','HCR032303.2','HCR032303.3',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kabag HCGA -> Form HCO Request Ditolak (Action : Cancel by HCGA)','HCR032303','HCR032303.2','HCR032303.5',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kadiv HCGA -> Persetujuan Kabag HCGA (Action : Decline by Kadiv HCGA)','HCR032303','HCR032303.3','HCR032303.2',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kadiv HCGA -> Form HCO Request Ditolak (Action : Cancel by Kadiv HCGA)','HCR032303','HCR032303.3','HCR032303.5',NULL,1,1,NULL,'5',NULL,'5'),('Persetujuan Kadiv HCGA -> Form HCO Request Disetujui (Action : Approve by Kadiv HCGA)','HCR032303','HCR032303.3','HCR032303.6',NULL,1,1,NULL,'5',NULL,'5');
/*!40000 ALTER TABLE `wf_transition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'enterprisehub'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-18 17:23:28
