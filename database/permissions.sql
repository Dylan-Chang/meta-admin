/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : artupv5

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-01-13 14:09:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'create-post', 'CreatePosts', 'create new blog posts', '2016-01-05 01:39:36', '2016-01-05 01:39:36');
INSERT INTO `permissions` VALUES ('2', 'edit-user', 'EditUsers', 'edit existing users', '2016-01-05 01:39:36', '2016-01-05 01:39:36');
INSERT INTO `permissions` VALUES ('4', 'chongzuo', '重做', '11', '2016-01-08 16:15:34', '2016-01-08 16:15:34');
