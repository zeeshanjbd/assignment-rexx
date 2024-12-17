CREATE DATABASE IF NOT EXISTS booking_system;

USE booking_system;

CREATE TABLE IF NOT EXISTS `employees` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    INDEX `idx_name` (`name`)
);

CREATE TABLE IF NOT EXISTS `events` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `date` DATETIME NOT NULL,
    `timezone` VARCHAR(50) NOT NULL,
    `version` VARCHAR(20) NOT NULL,
    INDEX `idx_name_date` (`name`, `date`)
);

CREATE TABLE IF NOT EXISTS `bookings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `participation_id` INT NOT NULL,
    `employee_id` INT NOT NULL,
    `event_id` INT NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
    INDEX `idx_participation` (`participation_id`)
);
