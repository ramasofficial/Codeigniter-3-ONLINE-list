SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ionauth_online
-- ----------------------------
DROP TABLE IF EXISTS `ionauth_online`;
CREATE TABLE `ionauth_online`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique ID.',
  `user_id` int UNSIGNED NOT NULL DEFAULT 0 COMMENT 'User ID.',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'Username.',
  `classname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'Active class.',
  `method` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'Active method.',
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last action time.',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 301 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
