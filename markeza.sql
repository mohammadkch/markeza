/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : markeza

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 14/06/2026 20:21:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for collection
-- ----------------------------
DROP TABLE IF EXISTS `collection`;
CREATE TABLE `collection`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subtitle` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `thumbnail` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `meta_description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `slug`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of collection
-- ----------------------------
INSERT INTO `collection` VALUES (1, 'کالکشن جنوا', 'genova-collection', 'ترکیب سنت و تجمل در یک مجموعه', 'مجموعه جنوا (Genoa) ترکیبی از طراحی شیک و فضای نشیمن وسیع است که آن را به انتخابی ایده‌آل برای فضاهای بزرگ تبدیل می‌کند. با طراحی به سبک آمریکایی، این مجموعه راحتی فراوان را با فضای نشیمن گسترده خود ارائه می‌دهد و پشتیبانی کامل از بدن را برای ساعت‌ها استراحت فراهم می‌کند. چه در حال لذت بردن از لحظات آرام باشید و چه پذیرای مهمانان، مجموعه جنوا تجربه‌ای لذت‌بخش و لوکس را به شما هدیه می‌دهد.\r\n\r\nمجموعه جنوا در نسخه‌های تک‌نفره، دو‌نفره، سه‌نفره و دو‌نفره با شزلون عرضه می‌شود و امکان چیدمان به صورت ست کامل یا نیم‌ست را فراهم می‌کند تا به‌طور یکپارچه با فضای خانه شما هماهنگ شود. این مجموعه، مناسب اتاق‌های نشیمن بزرگ یا دفاتر وسیع بوده و به هر محیطی هم ظرافت و هم راحتی می‌بخشد.', NULL, 'کالکشن کلاسیک ایتالیایی | مارکزا', 'مبلمان چرم کلاسیک ایتالیایی با کیفیت صادراتی', 1, 1, 1781397850, 1781397850);
INSERT INTO `collection` VALUES (2, 'کالکشن مینیمال مدرن', 'minimal-modern', 'سادگی در اوج زیبایی', 'طراحی مینیمال با خطوط تمیز و چرم نرم، مناسب فضاهای مدرن و معاصر.', NULL, 'کالکشن مینیمال مدرن | مارکزا', 'مبلمان چرم مینیمال با طراحی مدرن', 1, 2, 1781397850, 1781397850);
INSERT INTO `collection` VALUES (3, 'کالکشن رویال', 'royal', 'شکوه و عظمت در هر تکه', 'کالکشن رویال با چرم دباغی شده دست و طلاکاری‌های繊細، انتخاب اول فضاهای لوکس.', NULL, 'کالکشن رویال | مارکزا', 'مبلمان چرم لوکس رویال صادراتی', 1, 3, 1781397850, 1781397850);

-- ----------------------------
-- Table structure for collection_detail
-- ----------------------------
DROP TABLE IF EXISTS `collection_detail`;
CREATE TABLE `collection_detail`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `collection_id` int UNSIGNED NOT NULL,
  `icon_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `value` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `collection_id`(`collection_id` ASC) USING BTREE,
  CONSTRAINT `collection_detail_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `collection` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of collection_detail
-- ----------------------------
INSERT INTO `collection_detail` VALUES (1, 1, NULL, 'جنس چرم', 'چرم طبیعی گاوی ایتالیایی', 1, 1781397859, 1781397859);
INSERT INTO `collection_detail` VALUES (2, 1, NULL, 'کشور طراحی', 'ایتالیا', 2, 1781397859, 1781397859);
INSERT INTO `collection_detail` VALUES (3, 1, NULL, 'محل تولید', 'ایران', 3, 1781397859, 1781397859);
INSERT INTO `collection_detail` VALUES (4, 1, NULL, 'گارانتی', '۳ سال', 4, 1781397859, 1781397859);
INSERT INTO `collection_detail` VALUES (5, 1, NULL, 'قابلیت سفارشی‌سازی', 'بله', 5, 1781397859, 1781397859);
INSERT INTO `collection_detail` VALUES (6, 1, NULL, 'مناسب برای', 'صادرات و بازار داخلی', 6, 1781397859, 1781397859);

