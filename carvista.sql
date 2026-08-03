-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 03, 2026 at 05:33 PM
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
  `StartDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `Status` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TotalPrice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`BookingId`),
  KEY `CustomerId` (`CustomerId`),
  KEY `CarId` (`VehicleId`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`BookingId`, `CustomerId`, `VehicleId`, `StartDate`, `EndDate`, `Status`, `CreatedAt`, `UpdatedAt`, `TotalPrice`) VALUES
(1, 1, 3, '2026-08-05 10:00:00', '2026-08-10 10:00:00', 'Confirmed', '2026-08-01 16:00:00', '2026-08-10 07:00:00', 750.00),
(2, 5, 4, '2026-08-12 09:00:00', '2026-08-15 09:00:00', 'Confirmed', '2026-08-01 16:05:00', '2026-08-01 16:05:00', 1200.00),
(3, 6, 11, '2026-08-20 12:00:00', '2026-08-25 12:00:00', 'Confirmed', '2026-08-01 16:10:00', '2026-08-01 16:10:00', 1600.00),
(4, 7, 18, '2026-08-03 08:00:00', '2026-08-06 08:00:00', 'In Use', '2026-08-01 16:15:00', '2026-08-02 06:00:00', 1500.00),
(5, 8, 20, '2026-09-01 14:00:00', '2026-09-07 14:00:00', 'Confirmed', '2026-08-01 16:20:00', '2026-08-01 16:20:00', 4200.00),
(6, 3, 7, '2026-09-10 10:00:00', '2026-09-12 10:00:00', 'Confirmed', '2026-08-01 16:25:00', '2026-09-12 07:00:00', 480.00),
(7, 5, 13, '2026-09-15 09:30:00', '2026-09-20 09:30:00', 'Confirmed', '2026-08-01 16:30:00', '2026-08-01 16:30:00', 1750.00),
(8, 6, 16, '2026-10-01 11:00:00', '2026-10-05 11:00:00', 'Confirmed', '2026-08-01 16:35:00', '2026-08-01 16:35:00', 1440.00);

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referense`
--

