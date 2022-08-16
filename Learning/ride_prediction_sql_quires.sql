CREATE DATABASE `ride_fuel_prediction` 

CREATE TABLE `users` (
	`id` INT NOT NULL,
	`firstname` VARCHAR(255),
	`lastname` VARCHAR(255),
	`email` VARCHAR(250) NOT NULL,
	`password` VARCHAR(250) NOT NULL,
	`gender` INT(1),
	`contact_number` VARCHAR(255),
	`image` TEXT,
	`birth_date` DATETIME NOT NULL,
	`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP()
)

SELECT Users.* FROM Users WHERE (contact_number != '3022') OR (contact_number != NULL) 