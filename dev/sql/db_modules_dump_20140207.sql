-- MySQL dump 10.13  Distrib 5.5.34, for Win32 (x86)
--
-- Host: localhost    Database: modules
-- ------------------------------------------------------
-- Server version	5.5.34

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

DROP DATABASE IF EXISTS `modules`;

CREATE DATABASE `modules`;

USER `modules`;

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorie` (
  `categorie_libelle` varchar(20) NOT NULL,
  `idCategorie` char(1) NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie`
--

LOCK TABLES `categorie` WRITE;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` VALUES ('Générale','A'),('Système et Réseau','B'),('Développement','C'),('Projet','D');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modalite`
--

DROP TABLE IF EXISTS `modalite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modalite` (
  `idModalite` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `modalite_libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`idModalite`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modalite`
--

LOCK TABLES `modalite` WRITE;
/*!40000 ALTER TABLE `modalite` DISABLE KEYS */;
INSERT INTO `modalite` VALUES (1,'Dictée'),(2,'Exercices rédactionnels rapides'),(3,'Exercices pratiques');
/*!40000 ALTER TABLE `modalite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `idModule` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `intitule_module` varchar(255) NOT NULL,
  `objectifs` text NOT NULL,
  `duree` float unsigned NOT NULL,
  `public` text NOT NULL,
  `prerequis` text,
  `programme` text NOT NULL,
  `Niveau_idNiveau` int(10) unsigned NOT NULL,
  `Categorie_idCategorie` char(1) NOT NULL,
  PRIMARY KEY (`idModule`),
  KEY `Niveau_idNiveau` (`Niveau_idNiveau`),
  KEY `Categorie_idCategorie` (`Categorie_idCategorie`),
  CONSTRAINT `module_ibfk_1` FOREIGN KEY (`Niveau_idNiveau`) REFERENCES `niveau` (`idNiveau`),
  CONSTRAINT `module_ibfk_2` FOREIGN KEY (`Categorie_idCategorie`) REFERENCES `categorie` (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,'Ecrire une lettre de motivation','Savoir se prÃ©senter et se vendre',1,'Tout public','Savoir Ã©crire','Structure d\'une lettre de motivation\r\nLes points Ã  mettre en avant\r\nLes erreurs Ã  ne pas commettre',1,'A'),(2,'TCP/IP','Comprendre le fonctionnement d\'un rÃ©seau',2,'Tout public','','Les couches OSI\r\nl\'adressage IP V4 et V6',1,'B'),(3,'Algorithmie','Comprendre la mentalitÃ© d\'un developpeur',5,'Tout public','','Algo, algo et encore algo',1,'C');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_has_modalite`
--

DROP TABLE IF EXISTS `module_has_modalite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_has_modalite` (
  `Module_idModule` int(10) unsigned NOT NULL,
  `Modalite_idModalite` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Module_idModule`,`Modalite_idModalite`),
  KEY `Modalite_idModalite` (`Modalite_idModalite`),
  CONSTRAINT `module_has_modalite_ibfk_1` FOREIGN KEY (`Module_idModule`) REFERENCES `module` (`idModule`),
  CONSTRAINT `module_has_modalite_ibfk_2` FOREIGN KEY (`Modalite_idModalite`) REFERENCES `modalite` (`idModalite`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_has_modalite`
--

LOCK TABLES `module_has_modalite` WRITE;
/*!40000 ALTER TABLE `module_has_modalite` DISABLE KEYS */;
INSERT INTO `module_has_modalite` VALUES (1,3),(2,3),(3,3);
/*!40000 ALTER TABLE `module_has_modalite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `niveau`
--

DROP TABLE IF EXISTS `niveau`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `niveau` (
  `idNiveau` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `niveau_libelle` varchar(20) NOT NULL,
  PRIMARY KEY (`idNiveau`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `niveau`
--

LOCK TABLES `niveau` WRITE;
/*!40000 ALTER TABLE `niveau` DISABLE KEYS */;
INSERT INTO `niveau` VALUES (1,'Débutant'),(2,'Confirmé'),(3,'Expert');
/*!40000 ALTER TABLE `niveau` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-07 13:50:08
