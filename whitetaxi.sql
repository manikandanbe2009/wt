CREATE DATABASE IF NOT EXISTS `whitetaxi`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE `whitetaxi`;

CREATE TABLE IF NOT EXISTS `website_bookings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_code` VARCHAR(32) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `mobile` VARCHAR(20) NOT NULL,
  `email` VARCHAR(190) NOT NULL,
  `pickup` TEXT NOT NULL,
  `drop_location` TEXT NOT NULL,
  `travel_date` DATE NOT NULL,
  `travel_time` VARCHAR(20) NOT NULL,
  `vehicle` VARCHAR(80) NOT NULL,
  `trip_type` VARCHAR(20) NOT NULL,
  `trip_days` INT NOT NULL DEFAULT 1,
  `distance_km` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `base_fare` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `per_km` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `dist_charge` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `driver_allowance` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `total_fare` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `customer_sent` TINYINT(1) NOT NULL DEFAULT 0,
  `business_sent` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_booking_code` (`booking_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
