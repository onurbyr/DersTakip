/*
 Navicat Premium Data Transfer

 Source Server         : mysql
 Source Server Type    : MySQL
 Source Server Version : 80017
 Source Host           : localhost:3306
 Source Schema         : lessondb

 Target Server Type    : MySQL
 Target Server Version : 80017
 File Encoding         : 65001

 Date: 11/11/2020 23:55:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for days
-- ----------------------------
DROP TABLE IF EXISTS `days`;
CREATE TABLE `days`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DayName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of days
-- ----------------------------
INSERT INTO `days` VALUES (1, 'Pazartesi');
INSERT INTO `days` VALUES (2, 'Salı');
INSERT INTO `days` VALUES (3, 'Çarşamba');
INSERT INTO `days` VALUES (4, 'Perşembe');
INSERT INTO `days` VALUES (5, 'Cuma');

-- ----------------------------
-- Table structure for lessons
-- ----------------------------
DROP TABLE IF EXISTS `lessons`;
CREATE TABLE `lessons`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LessonName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `FkLessonDay` int(11) NULL DEFAULT NULL,
  `LessonTime` time(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of lessons
-- ----------------------------

-- ----------------------------
-- Table structure for watchstats
-- ----------------------------
DROP TABLE IF EXISTS `watchstats`;
CREATE TABLE `watchstats`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FkLessonId` int(11) NULL DEFAULT NULL,
  `FkLessonWeekName` int(11) NULL DEFAULT NULL,
  `Status` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 166 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of watchstats
-- ----------------------------

-- ----------------------------
-- Table structure for weeks
-- ----------------------------
DROP TABLE IF EXISTS `weeks`;
CREATE TABLE `weeks`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `WeekName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `WeekDate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of weeks
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
