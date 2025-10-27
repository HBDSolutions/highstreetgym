-- High Street Gym - Database Schema

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Table: users

CREATE TABLE `users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `user_type` ENUM('member', 'admin') DEFAULT 'member',
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: trainers

CREATE TABLE `trainers` (
  `trainer_id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `specialization` VARCHAR(100) DEFAULT NULL,
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  PRIMARY KEY (`trainer_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: classes

CREATE TABLE `classes` (
  `class_id` INT NOT NULL AUTO_INCREMENT,
  `class_name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `duration` INT NOT NULL COMMENT 'Duration in minutes',
  `difficulty_level` ENUM('beginner', 'intermediate', 'advanced', 'all_levels') DEFAULT 'all_levels',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: schedules

CREATE TABLE `schedules` (
  `schedule_id` INT NOT NULL AUTO_INCREMENT,
  `class_id` INT NOT NULL,
  `trainer_id` INT NOT NULL,
  `day_of_week` ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `max_capacity` INT DEFAULT 20,
  PRIMARY KEY (`schedule_id`),
  KEY `class_id` (`class_id`),
  KEY `trainer_id` (`trainer_id`),
  CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`trainer_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: bookings

CREATE TABLE `bookings` (
  `booking_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `schedule_id` INT NOT NULL,
  `booking_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('confirmed', 'cancelled') DEFAULT 'confirmed',
  PRIMARY KEY (`booking_id`),
  UNIQUE KEY `unique_booking` (`user_id`, `schedule_id`),
  KEY `user_id` (`user_id`),
  KEY `schedule_id` (`schedule_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`schedule_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: blog_posts

CREATE TABLE `blog_posts` (
  `post_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `message` TEXT NOT NULL,
  `post_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `blog_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: xml_imports

CREATE TABLE `xml_imports` (
  `import_id` INT NOT NULL AUTO_INCREMENT,
  `import_type` ENUM('classes', 'trainers', 'users') NOT NULL,
  `file_name` VARCHAR(255) DEFAULT NULL,
  `records_imported` INT DEFAULT 0,
  `import_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('success', 'failed') DEFAULT 'success',
  PRIMARY KEY (`import_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Sample Data for Testing

-- Sample trainers
INSERT INTO `trainers` (`first_name`, `last_name`, `email`, `specialization`, `status`) VALUES
('Sarah', 'Johnson', 'sarah.johnson@highstreetgym.com.au', 'Yoga & Pilates', 'active'),
('Mike', 'Chen', 'mike.chen@highstreetgym.com.au', 'Strength Training', 'active'),
('Emma', 'Williams', 'emma.williams@highstreetgym.com.au', 'HIIT & Cardio', 'active');

-- Sample classes
INSERT INTO `classes` (`class_name`, `description`, `duration`, `difficulty_level`) VALUES
('Yoga Flow', 'Gentle flowing yoga for flexibility and relaxation', 60, 'all_levels'),
('Pilates Core', 'Core strengthening pilates workout', 45, 'intermediate'),
('HIIT Burn', 'High intensity interval training', 30, 'advanced'),
('Indoor Cycling', 'Cardio cycling workout', 45, 'all_levels'),
('Boxing Fitness', 'Boxing-based fitness class', 60, 'intermediate'),
('Abs Blast', 'Targeted abdominal workout', 30, 'all_levels'),
('Zumba', 'Dance fitness workout', 60, 'beginner');

-- Sample schedule (weekly timetable)
INSERT INTO `schedules` (`class_id`, `trainer_id`, `day_of_week`, `start_time`, `end_time`, `max_capacity`) VALUES
-- Monday
(1, 1, 'Monday', '06:00:00', '07:00:00', 15),
(3, 3, 'Monday', '08:00:00', '08:30:00', 20),
(5, 2, 'Monday', '18:00:00', '19:00:00', 15),
-- Tuesday
(2, 1, 'Tuesday', '07:00:00', '07:45:00', 12),
(4, 3, 'Tuesday', '17:30:00', '18:15:00', 25),
(7, 1, 'Tuesday', '19:00:00', '20:00:00', 20),
-- Wednesday
(1, 1, 'Wednesday', '06:00:00', '07:00:00', 15),
(6, 2, 'Wednesday', '12:00:00', '12:30:00', 20),
(3, 3, 'Wednesday', '18:00:00', '18:30:00', 20),
-- Thursday
(2, 1, 'Thursday', '07:00:00', '07:45:00', 12),
(5, 2, 'Thursday', '18:00:00', '19:00:00', 15),
-- Friday
(4, 3, 'Friday', '06:30:00', '07:15:00', 25),
(7, 1, 'Friday', '17:00:00', '18:00:00', 20),
-- Saturday
(1, 1, 'Saturday', '08:00:00', '09:00:00', 15),
(3, 3, 'Saturday', '09:30:00', '10:00:00', 20),
(6, 2, 'Saturday', '10:30:00', '11:00:00', 20);

-- Sample admin user (password: Admin123!)
INSERT INTO `users` (`first_name`, `last_name`, `email`, `password_hash`, `phone`, `user_type`, `status`) VALUES
('Admin', 'User', 'admin@highstreetgym.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0400000000', 'admin', 'active');

-- Sample member (password: Member123!)
INSERT INTO `users` (`first_name`, `last_name`, `email`, `password_hash`, `phone`, `user_type`, `status`) VALUES
('John', 'Smith', 'john.smith@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0412345678', 'member', 'active');

COMMIT;