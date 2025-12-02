-- Create Materials Table
-- Run this SQL in phpMyAdmin or MySQL if migration doesn't work

CREATE TABLE IF NOT EXISTS `materials` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id` INT(11) UNSIGNED NOT NULL,
  `file_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `file_size` INT(11) DEFAULT NULL COMMENT 'File size in bytes',
  `file_type` VARCHAR(100) DEFAULT NULL,
  `uploaded_by` INT(11) UNSIGNED DEFAULT NULL COMMENT 'User ID who uploaded the file',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `materials_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

