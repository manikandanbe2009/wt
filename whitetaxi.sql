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

CREATE TABLE IF NOT EXISTS `cab_fares` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `vehicle_code` VARCHAR(32) NOT NULL,
  `vehicle_name` VARCHAR(80) NOT NULL,
  `one_way_base_fare` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `round_trip_base_fare` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `one_way_per_km` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `round_trip_per_km` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `one_way_driver_bata` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `round_trip_driver_bata` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_vehicle_code` (`vehicle_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `cab_fares` (`vehicle_code`, `vehicle_name`, `one_way_base_fare`, `round_trip_base_fare`, `one_way_per_km`, `round_trip_per_km`, `one_way_driver_bata`, `round_trip_driver_bata`) VALUES
('SEDAN', 'Sedan', 150.00, 150.00, 14.00, 14.00, 300.00, 300.00),
('ETIOS', 'Etios', 140.00, 140.00, 13.00, 13.00, 300.00, 300.00),
('SUV', 'SUV', 220.00, 220.00, 19.00, 19.00, 400.00, 400.00),
('INNOVA', 'Innova', 260.00, 260.00, 20.00, 20.00, 450.00, 450.00),
('CRYSTA', 'Innova Crysta', 300.00, 300.00, 24.00, 22.00, 400.00, 400.00)
ON DUPLICATE KEY UPDATE
  `vehicle_name` = VALUES(`vehicle_name`);