-- ----------------------------
-- Table structure for collection_image
-- ----------------------------
DROP TABLE IF EXISTS `collection_image`;
CREATE TABLE `collection_image`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `collection_id` int UNSIGNED NOT NULL,
  `image_path` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alt_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `collection_id`(`collection_id` ASC) USING BTREE,
  CONSTRAINT `collection_image_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `collection` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of collection_image
-- ----------------------------
INSERT INTO `collection_image` VALUES (1, 1, 'assets/images/collection/genova-1024-614-1.webp', 'مبل جنوا صادراتی', 1, 1781397854, 1781397854);
INSERT INTO `collection_image` VALUES (2, 1, 'assets/images/collection/genova-1024-614-2.webp', 'مبل جنوا صادراتی', 2, 1781397854, 1781397854);
INSERT INTO `collection_image` VALUES (3, 1, 'assets/images/collection/genova-1024-614-3.webp', 'مبل جنوا صادراتی', 3, 1781397854, 1781397854);
INSERT INTO `collection_image` VALUES (4, 1, 'assets/images/collection/genova-1024-614-4.webp', 'مبل جنوا صادراتی', 4, 1781397866, 1781397866);
INSERT INTO `collection_image` VALUES (5, 1, 'assets/images/collection/genova-1024-614-5.webp', 'مبل جنوا صادراتی', 5, 1781397866, 1781397866);

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `collection_id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `thumbnail` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `slug`(`slug` ASC) USING BTREE,
  INDEX `collection_id`(`collection_id` ASC) USING BTREE,
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `collection` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES (1, 1, 'مبل سه نفره کلاسیک', 'sofa-classic-3', 'assets/images/collection/product/genova-1024-614-3.webp', 1, 1, 1781398259, 1781398259);
INSERT INTO `product` VALUES (2, 1, 'مبل تک نفره کلاسیک', 'sofa-classic-1', 'assets/images/collection/product/genova-1024-614-2.webp', 1, 2, 1781398259, 1781398259);
INSERT INTO `product` VALUES (3, 1, 'کاناپه کلاسیک ال شکل', 'sofa-classic-l', 'assets/images/collection/product/genova-1024-614-1.webp', 1, 3, 1781398259, 1781398259);
INSERT INTO `product` VALUES (4, 1, 'مبل سه نفره جنوا', 'genova-sofa-3', 'assets/images/collection/product/genova-1024-614-4.webp', 1, 1, 1781398917, 1781398917);
INSERT INTO `product` VALUES (5, 1, 'مبل تک نفره جنوا', 'genova-sofa-1', 'assets/images/collection/product/genova-1024-614-5.webp', 1, 2, 1781398917, 1781398917);

-- ----------------------------
-- Table structure for product_image
-- ----------------------------
DROP TABLE IF EXISTS `product_image`;
CREATE TABLE `product_image`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int UNSIGNED NOT NULL,
  `image_path` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alt_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_id`(`product_id` ASC) USING BTREE,
  CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_image
-- ----------------------------
INSERT INTO `product_image` VALUES (1, 1, 'assets/images/product/genova-sofa-3-1.webp', 'مبل سه نفره جنوا', 1, 1781398917, 1781398917);
INSERT INTO `product_image` VALUES (2, 1, 'assets/images/product/genova-sofa-3-2.webp', 'مبل سه نفره جنوا', 2, 1781398917, 1781398917);
INSERT INTO `product_image` VALUES (3, 1, 'assets/images/product/genova-sofa-3-3.webp', 'مبل سه نفره جنوا', 3, 1781398917, 1781398917);
INSERT INTO `product_image` VALUES (4, 2, 'assets/images/product/genova-sofa-1-1.webp', 'مبل تک نفره جنوا', 1, 1781398917, 1781398917);
INSERT INTO `product_image` VALUES (5, 2, 'assets/images/product/genova-sofa-1-2.webp', 'مبل تک نفره جنوا', 2, 1781398917, 1781398917);
INSERT INTO `product_image` VALUES (6, 2, 'assets/images/product/genova-sofa-1-3.webp', 'مبل تک نفره جنوا', 3, 1781398917, 1781398917);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','manager','viewer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'viewer',
  `last_login` int NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', '123456', 'رضا کوچنانی', 'admin', 1780932821, 'images/user/user.png', 1, 0, 1780932821);

SET FOREIGN_KEY_CHECKS = 1;
