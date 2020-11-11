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

 Date: 11/11/2020 19:34:18
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
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 166 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of weeks
-- ----------------------------
INSERT INTO `weeks` VALUES (1, '1.Hafta', '5 Ekim - 11 Ekim');
INSERT INTO `weeks` VALUES (2, '2.Hafta', '12 Ekim - 18 Ekim');
INSERT INTO `weeks` VALUES (3, '3.Hafta', '19 Ekim - 25 Ekim');
INSERT INTO `weeks` VALUES (4, '4.Hafta', '26 Ekim - 1 Kasım');
INSERT INTO `weeks` VALUES (5, '5.Hafta', '2 Kasım - 8 Kasım');
INSERT INTO `weeks` VALUES (6, '6.Hafta', '9 Kasım - 15 Kasım');
INSERT INTO `weeks` VALUES (7, '7.Hafta', '16 Kasım - 22 Kasım');
INSERT INTO `weeks` VALUES (8, '8.Hafta', '23 Kasım - 29 Kasım');
INSERT INTO `weeks` VALUES (9, '9.Hafta', '30 Kasım - 6 Aralık');
INSERT INTO `weeks` VALUES (10, '10.Hafta', '7 Aralık - 13 Aralık');
INSERT INTO `weeks` VALUES (11, '11.Hafta', '14 Aralık - 20 Aralık');
INSERT INTO `weeks` VALUES (12, '12.Hafta', '21 Aralık - 27 Aralık');
INSERT INTO `weeks` VALUES (13, '13.Hafta', '28 Aralık - 3 Ocak');
INSERT INTO `weeks` VALUES (14, '14.Hafta', '4 Ocak - 10 Ocak');
INSERT INTO `weeks` VALUES (15, '15.Hafta', '11 Ocak - 17 Ocak');

SET FOREIGN_KEY_CHECKS = 1;
