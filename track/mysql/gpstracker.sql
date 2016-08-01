-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 11, 2016 at 09:41 AM
-- Server version: 10.0.24-MariaDB-7
-- PHP Version: 7.0.4-7ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gpstracker`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `prcDeleteRoute` (`_sessionID` VARCHAR(50))  BEGIN
  DELETE FROM gpslocations
  WHERE sessionID = _sessionID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prcGetAllRoutesForMap` (`_userID` INT(10))  BEGIN
SELECT CONCAT('{ "latitude":"', CAST(g.latitude AS CHAR),'", "longitude":"', CAST(g.longitude AS CHAR), '", "speed":"', CAST(g.speed AS CHAR), '","vehicleName":"', CAST(v.name AS CHAR), '","vehicleImage":"', CAST(v.gpsicon AS CHAR), '", "direction":"', CAST(g.direction AS CHAR), '", "distance":"', CAST(g.distance AS CHAR), '", "locationMethod":"', g.locationMethod, '", "gpsTime":"', DATE_FORMAT(g.gpsTime, '%b %e %Y %h:%i%p'), '", "phoneNumber":"', g.phoneNumber, '", "sessionID":"', CAST(g.sessionID AS CHAR), '", "accuracy":"', CAST(g.accuracy AS CHAR), '", "extraInfo":"', g.extraInfo, '" }') json
FROM (SELECT MAX(GPSLocationID) ID
      FROM gpslocations
      WHERE sessionID != '0' && CHAR_LENGTH(sessionID) != 0 && gpstime != '0000-00-00 00:00:00' 
      GROUP BY vehicle_id) AS MaxID
