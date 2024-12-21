-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: localhost    Database: QAirline
-- ------------------------------------------------------
-- Server version	8.0.40-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Aircrafts`
--

DROP TABLE IF EXISTS `Aircrafts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Aircrafts` (
  `AircraftID` varchar(10) NOT NULL,
  `Model` varchar(50) NOT NULL,
  `Manufacturer` varchar(50) NOT NULL,
  `YearOfManufacture` year DEFAULT NULL,
  `EconomySeat` int NOT NULL,
  `BusinessSeat` int NOT NULL,
  PRIMARY KEY (`AircraftID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Aircrafts`
--

LOCK TABLES `Aircrafts` WRITE;
/*!40000 ALTER TABLE `Aircrafts` DISABLE KEYS */;
INSERT INTO `Aircrafts` VALUES ('A1','Airbus A330','Airbus',2023,12,12),('A2','Airbus A350','Airbus',2024,20,10),('A3','Airbus A220','Airbus',2022,10,5),('A4','BelugaXL','Airbus',2024,30,30),('A5','Airbus A340','Airbus',2024,10,10),('B1','Boeing 737','Boeing',2024,12,12),('B2','Boeing 777','Boeing',2024,10,10),('B3','Boeing 747','Boeing',2024,15,10);
/*!40000 ALTER TABLE `Aircrafts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Flights`
--

DROP TABLE IF EXISTS `Flights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Flights` (
  `FlightID` int NOT NULL AUTO_INCREMENT,
  `FlightNumber` varchar(10) DEFAULT NULL,
  `DepartureCity` varchar(50) DEFAULT NULL,
  `ArrivalCity` varchar(50) DEFAULT NULL,
  `DepartureTime` datetime DEFAULT NULL,
  `AircraftID` varchar(10) NOT NULL,
  PRIMARY KEY (`FlightID`),
  UNIQUE KEY `FlightNumber` (`FlightNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Flights`
--

LOCK TABLES `Flights` WRITE;
/*!40000 ALTER TABLE `Flights` DISABLE KEYS */;
INSERT INTO `Flights` VALUES (1,'VN001','Hà Nội','Thành phố Hồ Chí Minh','2024-12-25 12:00:00','A1'),(2,'VN002','Hà Nội','Đà Nẵng','2024-12-25 11:00:00','A2'),(3,'VN003','Vinh','Hà Nội','2024-12-25 03:45:00','B1'),(4,'VN004','Hà Nội','Vinh','2024-12-29 03:00:00','B1'),(5,'QT001','Hà Nội','Tokyo','2024-12-27 10:00:00','B2'),(6,'QT002','Hà Nội','Berlin','2025-01-01 09:00:00','A3'),(7,'QT003','Tokyo','Berlin','2025-01-02 08:00:00','A4'),(8,'QT004','Đà Nẵng','Paris','2024-12-25 07:00:00','B2'),(9,'QT005','Đà Nẵng','Singapore','2024-12-27 08:00:00','B1'),(10,'VN005','Đà Nẵng','Hà Nội','2024-12-25 20:30:00','B2'),(11,'QT006','Hà Nội','New York','2025-01-01 20:00:00','A3'),(12,'QT007','New York','Hà Nội','2025-01-04 07:00:00','A4');
/*!40000 ALTER TABLE `Flights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Passengers`
--

DROP TABLE IF EXISTS `Passengers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Passengers` (
  `PassengerID` int NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `PassportNumber` varchar(20) DEFAULT NULL,
  `Nationality` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PassengerID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Passengers`
--

LOCK TABLES `Passengers` WRITE;
/*!40000 ALTER TABLE `Passengers` DISABLE KEYS */;
INSERT INTO `Passengers` VALUES (6,'Nguyễn Văn Nam','2000-12-12','demo@gmail.com','123456789',NULL,NULL),(7,'Lê Thị Hồng','1999-12-11','a@gmail.com','1986756323',NULL,NULL),(8,'Nguyễn Xuân Bách','2004-02-15','hacker@gmail.com','1111111111',NULL,NULL),(9,'Võ Trọng Dân','2004-12-12','demo@gmail.com','0915123456',NULL,NULL),(10,'Võ Trọng Dân','2024-12-12','hacker@vnu.edu.vn','0915234567',NULL,NULL),(11,'Võ Trọng Dân','2024-12-12','demo@gmail.com','0915234567',NULL,NULL);
/*!40000 ALTER TABLE `Passengers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tickets`
--

DROP TABLE IF EXISTS `Tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tickets` (
  `TicketID` int NOT NULL AUTO_INCREMENT,
  `PassengerID` int NOT NULL,
  `FlightID` int NOT NULL,
  `BookingDate` datetime NOT NULL,
  `SeatNumber` varchar(5) DEFAULT NULL,
  `Class` enum('Economy','Business') NOT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `ReturnFlightID` int DEFAULT NULL,
  `ReturnClass` enum('Economy','Business') DEFAULT NULL,
  PRIMARY KEY (`TicketID`),
  KEY `PassengerID` (`PassengerID`),
  KEY `FlightID` (`FlightID`),
  CONSTRAINT `Tickets_ibfk_1` FOREIGN KEY (`PassengerID`) REFERENCES `Passengers` (`PassengerID`),
  CONSTRAINT `Tickets_ibfk_2` FOREIGN KEY (`FlightID`) REFERENCES `Flights` (`FlightID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tickets`
--

LOCK TABLES `Tickets` WRITE;
/*!40000 ALTER TABLE `Tickets` DISABLE KEYS */;
INSERT INTO `Tickets` VALUES (3,6,3,'2024-12-20 23:58:19',NULL,'Business',NULL,NULL,NULL),(4,7,2,'2024-12-21 09:34:40',NULL,'Business',NULL,NULL,NULL),(5,8,3,'2024-12-21 10:57:38',NULL,'Economy',NULL,NULL,NULL),(6,9,3,'2024-12-21 19:27:25',NULL,'Business',NULL,4,'Business'),(7,10,3,'2024-12-21 20:57:19',NULL,'Business',NULL,4,'Economy'),(8,10,10,'2024-12-21 20:58:52',NULL,'Economy',NULL,NULL,NULL),(9,11,2,'2024-12-21 21:09:59',NULL,'Business',NULL,NULL,NULL),(10,11,3,'2024-12-21 21:11:11',NULL,'Economy',NULL,4,'Economy'),(11,11,11,'2024-12-21 21:16:28',NULL,'Business',NULL,12,'Business');
/*!40000 ALTER TABLE `Tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin','$2y$12$5SkCOyT234NJXXug9G6FKuZ9yYNIyILfWIQ0T9m0mppaeh0wW/Eba');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-21 21:48:57
