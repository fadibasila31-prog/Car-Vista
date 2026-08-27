-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 27, 2026 at 12:58 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carvista`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `BookingId` int NOT NULL AUTO_INCREMENT,
  `CustomerId` int NOT NULL,
  `VehicleId` int NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `Status` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TotalPrice` decimal(10,2) NOT NULL,
  `RatingStatus` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`BookingId`),
  KEY `CustomerId` (`CustomerId`),
  KEY `CarId` (`VehicleId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`BookingId`, `CustomerId`, `VehicleId`, `StartDate`, `EndDate`, `Status`, `CreatedAt`, `UpdatedAt`, `TotalPrice`, `RatingStatus`) VALUES
(1, 3, 15, '2026-08-28', '2026-09-10', 'Waiting', '2026-08-19 08:03:05', '2026-08-19 08:03:05', 2520.00, 'Not Rated'),
(2, 1, 1, '2025-08-28', '2025-09-10', 'Finished', '2026-08-19 08:18:23', '2026-08-19 08:18:23', 2100.00, 'Rated'),
(3, 1, 12, '2025-12-17', '2025-12-24', 'Finished', '2026-08-19 08:28:41', '2026-08-19 08:28:41', 3040.00, 'Rated'),
(4, 2, 6, '2026-08-21', '2026-09-03', 'Active', '2026-08-19 09:35:13', '2026-08-19 09:35:13', 3220.00, 'Not Rated'),
(5, 5, 16, '2026-10-28', '2027-01-08', 'Waiting', '2026-08-19 09:37:36', '2026-08-19 09:37:36', 26280.00, 'Not Rated'),
(6, 7, 11, '2024-08-20', '2024-09-08', 'Finished', '2026-08-19 09:39:44', '2026-08-19 09:39:44', 6400.00, 'Rated');

-- --------------------------------------------------------

--
-- Table structure for table `referense`
--

DROP TABLE IF EXISTS `referense`;
CREATE TABLE IF NOT EXISTS `referense` (
  `ReferenceId` int NOT NULL AUTO_INCREMENT,
  `CustomerId` int NOT NULL,
  `Subject` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Conversation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LastUpdated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `HandledBy` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ReferenceId`),
  KEY `CustomerId` (`CustomerId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referense`
--

INSERT INTO `referense` (`ReferenceId`, `CustomerId`, `Subject`, `Conversation`, `Status`, `Created`, `LastUpdated`, `HandledBy`) VALUES
(1, 3, 'Payment issue', '[20-08-2026 10:15]John Smith: I tried to complete the payment for my reservation, but the payment was not processed.\r\n[20-08-2026 10:22]Bahaa Bader: Hello John, I will check the payment details and get back to you.\r\n[20-08-2026 10:30]John Smith: Thank you. I will wait for your response.', 1, '2026-08-01 18:41:54', '2026-08-20 10:30:00', 'Worker'),
(2, 8, 'Vehicle information', '[20-08-2026 11:05]James Anderson: I would like to know if you have an SUV available for my rental dates.\r\n[20-08-2026 11:12]Bahaa Bader: Hello James, we currently have several SUV vehicles available. I can help you find one that matches your requirements.\r\n[20-08-2026 11:18]James Anderson: I am looking for a vehicle for four passengers. Thank you.', 1, '2026-08-01 18:41:54', '2026-08-20 11:18:00', 'Worker'),
(3, 3, 'Cancel reservation', '[20-08-2026 12:40]John Smith: I would like to cancel my current vehicle reservation. Could you please tell me if there is a cancellation fee?\n[20-08-2026 12:48]Fadi Basila: Hello John, I will check your reservation and the cancellation conditions.\n[20-08-2026 13:02]John Smith: Thank you. Please let me know when you have more information.', 0, '2026-08-01 18:41:54', '2026-08-20 13:02:00', 'Manager'),
(4, 7, 'Change rental dates', '[19-08-2026 14:10]David Taylor: I selected the wrong rental dates when making my reservation. I would like to change them if possible.\r\n[19-08-2026 14:18]Bahaa Bader: I can help you with that. Please provide the correct pickup and return dates.\r\n[19-08-2026 14:25]David Taylor: I would like to change the pickup date to 28-08-2026 and the return date to 05-09-2026.', 0, '2026-08-01 18:41:54', '2026-08-19 14:25:00', 'Worker'),
(5, 4, 'Login problem', '[20-08-2026 15:30]Emily Johnson: I am unable to log in to my account even though I am using my correct password.\r\n[20-08-2026 15:38]Fadi Basila: Hello Emily, I will check your account status and see what is causing the problem.\r\n[20-08-2026 15:47]Emily Johnson: Okay, thank you for your help.', 1, '2026-08-01 18:41:54', '2026-08-20 15:47:00', 'Manager'),
(6, 5, 'Vehicle condition', '[19-08-2026 16:05]Michael Brown: I noticed a problem with the vehicle after returning it. I would like to report the issue.\r\n[19-08-2026 16:14]Fadi Basila: Thank you for letting us know. Please provide more details about the problem you noticed.\r\n[19-08-2026 16:25]Michael Brown: There is a small issue with the rear door. I noticed it when I returned the vehicle.', 0, '2026-08-01 18:41:54', '2026-08-19 16:25:00', 'Manager'),
(7, 6, 'Reservation information', '[21-08-2026 09:20]Sarah Wilson: I would like to confirm the details of my reservation, including the pickup location and rental dates.\r\n[21-08-2026 09:28]Bahaa Bader: Your reservation is registered in the system. The pickup location and rental dates are available in your reservation details.\r\n[21-08-2026 09:35]Sarah Wilson: Great, thank you for the information.', 1, '2026-08-01 18:41:54', '2026-08-21 09:35:00', 'Worker'),
(8, 3, 'Rental conditions', '[18-08-2026 13:40]John Smith: Could you please explain the requirements for renting a vehicle?\r\n[18-08-2026 13:48]Fadi Basila: You need a valid driving license and the required identification documents. The rental conditions also depend on the selected vehicle.\r\n[18-08-2026 13:55]John Smith: Thank you. That answers my question.', 1, '2026-08-01 18:41:54', '2026-08-18 13:55:00', 'Manager'),
(9, 3, 'Change reservation', '[21-08-2026 18:10]John Smith: I would like to change the vehicle in my current reservation. Is it possible to select another vehicle?\n[21-08-2026 18:16]Bahaa Bader: Hello John, I will check which vehicles are available for your reservation dates.\n[21-08-2026 18:24]John Smith: Thank you. I would prefer a vehicle with an automatic gearbox if one is available.', 0, '2026-08-21 18:27:39', '2026-08-21 18:24:00', 'Worker');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `LastName` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Gmail` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdNumber` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password1` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password2` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Password3` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HaveDriverLicense` tinyint(1) NOT NULL DEFAULT '0',
  `Blocked` tinyint(1) NOT NULL DEFAULT '0',
  `FailedTimes` int NOT NULL DEFAULT '0',
  `BirthDay` date NOT NULL,
  `PhoneNumber` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Role` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `StartTimeExpired` datetime DEFAULT NULL,
  `EndTimeExpired` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `FirstName`, `LastName`, `Gmail`, `IdNumber`, `Password`, `Password1`, `Password2`, `Password3`, `HaveDriverLicense`, `Blocked`, `FailedTimes`, `BirthDay`, `PhoneNumber`, `Role`, `StartTimeExpired`, `EndTimeExpired`) VALUES
(1, 'Fadi', 'Basila', 'fadibasila31@gmail.com', '123456789', 'Fadi123', 'Fadi123', 'Fadi1234', 'Fadi12345', 1, 0, 0, '2000-01-01', '0505773735', 'Manager', '2026-08-21 18:30:02', '2026-08-21 18:28:45'),
(2, 'Bahaa', 'Bader', 'bahaab100705@gmail.com', '987654321', 'Bahaa123', 'Bahaa123', 'Bahaa1234', 'Bahaa12345', 1, 0, 0, '2004-08-26', '0504785962', 'Worker', '2026-08-21 18:30:02', NULL),
(3, 'John', 'Smith', 'john.smith@gmail.com', '152478596', 'Johnsmith123', 'Johnsmith123', 'Johnsmith1234', 'Johnsmith12345', 1, 0, 0, '2000-06-24', '0501111111', 'Customer', '2026-08-21 18:30:02', NULL),
(4, 'Emily', 'Johnson', 'emily.johnson@gmail.com', '234567891', 'Emilyjohnson123', 'Emilyjohnson123', 'Emilyjohnson1234', 'Emilyjohnson12345', 0, 1, 3, '2000-07-25', '0502222222', 'Customer', '2026-08-21 18:30:02', NULL),
(5, 'Michael', 'Brown', 'michael.brown@gmail.com', '345678912', 'Michaelbrown123', 'Michaelbrown123', 'Michaelbrown1234', 'Michaelbrown12345', 1, 0, 0, '1995-11-03', '0503333333', 'Customer', '2026-08-21 18:30:02', NULL),
(6, 'Sarah', 'Wilson', 'sarah.wilson@gmail.com', '456789123', 'Sarahwilson123', 'Sarahwilson123', 'Sarahwilson1234', 'Sarahwilson12345', 0, 0, 0, '1999-02-18', '0504444444', 'Customer', '2026-08-21 18:30:02', NULL),
(7, 'David', 'Taylor', 'david.taylor@gmail.com', '567891234', 'Davidtaylor123', 'Davidtaylor123', 'Davidtaylor1234', 'Davidtaylor12345', 1, 0, 0, '1988-09-30', '0505555555', 'Customer', '2026-08-21 18:30:02', NULL),
(8, 'James', 'Anderson', 'james.anderson@gmail.com', '678912345', 'Jamesanderson123', 'Jamesanderson123', 'Jamesanderson1234', 'Jamesanderson12345', 1, 1, 3, '1985-12-05', '0506666666', 'Customer', '2026-08-21 18:30:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE IF NOT EXISTS `vehicle` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `VehicleType` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NumberPlate` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `VehicleBrand` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Image` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PricePerDay` decimal(10,2) NOT NULL,
  `GearBox` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Seats` int NOT NULL,
  `Doors` int NOT NULL,
  `DriveStyle` tinyint(1) NOT NULL DEFAULT '0',
  `Miles` decimal(10,3) NOT NULL,
  `Color` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Convertible` tinyint(1) NOT NULL DEFAULT '0',
  `EnergyType` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `HorsePower` int NOT NULL,
  `VehicleName` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `MaxSpeed` int NOT NULL,
  `DriveType` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TankSize` int NOT NULL,
  `AirConditioner` tinyint(1) NOT NULL DEFAULT '0',
  `VehicleInside1` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `VehicleInside2` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `VehicleInside3` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `VehicleInside4` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Branch` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `VehicleLogo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Rating` int NOT NULL,
  `TotalRating` int NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`Id`, `VehicleType`, `NumberPlate`, `VehicleBrand`, `Image`, `PricePerDay`, `GearBox`, `Seats`, `Doors`, `DriveStyle`, `Miles`, `Color`, `Convertible`, `EnergyType`, `HorsePower`, `VehicleName`, `MaxSpeed`, `DriveType`, `TankSize`, `AirConditioner`, `VehicleInside1`, `VehicleInside2`, `VehicleInside3`, `VehicleInside4`, `Branch`, `VehicleLogo`, `Rating`, `TotalRating`) VALUES