JOIN gpslocations as g ON g.GPSLocationID = MaxID.ID JOIN tbl_vehicles as v on v.vehicleID = g.vehicle_id JOIN tbl_users as u on u.id = v.user_id WHERE u.id = _userID
ORDER BY gpsTime;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prcGetAllVehicleRoutesForMap` (`_vehicleID` INT(10))  BEGIN
SELECT CONCAT('{ "latitude":"', CAST(g.latitude AS CHAR),'", "longitude":"', CAST(g.longitude AS CHAR), '", "speed":"', CAST(g.speed AS CHAR), '","vehicleName":"', CAST(v.name AS CHAR), '","vehicleImage":"', CAST(v.gpsicon AS CHAR), '", "direction":"', CAST(g.direction AS CHAR), '", "distance":"', CAST(g.distance AS CHAR), '", "locationMethod":"', g.locationMethod, '", "gpsTime":"', DATE_FORMAT(g.gpsTime, '%b %e %Y %h:%i%p'), '", "phoneNumber":"', g.phoneNumber, '", "sessionID":"', CAST(g.sessionID AS CHAR), '", "accuracy":"', CAST(g.accuracy AS CHAR), '", "extraInfo":"', g.extraInfo, '" }') json
FROM (SELECT MAX(GPSLocationID) ID
      FROM gpslocations
      WHERE sessionID != '0' && CHAR_LENGTH(sessionID) != 0 && gpstime != '0000-00-00 00:00:00' && vehicle_id = _vehicleID
      GROUP BY sessionID) AS MaxID
JOIN gpslocations as g ON g.GPSLocationID = MaxID.ID JOIN tbl_vehicles as v on v.vehicleID = g.vehicle_id
ORDER BY gpsTime;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prcGetLiveRouteForMap` (`_vehicleID` INT(10))  BEGIN
  SELECT CONCAT('{ "latitude":"', CAST(g.latitude AS CHAR),'", "longitude":"', CAST(g.longitude AS CHAR), '", "speed":"', CAST(g.speed AS CHAR), '","vehicleName":"', CAST(v.name AS CHAR), '","vehicleImage":"', CAST(v.gpsicon AS CHAR), '", "direction":"', CAST(g.direction AS CHAR), '", "distance":"', CAST(g.distance AS CHAR), '", "locationMethod":"', g.locationMethod, '", "gpsTime":"', DATE_FORMAT(g.gpsTime, '%b %e %Y %h:%i%p'), '", "phoneNumber":"', g.phoneNumber, '", "sessionID":"', CAST(g.sessionID AS CHAR), '", "accuracy":"', CAST(g.accuracy AS CHAR), '", "extraInfo":"', g.extraInfo, '" }') json
  FROM gpslocations as g JOIN tbl_vehicles as v on g.vehicle_id = v.vehicleID
  WHERE g.gpsTime = (SELECT MAX(gpsTime) FROM gpslocations gl  WHERE gl.vehicle_id = _vehicleID)
  ORDER BY lastupdate;  

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prcGetRouteForMap` (`_sessionID` VARCHAR(50))  BEGIN
  SELECT CONCAT('{ "latitude":"', CAST(g.latitude AS CHAR),'", "longitude":"', CAST(g.longitude AS CHAR), '", "speed":"', CAST(g.speed AS CHAR), '","vehicleName":"', CAST(v.name AS CHAR), '","vehicleImage":"', CAST(v.gpsicon AS CHAR), '", "direction":"', CAST(g.direction AS CHAR), '", "distance":"', CAST(g.distance AS CHAR), '", "locationMethod":"', g.locationMethod, '", "gpsTime":"', DATE_FORMAT(g.gpsTime, '%b %e %Y %h:%i%p'), '", "phoneNumber":"', g.phoneNumber, '", "sessionID":"', CAST(g.sessionID AS CHAR), '", "accuracy":"', CAST(g.accuracy AS CHAR), '", "extraInfo":"', g.extraInfo, '" }') json
  FROM gpslocations as g JOIN tbl_vehicles as v on g.vehicle_id = v.vehicleID
  WHERE g.sessionID = _sessionID
  ORDER BY lastupdate;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prcGetRoutes` (`_userID` INT(10))  BEGIN
  CREATE TEMPORARY TABLE tempRoutes (
    sessionID VARCHAR(50),
    vehicle_id INT(10),
    vehicleName VARCHAR(50),
    startTime DATETIME,
    endTime DATETIME)
  ENGINE = MEMORY;

  INSERT INTO tempRoutes (sessionID, vehicle_id, vehicleName, vehicleImage)
  SELECT DISTINCT g.sessionID, g.vehicle_id, v.name, v.gpsicon
  FROM gpslocations as g JOIN tbl_vehicles as v on v.vehicleID=g.vehicle_id JOIN tbl_users as u on u.id = v.user_id WHERE u.id = _userID;

  UPDATE tempRoutes tr
  SET startTime = (SELECT MIN(gpsTime) FROM gpslocations gl
  WHERE gl.sessionID = tr.sessionID
  AND gl.vehicle_id = tr.vehicle_id);

  UPDATE tempRoutes tr
  SET endTime = (SELECT MAX(gpsTime) FROM gpslocations gl
  WHERE gl.sessionID = tr.sessionID
  AND gl.vehicle_id = tr.vehicle_id);

  SELECT

  CONCAT('{ "sessionID": "', CAST(sessionID AS CHAR),  '", "vehicle_id": "', vehicle_id, '", "vehicleName": "', vehicleName, '","vehicleImage":"', vehicleImage, '", "times": "(', DATE_FORMAT(startTime, '%b %e %Y %h:%i%p'), ' - ', DATE_FORMAT(endTime, '%b %e %Y %h:%i%p'), ')" }') json
  FROM tempRoutes
  ORDER BY startTime DESC;

  DROP TABLE tempRoutes;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prcGetVehicleRoutes` (`_vehicleID` INT(10), `_date` TIMESTAMP )  BEGIN
  CREATE TEMPORARY TABLE tempRoutes (
    sessionID VARCHAR(50),
    vehicle_id INT(10),
    vehicleName VARCHAR(50),
    vehicleImage varchar(100),
    startTime DATETIME,
    endTime DATETIME)
  ENGINE = MEMORY;

  INSERT INTO tempRoutes (sessionID, vehicle_id, vehicleName, vehicleImage)
  SELECT DISTINCT g.sessionID, g.vehicle_id, v.name, v.gpsicon
  FROM gpslocations as g JOIN tbl_vehicles as v on v.vehicleID=g.vehicle_id  WHERE v.vehicleID = _vehicleID and Date(gpsTime) = _date;

  UPDATE tempRoutes tr
  SET startTime = (SELECT MIN(gpsTime) FROM gpslocations gl
  WHERE gl.sessionID = tr.sessionID
  AND gl.vehicle_id = tr.vehicle_id);

  UPDATE tempRoutes tr
  SET endTime = (SELECT MAX(gpsTime) FROM gpslocations gl
  WHERE gl.sessionID = tr.sessionID
  AND gl.vehicle_id = tr.vehicle_id);

  SELECT

  CONCAT('{ "sessionID": "', CAST(sessionID AS CHAR),  '", "vehicle_id": "', vehicle_id, '", "vehicleName": "', vehicleName, '","vehicleImage":"', vehicleImage, '", "times": "(', DATE_FORMAT(startTime, '%b %e %Y %h:%i%p'), ' - ', DATE_FORMAT(endTime, '%b %e %Y %h:%i%p'), ')" }') json
  FROM tempRoutes
  ORDER BY startTime DESC;

  DROP TABLE tempRoutes;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prcSaveGPSLocation` (`_vehicleID` INT(10), `_latitude` DECIMAL(10,7), `_longitude` DECIMAL(10,7), `_speed` INT(10), `_direction` INT(10), `_distance` DECIMAL(10,1), `_date` TIMESTAMP, `_locationMethod` VARCHAR(50), `_phoneNumber` VARCHAR(50), `_sessionID` VARCHAR(50), `_accuracy` INT(10), `_extraInfo` VARCHAR(255), `_eventType` VARCHAR(50))  BEGIN
   INSERT INTO gpslocations (vehicle_id,latitude, longitude, speed, direction, distance, gpsTime, locationMethod, phoneNumber,  sessionID, accuracy, extraInfo, eventType)
   VALUES (_vehicleID,_latitude, _longitude, _speed, _direction, _distance, _date, _locationMethod, _phoneNumber, _sessionID, _accuracy, _extraInfo, _eventType);
   SELECT NOW();
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `gpslocations`
--

