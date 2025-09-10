-- 1. programmes table (store your program catalogue)
DROP TABLE IF EXISTS programmes;
CREATE TABLE `programmes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(50) NOT NULL,           -- program identifier (e.g. programme1)
  `title` VARCHAR(255) NOT NULL,
  `date_info` VARCHAR(255) DEFAULT NULL, -- whatever text you want to show
  `instructor` VARCHAR(255) DEFAULT NULL,
  `location` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- sample programmes to match your front-end cards (ids will match mapping below)
    INSERT INTO programmes (code, title, date_info, instructor, location) VALUES
    ('programme1','Detox & Rejuvenation Retreat','September 10 – 14, 2025','Dr Nirmala Perera – Senior Ayurveda Specialist','Green Life Wellness Center, Colombo'),
    ('programme2','Stress Relief & Mindfulness Workshop','September 20, 2025','Mr. Sahan Jayawardena – Certified Yoga & Meditation Trainer','Green Life Wellness Center, Colombo'),
    ('programme3','Healthy Weight Management Programme','November 02, 2025','Ms. Anjali De Silva – Wellness Coach & Lifestyle Consultant','Independence Square, Colombo 07');


