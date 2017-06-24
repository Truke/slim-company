/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-06-24 13:25:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `articles`
-- ----------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uri` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(11) unsigned DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `published` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8_unicode_ci,
  `meta_description` text COLLATE utf8_unicode_ci,
  `thumb` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `sort` int(11) DEFAULT NULL,
  `href` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `tag` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  UNIQUE KEY `ID` (`id`),
  UNIQUE KEY `URI` (`uri`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of articles
-- ----------------------------
INSERT INTO `articles` VALUES ('19', 'slide1', '', '2', '<p>ttrh</p>', '1469623001', '', '', '', '', '/files/slide1.jpeg', '', '0', '', '');
INSERT INTO `articles` VALUES ('23', 'serve1', '', '3', '', '1498101847', '', '', '', '', '/files/serve1.png', '', '0', '', '');
INSERT INTO `articles` VALUES ('24', 'solutionpc1', '解决方案标题', '4', '<p>fdsfdfd</p>', '1498104241', '', 'fdfd', 'fdfd', '/files/Chrysanthemum.jpg', '/files/Koala.jpg', '解决方案简介', '1', '', '');
INSERT INTO `articles` VALUES ('26', 'product1', '标题', '5', '<p><span style=\"color: #333333; font-family: \'Microsoft YaHei\'; font-size: 14px;\">企鹅</span></p>', '1498108736', '', '', '', '', '/files/Penguins.jpg', '', '0', 'http://www.baidu.com', '动物');
INSERT INTO `articles` VALUES ('27', 'product2', '花开富贵', '5', '<p>花花草草</p>', '1498112093', '', '', '', '', '/files/Tulips.jpg', 'fdsfsdfds', '0', 'http://github.com', '植物');
INSERT INTO `articles` VALUES ('29', 'casepc1', '案例1', '6', '<p>内容</p>', '1498202697', '', '上传', '长城', '/files/Desert%20%281%29.jpg', '/files/Chrysanthemum%20%281%29.jpg', '电子商城是大风大浪发大水', '0', '', '');
INSERT INTO `articles` VALUES ('32', 'new1', '北京下了好大的雨', '8', '<p>新闻内容</p>', '2017-06-09', '北京下雨', '北京', '北京', '/files/Hydrangeas.jpg', '/files/Desert.jpg', '专家预测更多', '0', '', '新闻标签');
INSERT INTO `articles` VALUES ('33', 'service1', '哈哈哈', '7', '', '1498205015', '', '', '', '/files/Chrysanthemum%20%282%29.jpg', '', '服务介绍', '0', '', '');
INSERT INTO `articles` VALUES ('35', 'recruit1', '放电2', '9', '<ul>\r\n<li>岗位纸质</li>\r\n<li>风动旛动</li>\r\n</ul>', '1498205503', '', '', '', '', '/files/zhaoping1.png', '', '0', '', '');
INSERT INTO `articles` VALUES ('36', 'serve2', '', '3', '', '2017-06-23 22:42:23', '', '', '', '', '/files/serve2.png', '', '0', 'http://runjs.cn', '');
INSERT INTO `articles` VALUES ('37', 'slide2', '', '2', '', '2017-06-23 23:38:00', '', '', '', '', '/files/slide2.jpeg', '', '0', '', '');
INSERT INTO `articles` VALUES ('39', 'new3', '聪明的孩子', '8', '<p>造物的恩宠</p>', '2017-06-24 01:53:39', '', '', '', '/files/Desert%20%282%29.jpg', '/files/Hydrangeas%20%282%29.jpg', '提着心爱的灯笼', '0', '', '孩子');
INSERT INTO `articles` VALUES ('40', 'slide3', '', '2', '<p>ttrh</p>', '1469623001', '', '', '', '', '/files/slide1.jpeg', '', '0', '', '');
INSERT INTO `articles` VALUES ('41', 'serve41', '', '3', '', '1498101847', '', '', '', '', '/files/serve1.png', '', '0', '', '');
INSERT INTO `articles` VALUES ('42', 'solutionpc42', '解决方案标题', '4', '<p>fdsfdfd</p>', '1498104241', '', 'fdfd', 'fdfd', '/files/Chrysanthemum.jpg', '/files/Koala.jpg', '解决方案简介', '1', '', '');
INSERT INTO `articles` VALUES ('43', 'product43', '标题', '5', '<p><span style=\"color: #333333; font-family: \'Microsoft YaHei\'; font-size: 14px;\">企鹅</span></p>', '1498108736', '', '', '', '', '/files/Penguins.jpg', '', '0', 'http://www.baidu.com', '动物');
INSERT INTO `articles` VALUES ('44', 'product44', '花开富贵2', '5', '<p>花花草草</p>', '1498112093', '', '', '', '', '/files/Tulips.jpg', 'fdsfsdfds', '0', 'http://github.com', '植物');
INSERT INTO `articles` VALUES ('45', 'casepc45', '案例1', '6', '<p>内容</p>', '1498202697', '', '上传', '长城', '/files/Desert%20%281%29.jpg', '/files/Chrysanthemum%20%281%29.jpg', '电子商城是大风大浪发大水', '0', '', '');
INSERT INTO `articles` VALUES ('46', 'new46', '北京下了好大的雨', '8', '<p>新闻内容</p>', '2017-06-09', '北京下雨', '北京', '北京', '/files/Hydrangeas.jpg', '/files/Desert.jpg', '专家预测更多', '0', '', '新闻标签');
INSERT INTO `articles` VALUES ('47', 'service47', '哈哈哈', '7', '', '1498205015', '', '', '', '/files/Hydrangeas%20%281%29.jpg', '', '服务介绍', '0', '', '');
INSERT INTO `articles` VALUES ('48', 'recruit48', '放电', '9', '<ul>\r\n<li>岗位纸质</li>\r\n<li>风动旛动</li>\r\n</ul>', '1498205503', '', '', '', '', '/files/zhaoping1.png', '', '0', '', '');
INSERT INTO `articles` VALUES ('49', 'serve49', '', '3', '', '2017-06-23 22:42:23', '', '', '', '', '/files/serve2.png', '', '0', 'http://runjs.cn', '');
INSERT INTO `articles` VALUES ('50', 'slide50', '', '2', '', '2017-06-23 23:38:00', '', '', '', '', '/files/slide2.jpeg', '', '0', '', '');
INSERT INTO `articles` VALUES ('51', 'new51', '聪明的孩子', '8', '<p>造物的恩宠</p>', '2017-06-24 01:53:39', '', '', '', '/files/Desert%20%282%29.jpg', '/files/Hydrangeas%20%282%29.jpg', '提着心爱的灯笼', '0', '', '孩子');

-- ----------------------------
-- Table structure for `categories`
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uri` varchar(128) CHARACTER SET utf8 NOT NULL,
  `title` varchar(128) CHARACTER SET utf8 NOT NULL,
  `meta_title` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `meta_keywords` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `meta_description` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('1', 'person', '首页客服', '', '', '');
