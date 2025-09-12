-- Create `inquiries` table
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `response` text DEFAULT NULL,
  `status` enum('pending','answered') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `responded_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_inquiries_user` (`customer_id`),
  CONSTRAINT `fk_inquiries_user` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample inquiries
INSERT INTO `inquiries` (`id`, `customer_id`, `type`, `subject`, `message`, `response`, `status`, `created_at`, `responded_at`) VALUES
(1, 10, 'customer-support', '55', '55', NULL, 'pending', '2025-09-09 23:26:41', NULL),
(2, 10, 'ayurveda', 's', 'c', NULL, 'pending', '2025-09-09 23:27:36', NULL),
(3, 10, 'meditation', 'Test', 'scc', NULL, 'pending', '2025-09-09 23:38:11', NULL),
(4, 10, 'yoga', 'SJ', 'XJ', NULL, 'pending', '2025-09-10 14:23:39', NULL),
(5, 10, 'customer-support', 'Test', '123', NULL, 'pending', '2025-09-10 14:35:36', NULL),
(6, 10, 'ayurveda', 'sc', 'sc', NULL, 'pending', '2025-09-10 17:05:28', NULL);
