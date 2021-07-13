-- MySQL dump 10.13  Distrib 8.0.25, for Win64 (x86_64)
--
-- Host: localhost    Database: oriteddies
-- ------------------------------------------------------
-- Server version	8.0.22

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `couleur`
--

DROP TABLE IF EXISTS `couleur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `couleur` (
  `id_couleur` int NOT NULL AUTO_INCREMENT,
  `couleur` varchar(20) NOT NULL,
  PRIMARY KEY (`id_couleur`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `couleur`
--

LOCK TABLES `couleur` WRITE;
/*!40000 ALTER TABLE `couleur` DISABLE KEYS */;
INSERT INTO `couleur` VALUES (1,'Brun'),(2,'Brun foncé'),(3,'Brun clair'),(4,'Noir'),(5,'Beige'),(6,'Blanc'),(7,'Bleu'),(8,'Rose');
/*!40000 ALTER TABLE `couleur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `price` int DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `imageUrl` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit`
--

LOCK TABLES `produit` WRITE;
/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
INSERT INTO `produit` VALUES (1,'Norbert',29,'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis vero veniam, exercitationem maiores, reiciendis expedita inventore quo fugit culpa omnis officia architecto ullam iure? Dignissimos expedita corporis hic repudiandae autem!','teddy_1.jpg'),(2,'Arnold',39,'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis vero veniam, exercitationem maiores, reiciendis expedita inventore quo fugit culpa omnis officia architecto ullam iure? Dignissimos expedita corporis hic repudiandae autem!','teddy_2.jpg'),(3,'Lenny and Carl',59,'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis vero veniam, exercitationem maiores, reiciendis expedita inventore quo fugit culpa omnis officia architecto ullam iure? Dignissimos expedita corporis hic repudiandae autem!','teddy_3.jpg'),(4,'Gustav',45,'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis vero veniam, exercitationem maiores, reiciendis expedita inventore quo fugit culpa omnis officia architecto ullam iure? Dignissimos expedita corporis hic repudiandae autem!','teddy_4.jpg'),(5,'Garfunkel',55,'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis vero veniam, exercitationem maiores, reiciendis expedita inventore quo fugit culpa omnis officia architecto ullam iure? Dignissimos expedita corporis hic repudiandae autem!','teddy_5.jpg');
/*!40000 ALTER TABLE `produit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produit_couleur`
--

DROP TABLE IF EXISTS `produit_couleur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produit_couleur` (
  `id` int NOT NULL,
  `id_couleur` int NOT NULL,
  PRIMARY KEY (`id`,`id_couleur`),
  KEY `FK_COULEUR_PRODUIT_COULEUR_idx` (`id_couleur`),
  CONSTRAINT `FK_COULEUR_PRODUIT_COULEUR` FOREIGN KEY (`id_couleur`) REFERENCES `couleur` (`id_couleur`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_PRODUIT_PRODUIT_COULEUR` FOREIGN KEY (`id`) REFERENCES `produit` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produit_couleur`
--

LOCK TABLES `produit_couleur` WRITE;
/*!40000 ALTER TABLE `produit_couleur` DISABLE KEYS */;
INSERT INTO `produit_couleur` VALUES (1,1),(3,1),(4,1),(5,1),(2,2),(2,3),(1,4),(5,4),(5,5),(1,6),(2,6),(4,7),(4,8);
/*!40000 ALTER TABLE `produit_couleur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-20 18:38:17