(1, 'Car', '100-01-001', 'Volkswagen', 'Car1.png', 150.00, 'Automatic', 5, 4, 1, 45000.000, 'Silver', 1, 'Gas', 130, 'Volkswagen', 190, 'FWD', 100, 1, 'Car1.1.png', 'Car1.2.png', 'Car1.3.png', 'Car1.3.png', 'Haifa', 'Volkswagen.png', 4, 2),
(2, 'Car', '100-01-002', 'Volkswagen', 'Car2.png', 170.00, 'Automatic', 5, 4, 0, 38000.000, 'Brown', 0, 'Gas', 140, 'Volkswagen', 200, 'FWD', 47, 1, 'Car2.1.png', 'Car2.2.png', 'Car2.3.png', 'Car2.4.png', 'Tel Aviv', 'Volkswagen.png', 0, 0),
(3, 'Car', '100-01-003', 'Fiat', 'Car3.png', 350.00, 'Automatic', 4, 2, 0, 25000.000, 'Black', 1, 'Gas', 250, 'Fiat 500', 250, 'RWD', 60, 0, 'Car3.1.png', 'Car3.2.png', 'Car3.3.png', 'Car3.4.png', 'Jerusalem', 'Fiat500.png', 0, 0),
(4, 'Car', '100-01-004', 'Cupra Leon', 'Car4.png', 400.00, 'Automatic', 5, 4, 1, 22000.000, 'Dark Blue', 1, 'Gas', 270, 'Cupra Leon', 260, 'RWD', 65, 1, 'Car4.1.png', 'Car4.2.png', 'Car4.3.png', 'Car4.4.png', 'Haifa', 'CupraLeon.png', 0, 0),
(5, 'Car', '100-01-005', 'Opel Corsa', 'Car5.png', 220.00, 'Manual', 5, 4, 1, 50000.000, 'Gray', 0, 'Gas', 180, 'Opel Corsa', 210, 'AWD', 60, 1, 'Car5.1.png', 'Car5.2.png', 'Car5.3.png', 'Car5.4.png', 'Jerusalem', 'OpelCorsa.png', 0, 0),
(6, 'Car', '100-01-006', 'Peugeot', 'Car6.png', 230.00, 'Automatic', 5, 4, 1, 42000.000, 'Dark Blue', 0, 'Gas', 190, 'Peugeot 3008', 215, 'AWD', 62, 1, 'Car6.1.png', 'Car6.2.png', 'Car6.3.png', 'Car6.4.png', 'Haifa', 'Peugeot3008.png', 0, 0),
(7, 'Car', '100-01-007', 'Opel Corsa', 'Car7.png', 240.00, 'Automatic', 5, 4, 0, 39000.000, 'Red', 0, 'Gas', 160, 'Opel Corsa', 200, 'FWD', 55, 0, 'Car7.1.png', 'Car7.2.png', 'Car7.3.png', 'Car7.4.png', 'Tel Aviv', 'OpelCorsa.png', 0, 0),
(8, 'Car', '100-01-008', 'Skoda', 'Car8.png', 260.00, 'Manual', 5, 4, 1, 35000.000, 'Blue', 0, 'Gas', 190, 'Skoda', 220, 'AWD', 150, 1, 'Car8.1.png', 'Car8.2.png', 'Car8.3.png', 'Car8.4.png', 'Jerusalem', 'Skoda.png', 0, 0),
(9, 'Car', '100-01-009', 'Citroën', 'Car9.png', 300.00, 'Automatic', 8, 5, 0, 70000.000, 'White', 0, 'Hybrid', 200, 'Citroën', 180, 'RWD', 80, 1, 'Car9.1.png', 'Car9.2.png', 'Car9.3.png', 'Car9.4.png', 'Haifa', 'Citroën.png', 0, 0),
(10, 'Car', '100-01-010', 'Jeep', 'Car10.png', 330.00, 'Automatic', 8, 5, 1, 55000.000, 'Gray', 0, 'Hybrid', 220, 'Jeep', 200, 'FWD', 150, 1, 'Car10.1.png', 'Car10.2.png', 'Car10.3.png', 'Car10.4.png', 'Tel Aviv', 'Jeep.png', 0, 0),
(11, 'Van', '100-01-011', 'Toyota', 'Van1.png', 320.00, 'Manual', 10, 4, 0, 30000.000, 'White', 0, 'Gas', 220, 'Toyota', 240, 'AWD', 55, 1, 'Van1.1.png', 'Van1.2.png', 'Van1.3.png', 'Van1.4.png', 'Jerusalem', 'Toyota.png', 3, 1),
(12, 'Van', '100-01-012', 'Mercedes', 'Van2.png', 380.00, 'Automatic', 7, 3, 1, 15000.000, 'Black', 0, 'Electric', 300, 'Mercedes-Benz', 260, 'AWD', 0, 1, 'Van2.1.png', 'Van2.2.png', 'Van2.3.png', 'Van2.4.png', 'Haifa', 'Mercedes.png', 5, 1),
(13, 'Van', '100-01-013', 'Nissan', 'Van3.png', 350.00, 'Manual', 12, 3, 0, 60000.000, 'Red', 1, 'Gas', 280, 'Nissan', 230, '4WD', 70, 1, 'Van3.1.png', 'Van3.2.png', 'Van3.3.png', 'Van3.4.png', 'Jerusalem', 'Nissan.png', 0, 0),
(14, 'Van', '100-01-014', 'Nissan', 'Van4.png', 140.00, 'Automatic', 8, 2, 0, 65000.000, 'White', 0, 'Gas', 125, 'Nissan', 190, 'FWD', 100, 1, 'Van4.1.png', 'Van4.2.png', 'Van4.3.png', 'Van4.4.png', 'Haifa', 'Nissan.png', 0, 0),
(15, 'Van', '100-01-015', 'Mercedes', 'Van5.png', 180.00, 'Manual', 11, 3, 0, 40000.000, 'Light Gray', 0, 'Gas', 150, 'Mercedes-Benz', 210, 'FWD', 50, 1, 'Van5.1.png', 'Van5.2.png', 'Van5.3.png', 'Van5.4.png', 'Tel Aviv', 'Mercedes.png', 0, 0),
(16, 'Van', '100-01-016', 'Mercedes', 'Van6.png', 360.00, 'Automatic', 11, 3, 0, 28000.000, 'Black & White', 0, 'Gas', 250, 'Mercedes-Benz', 240, 'AWD', 150, 1, 'Van6.1.png', 'Van6.2.png', 'Van6.3.png', 'Van6.4.png', 'Jerusalem', 'Mercedes.png', 0, 0),
(17, 'Van', '100-01-017', 'Audi', 'Van7.png', 200.00, 'Automatic', 13, 3, 0, 52000.000, 'White', 0, 'Gas', 160, 'Audi', 200, 'FWD', 100, 1, 'Van7.1.png', 'Van7.2.png', 'Van7.3.png', 'Van7.4.png', 'Haifa', 'Audi.png', 0, 0),
(18, 'Van', '100-01-018', 'Audi', 'Van8.png', 500.00, 'Automatic', 8, 3, 1, 20000.000, 'Black', 0, 'Gas', 350, 'Land Audi', 280, 'AWD', 90, 1, 'Van8.1.png', 'Van8.2.png', 'Van8.3.png', 'Van8.4.png', 'Tel Aviv', 'Audi.png', 0, 0),
(19, 'Van', '100-01-019', 'BMW', 'Van9.png', 210.00, 'Manual', 17, 3, 0, 80000.000, 'Black', 0, 'Hybrid', 120, 'BMW', 170, 'FWD', 100, 1, 'Van9.1.png', 'Van9.2.png', 'Van9.3.png', 'Van9.4.png', 'Haifa', 'BMW.png', 0, 0),
(20, 'Van', '100-01-020', 'Ford', 'Van10.png', 700.00, 'Automatic', 10, 2, 0, 10000.000, 'White', 1, 'Gas', 450, 'Ford', 320, 'RWD', 67, 1, 'Van10.1.png', 'Van10.2.png', 'Van10.3.png', 'Van10.4.png', 'Jerusalem', 'Ford.png', 0, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `FK_Booking_Users` FOREIGN KEY (`CustomerId`) REFERENCES `users` (`Id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_Booking_Vehicles` FOREIGN KEY (`VehicleId`) REFERENCES `vehicle` (`Id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `referense`
--
ALTER TABLE `referense`
  ADD CONSTRAINT `FK_Referense_Users` FOREIGN KEY (`CustomerId`) REFERENCES `users` (`Id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
