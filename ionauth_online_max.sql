SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ionauth_online_max
-- ----------------------------
DROP TABLE IF EXISTS `ionauth_online_max`;
CREATE TABLE `ionauth_online_max`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique ID.',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Date.',
  `max_online` smallint UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Max online.',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp COMMENT 'Created date.',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated date.',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