CREATE TABLE `gpslocations` (
  `GPSLocationID` int(10) UNSIGNED NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `lastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `latitude` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `longitude` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `phoneNumber` varchar(50) NOT NULL DEFAULT '',
  `sessionID` varchar(50) NOT NULL DEFAULT '',
  `speed` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `direction` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `distance` decimal(10,1) NOT NULL DEFAULT '0.0',
  `gpsTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locationMethod` varchar(50) NOT NULL DEFAULT '',
  `accuracy` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `extraInfo` varchar(255) NOT NULL DEFAULT '',
  `eventType` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gpslocations`
--

INSERT INTO `gpslocations` (`GPSLocationID`, `vehicle_id`, `lastUpdate`, `latitude`, `longitude`, `phoneNumber`, `sessionID`, `speed`, `direction`, `distance`, `gpsTime`, `locationMethod`, `accuracy`, `extraInfo`, `eventType`) VALUES
(1, 1, '2007-01-03 19:37:00', '47.6273270', '-122.3256910', 'gpsTracker3', '8BA21D90-3F90-407F-BAAE-800B04B1F5EB', 0, 0, '0.0', '2007-01-03 19:37:00', 'na', 137, 'na', 'gpsTracker'),
(2, 1, '2007-01-03 19:38:00', '47.6072580', '-122.3300770', 'gpsTracker3', '8BA21D90-3F90-407F-BAAE-800B04B1F5EB', 0, 0, '0.0', '2007-01-03 19:38:00', 'na', 137, 'na', 'gpsTracker'),
(3, 1, '2007-01-03 19:39:00', '47.6017030', '-122.3246700', 'gpsTracker3', '8BA21D90-3F90-407F-BAAE-800B04B1F5EB', 0, 0, '0.0', '2007-01-03 19:39:00', 'na', 137, 'na', 'gpsTracker'),
(4, 2, '0000-00-00 00:00:00', '47.5937570', '-122.1950740', 'gpsTracker2', '8BA21D90-3F90-407F-BAAE-800B04B1F5EC', 0, 0, '0.0', '2007-01-03 19:40:00', 'na', 137, 'na', 'gpsTracker'),
(5, 2, '2007-01-03 19:41:00', '47.6013970', '-122.1903530', 'gpsTracker2', '8BA21D90-3F90-407F-BAAE-800B04B1F5EC', 0, 0, '0.0', '2007-01-03 19:41:00', 'na', 137, 'na', 'gpsTracker'),
(6, 2, '2007-01-03 19:42:00', '47.6100200', '-122.1906970', 'gpsTracker2', '8BA21D90-3F90-407F-BAAE-800B04B1F5EC', 0, 0, '0.0', '2007-01-03 19:42:00', 'na', 137, 'na', 'gpsTracker'),
(7, 1, '2007-01-03 19:43:00', '47.6366310', '-122.2145580', 'gpsTracker1', '8BA21D90-3F90-407F-BAAE-800B04B1F5ED', 0, 0, '0.0', '2007-01-03 19:43:00', 'na', 137, 'na', 'gpsTracker'),
(8, 1, '2007-01-03 19:44:00', '47.6379610', '-122.2017690', 'gpsTracker1', '8BA21D90-3F90-407F-BAAE-800B04B1F5ED', 0, 0, '0.0', '2007-01-03 19:44:00', 'na', 137, 'na', 'gpsTracker'),
(9, 1, '2007-01-03 19:45:00', '47.6429350', '-122.2095790', 'gpsTracker1', '8BA21D90-3F90-407F-BAAE-800B04B1F5ED', 0, 0, '0.0', '2007-01-03 19:45:00', 'na', 137, 'na', 'gpsTracker');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `gpslocations`
--
ALTER TABLE `gpslocations`
  ADD PRIMARY KEY (`GPSLocationID`),
  ADD KEY `sessionIDIndex` (`sessionID`),
  ADD KEY `phoneNumberIndex` (`phoneNumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gpslocations`
--
ALTER TABLE `gpslocations`
  MODIFY `GPSLocationID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