INSERT INTO `categories` VALUES ('2', 'slides', '首页轮播', '', '', '');
INSERT INTO `categories` VALUES ('3', 'serves', '服务客户', '', '', '');
INSERT INTO `categories` VALUES ('4', 'solutions', '解决方案', '解决方案SEO标题', '解决方案SEO关键字', '解决方案SEO介绍');
INSERT INTO `categories` VALUES ('5', 'products', '产品展示', '产品展示SEO标题', '产品展示SEO关键字', '产品展示SEO介绍');
INSERT INTO `categories` VALUES ('6', 'cases', '客户案例', '客户案例SEO标题', '客户案例SEO关键字', '客户案例SEO介绍');
INSERT INTO `categories` VALUES ('7', 'services', '服务中心', '服务中心SEO标题', '服务中心SEO关键字', '服务中心SEO介绍');
INSERT INTO `categories` VALUES ('8', 'news', '新闻动态', '新闻动态SEO标题', '新闻动态SEO关键字', '新闻动态SEO介绍');
INSERT INTO `categories` VALUES ('9', 'recruits', '招贤纳士', '招贤纳士SEO标题', '招贤纳士SEO关键字', '招贤纳士SEO介绍');

-- ----------------------------
-- Table structure for `system`
-- ----------------------------
DROP TABLE IF EXISTS `system`;
CREATE TABLE `system` (
  `title` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `meta_title` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `meta_keywords` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `meta_description` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(128) CHARACTER SET utf8 DEFAULT NULL,
  `about` text CHARACTER SET utf8,
  `logo` varchar(128) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of system
-- ----------------------------
INSERT INTO `system` VALUES ('蟑螂金服', '蟑螂金服官网-为小微企业和消费者提供普惠金融服务', '蟑螂金服,蟑螂金融,蟑螂小微,蟑螂金服官网', '蟑螂金服致力于打造开放的生态系统，为小微企业和消费者提供普惠金融服务。蟑螂金服相关品牌和产品有支付宝、余额宝、蟑螂花呗、蟑螂借呗、蟑螂森林、网商银行、芝麻信用等。', '北京市朝阳区三里屯凯富大厦', '635133526@qq.com', '18653035479', '<p style=\"margin: 0px; padding: 0px; color: #777777; font-family: \'Microsoft Yahei\', sans-serif; font-size: 16px; text-align: center; background-color: #f1f1f3;\">蟑螂小微金融服务集团股份有限公司（以下称&ldquo;蟑螂金服&rdquo;）起步于2004年成立的支付宝。2014年10月，蟑螂金服正式成立。蟑螂金服以&ldquo;为世界带来微小而美好的改变&rdquo;为愿景，致力于打造开放的生态系统，通过&ldquo;互联网推进器计划&rdquo;助力金融机构和合作伙伴加速迈向&ldquo;互联网+&rdquo;，为小微企业和个人消费者提供普惠金融服务。</p>\r\n<p style=\"margin: 0px; padding: 0px; color: #777777; font-family: \'Microsoft Yahei\', sans-serif; font-size: 16px; text-align: center; background-color: #f1f1f3;\">蟑螂金服集团旗下及相关业务包括生活服务平台支付宝、智慧理财平台蟑螂聚宝、云计算服务平台蟑螂金融云、独立第三方信用评价体系芝麻信用以及网商银行等。另外，蟑螂金服也与投资控股的公司及关联公司一起，在业务和服务层面通力合作，深度整合共推商业生态系统的繁荣。</p>', '/files/clogo%20%281%29.png');
