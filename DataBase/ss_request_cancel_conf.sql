/*
 Navicat Premium Data Transfer

 Source Server         : com69
 Source Server Type    : MySQL
 Source Server Version : 100113
 Source Host           : localhost:3306
 Source Schema         : hrd

 Target Server Type    : MySQL
 Target Server Version : 100113
 File Encoding         : 65001

 Date: 27/01/2022 13:25:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ss_request_cancel_conf
-- ----------------------------
DROP TABLE IF EXISTS `ss_request_cancel_conf`;
CREATE TABLE `ss_request_cancel_conf`  (
  `reqc_id` int(9) NOT NULL AUTO_INCREMENT,
  `conf_id` int(9) NOT NULL,
  `empno` int(7) NOT NULL,
  `reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `reqdate` datetime(0) NOT NULL,
  `req_status` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N',
  `canceler` int(7) DEFAULT NULL,
  `candate` datetime(0) DEFAULT NULL,
  PRIMARY KEY (`reqc_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