INSERT INTO `referense` (`ReferenceId`, `CustomerId`, `Subject`, `Conversation`, `Status`, `Created`, `LastUpdated`, `HandledBy`) VALUES
(1, 3, 'Payment problem', 'Customer cannot complete payment for reservation.', 1, '2026-08-01 18:41:54', '2026-08-01 18:41:54', 'Worker'),
(2, 8, 'Vehicle question', 'Customer asked about available SUV vehicles.', 1, '2026-08-01 18:41:54', '2026-08-01 18:41:54', 'Worker'),
(3, 3, 'Cancel booking', 'Customer requested cancellation of booking.', 1, '2026-08-01 18:41:54', '2026-08-01 18:41:54', 'Manager'),
(4, 7, 'Wrong date', 'Customer selected incorrect rental dates.', 0, '2026-08-01 18:41:54', '2026-08-01 18:41:54', 'Worker'),
(5, 4, 'Account problem', 'Customer cannot login to account.', 1, '2026-08-01 18:41:54', '2026-08-01 18:41:54', 'Manager'),
(6, 5, 'Vehicle damage report', 'Customer reported a problem with returned vehicle.', 0, '2026-08-01 18:41:54', '2026-08-01 18:41:54', 'Manager'),
(7, 6, 'Reservation details', 'Customer needs more information about reservation.', 1, '2026-08-01 18:41:54', '2026-08-01 18:41:54', 'Worker'),
(8, 3, 'General question', 'Customer asked about rental conditions.', 0, '2026-08-01 18:41:54', '2026-08-01 18:41:54', 'Manager');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `FirstName`, `LastName`, `Gmail`, `IdNumber`, `Password`, `Password1`, `Password2`, `Password3`, `HaveDriverLicense`, `Blocked`, `FailedTimes`, `BirthDay`, `PhoneNumber`, `Role`, `StartTimeExpired`, `EndTimeExpired`) VALUES
(1, 'Fadi', 'Basila', 'fadibasila31@gmail.com', '123456789', 'Fadi123', 'Fadi123', 'Fadi1234', 'Fadi12345', 1, 0, 0, '2000-08-01', '0502478596', 'Manager', '2026-08-01 22:54:35', '2026-08-01 22:38:32'),
(2, 'Bahaa', 'Bader', 'bahaab100705@gmail.com', '987654321', 'Bahaa123', 'Bahaa123', 'Bahaa1234', 'Bahaa12345', 1, 0, 0, '2004-08-26', '0504785962', 'Worker', '2026-08-01 22:54:35', NULL),
(3, 'John', 'Smith', 'john.smith@gmail.com', '152478596', 'Johnsmith123', 'Johnsmith123', 'Johnsmith1234', 'Johnsmith12345', 1, 0, 0, '1998-04-12', '0501111111', 'Customer', '2026-08-01 22:54:35', NULL),
(4, 'Emily', 'Johnson', 'emily.johnson@gmail.com', '234567891', 'Emilyjohnson123', 'Emilyjohnson123', 'Emilyjohnson1234', 'Emilyjohnson12345', 0, 1, 3, '2000-07-25', '0502222222', 'Customer', '2026-08-01 22:54:35', NULL),
(5, 'Michael', 'Brown', 'michael.brown@gmail.com', '345678912', 'Michaelbrown123', 'Michaelbrown123', 'Michaelbrown1234', 'Michaelbrown12345', 1, 0, 0, '1995-11-03', '0503333333', 'Customer', '2026-08-01 22:54:35', NULL),
(6, 'Sarah', 'Wilson', 'sarah.wilson@gmail.com', '456789123', 'Sarahwilson123', 'Sarahwilson123', 'Sarahwilson1234', 'Sarahwilson12345', 0, 0, 0, '1999-02-18', '0504444444', 'Customer', '2026-08-01 22:54:35', NULL),
(7, 'David', 'Taylor', 'david.taylor@gmail.com', '567891234', 'Davidtaylor123', 'Davidtaylor123', 'Davidtaylor1234', 'Davidtaylor12345', 1, 0, 2, '1988-09-30', '0505555555', 'Customer', '2026-08-01 22:54:35', NULL),
(8, 'James', 'Anderson', 'james.anderson@gmail.com', '678912345', 'Jamesanderson123', 'Jamesanderson123', 'Jamesanderson1234', 'Jamesanderson12345', 1, 1, 3, '1985-12-05', '0506666666', 'Customer', '2026-08-01 22:54:35', NULL);

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
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`Id`, `VehicleType`, `NumberPlate`, `VehicleBrand`, `Image`, `PricePerDay`, `GearBox`, `Seats`, `Doors`, `DriveStyle`, `Miles`, `Color`, `Convertible`, `EnergyType`, `HorsePower`, `VehicleName`, `MaxSpeed`, `DriveType`, `TankSize`, `AirConditioner`, `VehicleInside1`, `VehicleInside2`, `VehicleInside3`, `VehicleInside4`, `Branch`, `VehicleLogo`) VALUES
(1, 'Car', '100-01-001', 'Volkswagen', 'Car1.png', 150.00, 'Automatic', 5, 4, 1, 45000.000, 'Silver', 1, 'Gas', 130, 'Volkswagen', 190, 'FWD', 100, 1, 'Car1.1.png', 'Car1.2.png', 'Car1.3.png', 'Car1.3.png', 'Haifa', 'Volkswagen.png'),
(2, 'Car', '100-01-002', 'Volkswagen', 'Car2.png', 170.00, 'Automatic', 5, 4, 0, 38000.000, 'Brown', 0, 'Gas', 140, 'Volkswagen', 200, 'FWD', 47, 1, 'Car2.1.png', 'Car2.2.png', 'Car2.3.png', 'Car2.4.png', 'Tel Aviv', 'Volkswagen.png'),
(3, 'Car', '100-01-003', 'Fiat', 'Car3.png', 350.00, 'Automatic', 4, 2, 0, 25000.000, 'Black', 1, 'Gas', 250, 'Fiat 500', 250, 'RWD', 60, 0, 'Car3.1.png', 'Car3.2.png', 'Car3.3.png', 'Car3.4.png', 'Jerusalem', 'Fiat500.png'),
(4, 'Car', '100-01-004', 'Cupra Leon', 'Car4.png', 400.00, 'Automatic', 5, 4, 1, 22000.000, 'Dark Blue', 1, 'Gas', 270, 'Cupra Leon', 260, 'RWD', 65, 1, 'Car4.1.png', 'Car4.2.png', 'Car4.3.png', 'Car4.4.png', 'Haifa', 'CupraLeon.png'),
(5, 'Car', '100-01-005', 'Opel Corsa', 'Car5.png', 220.00, 'Manual', 5, 4, 1, 50000.000, 'Gray', 0, 'Gas', 180, 'Opel Corsa', 210, 'AWD', 60, 1, 'Car5.1.png', 'Car5.2.png', 'Car5.3.png', 'Car5.4.png', 'Jerusalem', 'OpelCorsa.png'),
(6, 'Car', '100-01-006', 'Peugeot', 'Car6.png', 230.00, 'Automatic', 5, 4, 1, 42000.000, 'Dark Blue', 0, 'Gas', 190, 'Peugeot 3008', 215, 'AWD', 62, 1, 'Car6.1.png', 'Car6.2.png', 'Car6.3.png', 'Car6.4.png', 'Haifa', 'Peugeot3008.png'),
(7, 'Car', '100-01-007', 'Opel Corsa', 'Car7.png', 240.00, 'Automatic', 5, 4, 0, 39000.000, 'Red', 0, 'Gas', 160, 'Opel Corsa', 200, 'FWD', 55, 0, 'Car7.1.png', 'Car7.2.png', 'Car7.3.png', 'Car7.4.png', 'Tel Aviv', 'OpelCorsa.png'),
(8, 'Car', '100-01-008', 'Skoda', 'Car8.png', 260.00, 'Manual', 5, 4, 1, 35000.000, 'Blue', 0, 'Gas', 190, 'Skoda', 220, 'AWD', 150, 1, 'Car8.1.png', 'Car8.2.png', 'Car8.3.png', 'Car8.4.png', 'Jerusalem', 'Skoda.png'),
(9, 'Car', '100-01-009', 'Citroën', 'Car9.png', 300.00, 'Automatic', 8, 5, 0, 70000.000, 'White', 0, 'Hybrid', 200, 'Citroën', 180, 'RWD', 80, 1, 'Car9.1.png', 'Car9.2.png', 'Car9.3.png', 'Car9.4.png', 'Haifa', 'Citroën.png'),
(10, 'Car', '100-01-010', 'Jeep', 'Car10.png', 330.00, 'Automatic', 8, 5, 1, 55000.000, 'Gray', 0, 'Hybrid', 220, 'Jeep', 200, 'FWD', 150, 1, 'Car10.1.png', 'Car10.2.png', 'Car10.3.png', 'Car10.4.png', 'Tel Aviv', 'Jeep.png'),
(11, 'Van', '100-01-011', 'Toyota', 'Van1.png', 320.00, 'Manual', 10, 4, 0, 30000.000, 'White', 0, 'Gas', 220, 'Toyota', 240, 'AWD', 55, 1, 'Van1.1.png', 'Van1.2.png', 'Van1.3.png', 'Van1.4.png', 'Jerusalem', 'Toyota.png'),
(12, 'Van', '100-01-012', 'Mercedes', 'Van2.png', 380.00, 'Automatic', 7, 3, 1, 15000.000, 'Black', 0, 'Electric', 300, 'Mercedes-Benz', 260, 'AWD', 0, 1, 'Van2.1.png', 'Van2.2.png', 'Van2.3.png', 'Van2.4.png', 'Haifa', 'Mercedes.png'),
(13, 'Van', '100-01-013', 'Nissan', 'Van3.png', 350.00, 'Manual', 12, 3, 0, 60000.000, 'Red', 1, 'Gas', 280, 'Nissan', 230, '4WD', 70, 1, 'Van3.1.png', 'Van3.2.png', 'Van3.3.png', 'Van3.4.png', 'Jerusalem', 'Nissan.png'),
(14, 'Van', '100-01-014', 'Nissan', 'Van4.png', 140.00, 'Automatic', 8, 2, 0, 65000.000, 'White', 0, 'Gas', 125, 'Nissan', 190, 'FWD', 100, 1, 'Van4.1.png', 'Van4.2.png', 'Van4.3.png', 'Van4.4.png', 'Haifa', 'Nissan.png'),
(15, 'Van', '100-01-015', 'Mercedes', 'Van5.png', 180.00, 'Manual', 11, 3, 0, 40000.000, 'Light Gray', 0, 'Gas', 150, 'Mercedes-Benz', 210, 'FWD', 50, 1, 'Van5.1.png', 'Van5.2.png', 'Van5.3.png', 'Van5.4.png', 'Tel Aviv', 'Mercedes.png'),
(16, 'Van', '100-01-016', 'Mercedes', 'Van6.png', 360.00, 'Automatic', 11, 3, 0, 28000.000, 'Black & White', 0, 'Gas', 250, 'Mercedes-Benz', 240, 'AWD', 150, 1, 'Van6.1.png', 'Van6.2.png', 'Van6.3.png', 'Van6.4.png', 'Jerusalem', 'Mercedes.png'),
(17, 'Van', '100-01-017', 'Audi', 'Van7.png', 200.00, 'Automatic', 13, 3, 0, 52000.000, 'White', 0, 'Gas', 160, 'Audi', 200, 'FWD', 100, 1, 'Van7.1.png', 'Van7.2.png', 'Van7.3.png', 'Van7.4.png', 'Haifa', 'Audi.png'),
(18, 'Van', '100-01-018', 'Audi', 'Van8.png', 500.00, 'Automatic', 8, 3, 1, 20000.000, 'Black', 0, 'Gas', 350, 'Land Audi', 280, 'AWD', 90, 1, 'Van8.1.png', 'Van8.2.png', 'Van8.3.png', 'Van8.4.png', 'Tel Aviv', 'Audi.png'),
(19, 'Van', '100-01-019', 'BMW', 'Van9.png', 210.00, 'Manual', 17, 3, 0, 80000.000, 'Black', 0, 'Hybrid', 120, 'BMW', 170, 'FWD', 100, 1, 'Van9.1.png', 'Van9.2.png', 'Van9.3.png', 'Van9.4.png', 'Haifa', 'BMW.png'),
(20, 'Van', '100-01-020', 'Ford', 'Van10.png', 700.00, 'Automatic', 10, 2, 0, 10000.000, 'White', 1, 'Gas', 450, 'Ford', 320, 'RWD', 67, 1, 'Van10.1.png', 'Van10.2.png', 'Van10.3.png', 'Van10.4.png', 'Jerusalem', 'Ford.png');

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
