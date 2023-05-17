CREATE TABLE `tasks` (
                         `task_id` int unsigned NOT NULL AUTO_INCREMENT,
                         `status` varchar(11) NOT NULL,
                         `result` varchar(255) NOT NULL,
                         `retry_id` varchar(255) DEFAULT NULL,
                         PRIMARY KEY (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;