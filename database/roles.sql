/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : artupv5

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-01-13 14:09:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'Owner', '所有者', 'User is the owner of a given project', '2016-01-05 01:39:06', '2016-01-13 11:35:36');
INSERT INTO `roles` VALUES ('2', 'admin', '管理员', 'User is allowed to manage and edit other users', '2016-01-05 01:39:06', '2016-01-05 01:39:06');
INSERT INTO `roles` VALUES ('3', 'qudao', '渠道', null, '2016-01-08 10:24:11', '2016-01-08 10:24:11');
INSERT INTO `roles` VALUES ('5', 'kefu', '客服', '22', '2016-01-08 10:28:30', '2016-01-08 11:53:46');
INSERT INTO `roles` VALUES ('7', 'xiaoshou', '销售', '11', '2016-01-08 10:28:57', '2016-01-08 10:28:57');
INSERT INTO `roles` VALUES ('8', 'chongzuo', '重做', '11', '2016-01-13 11:34:28', '2016-01-13 11:34:28');
