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

 Date: 15/06/2026 04:57:24
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
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `dimensions_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `dimensions_img` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `slug`(`slug` ASC) USING BTREE,
  INDEX `collection_id`(`collection_id` ASC) USING BTREE,
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `collection` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES (1, 1, 'مبل یک نفره جنوا', 'genova-1-seater', 'assets/images/collection/product/genova-1-seater-thumb.webp', 1, 1, 1781398259, 1781398259, 'مبل جنوا (Genova) با طراحی جسورانه و فول نشیمن بودن برجسته می‌شود و دارای پشتی ارگونومیک منحنی‌شکل است. انتخابی ایده‌آل برای فضاهای بزرگ، لوکس و شیک.\r\n\r\nاین محصول با مواد با دوام و طراحی دقیق ساخته شده تا استحکام و طول عمر بالایی داشته باشد و کیفیتی پایدار را به شما هدیه کند. ترکیبی از فناوری پیشرفته و طراحی مدرن، عملکردی بی‌نقص و ظاهری شیک و لوکس ایجاد می‌کند. هر جزئیات آن نشان از تعهد به کیفیت، راحتی و زیبایی دارد، و آن را به انتخابی مطمئن و ارزشمند برای سال‌ها تبدیل می‌کند.\r\n\r\nمبل تک‌نفره به سبک آمریکایی با طراحی مدرن، دارای فضای نشیمن نرم و فول است که تجربه‌ای بی‌نظیر از آرامش را برای شما فراهم می‌کند. فضای بزرگ نشیمن از کل بدن پشتیبانی کرده و امکان استراحت ساعت‌ها در راحتی کامل را فراهم می‌آورد. این مبل با دوام بالا و طراحی منحصربه‌فرد، انتخابی ایده‌آل برای فضاهای بزرگ و مدرن است.', 'ارتفاع: ۹۰ سانتی‌متر\r\nعرض: ۱۰۸ سانتی‌متر\r\nعمق: ۹۳ سانتی‌متر\r\nارتفاع نشیمن: ۴۸ سانتی‌متر\r\nعمق نشیمن: ۵۸ سانتی‌متر\r\nوزن محصول: ۶۵ کیلوگرم', 'assets/images/collection/product/genova-1-seater-dimension-2.webp');
INSERT INTO `product` VALUES (2, 1, 'مبل دو نفره جنوا', 'genova-2-seater', 'assets/images/collection/product/genova-2-seater-thumb.webp', 1, 2, 1781398259, 1781398259, 'مبل جنوا (Genova) با طراحی جسورانه و فول نشیمن بودن برجسته می‌شود و دارای پشتی ارگونومیک منحنی‌شکل است. انتخابی ایده‌آل برای فضاهای بزرگ، لوکس و شیک.\r\n\r\nکیفیت ماندگار، طراحی بی‌نظیر\r\n\r\nاین محصول با مواد با دوام و طراحی دقیق ساخته شده تا استحکام و طول عمر بالایی داشته باشد و کیفیتی پایدار را به شما هدیه کند. ترکیبی از فناوری پیشرفته و طراحی مدرن، عملکردی بی‌نقص و ظاهری شیک و لوکس ایجاد می‌کند. هر جزئیات آن نشان از تعهد به کیفیت، راحتی و زیبایی دارد، و آن را به انتخابی مطمئن و ارزشمند برای سال‌ها تبدیل می‌کند.\r\n\r\nمبل دو‌نفره جنوا (Genova 2 Seater) با فضای نشیمن فول و راحتی استثنایی، به‌طور کامل با سبک جسورانه و لوکس خود هماهنگ است و تجربه‌ای بی‌نظیر از استراحت را ارائه می‌دهد.\r\n\r\nمبل دو‌نفره به سبک آمریکایی با طراحی شیک و فضای نشیمن فول و نرم، تجربه‌ای لذت‌بخش از آرامش را برای شما و همراهتان فراهم می‌کند. فضای بزرگ نشیمن از کل بدن پشتیبانی کرده و امکان استراحت ساعت‌ها در راحتی کامل را فراهم می‌آورد. این مبل دو‌نفره، انتخابی ایده‌آل برای خلق فضایی لوکس و دلپذیر در خانه شما است.', 'ارتفاع: ۹۰ سانتی‌متر\r\nعرض: ۱۷۸ سانتی‌متر\r\nعمق: ۹۳ سانتی‌متر\r\nارتفاع نشیمن: ۴۸ سانتی‌متر\r\nعمق نشیمن: ۵۸ سانتی‌متر\r\nوزن محصول: ۷۲ کیلوگرم', 'assets/images/collection/product/genova-2-seater-dimension-2.webp');
INSERT INTO `product` VALUES (3, 1, 'مبل سه نفره جنوا', 'genova-3-seater', 'assets/images/collection/product/genova-3-seater-thumb.webp', 1, 3, 1781398259, 1781398259, 'مبل جنوا (Genova) با طراحی جسورانه و فول نشیمن بودن برجسته می‌شود و دارای پشتی ارگونومیک منحنی‌شکل است. انتخابی ایده‌آل برای فضاهای بزرگ، لوکس و شیک.\r\n\r\nکیفیت ماندگار، طراحی بی‌نظیر\r\n\r\nاین محصول با مواد با دوام و طراحی دقیق ساخته شده تا استحکام و طول عمر بالایی داشته باشد و کیفیتی پایدار را به شما هدیه کند. ترکیبی از فناوری پیشرفته و طراحی مدرن، عملکردی بی‌نقص و ظاهری شیک و لوکس ایجاد می‌کند. هر جزئیات آن نشان از تعهد به کیفیت، راحتی و زیبایی دارد، و آن را به انتخابی مطمئن و ارزشمند برای سال‌ها تبدیل می‌کند.\r\n\r\nشزلون سه‌نفره به سبک آمریکایی با طراحی مدرن، دارای فضای نشیمن نرم و فول است که تجربه‌ای استثنایی از آرامش را برای شما و خانواده‌تان فراهم می‌کند. طراحی مدرن و فضای بزرگ نشیمن، پشتیبانی کامل از بدن را ارائه می‌دهد و آن را به انتخابی ایده‌آل برای فضاهای وسیع تبدیل می‌کند. این مبل سه‌نفره ترکیبی از راحتی بی‌نظیر و طراحی مدرن است که فضای زندگی شما را به یک پناهگاه لوکس و دلپذیر تبدیل می‌کند.\r\n\r\nمبل سه‌نفره جنوا (Genova 3 Seater) با طراحی جسورانه و فول نشیمن بودن برجسته می‌شود، گزینه‌ای ایده‌آل برای جذابیت‌دادن به فضاهای بزرگ و شیک در اتاق نشیمن شما است.', 'ارتفاع: ۹۰ سانتی‌متر\r\nعرض: ۲۴۸ سانتی‌متر\r\nعمق: ۹۳ سانتی‌متر\r\nارتفاع نشیمن: ۴۸ سانتی‌متر\r\nعمق نشیمن: ۵۸ سانتی‌متر\r\nوزن محصول: ۹۱ کیلوگرم', 'assets/images/collection/product/genova-3-seater-dimension-2.webp');
INSERT INTO `product` VALUES (4, 1, 'نشیمن فول + کرنر', 'genova-seater-plus-corner', 'assets/images/collection/product/genova-seater-plus-corner-thumb.webp', 1, 1, 1781398917, 1781398917, 'مبل جنوا (Genova) با طراحی جسورانه و فول نشیمن بودن برجسته می‌شود و دارای پشتی ارگونومیک منحنی‌شکل است. انتخابی ایده‌آل برای فضاهای بزرگ، لوکس و شیک.\r\n\r\nکیفیت ماندگار، طراحی بی‌نظیر\r\n\r\nاین محصول با مواد با دوام و طراحی دقیق ساخته شده تا استحکام و طول عمر بالایی داشته باشد و کیفیتی پایدار را به شما هدیه کند. ترکیبی از فناوری پیشرفته و طراحی مدرن، عملکردی بی‌نقص و ظاهری شیک و لوکس ایجاد می‌کند. هر جزئیات آن نشان از تعهد به کیفیت، راحتی و زیبایی دارد، و آن را به انتخابی مطمئن و ارزشمند برای سال‌ها تبدیل می‌کند.\r\n\r\nشزلون دو‌نفره به سبک آمریکایی با طراحی مدرن، دارای فضای نشیمن نرم و فول است که تجربه‌ای بی‌نظیر از راحتی را برای شما و همراهتان فراهم می‌کند. فضای بزرگ نشیمن از کل بدن پشتیبانی می‌کند و امکان استراحت ساعت‌ها در آرامش کامل را فراهم می‌آورد.\r\n\r\nاین شزلون با استفاده از چرم طبیعی درجه یک ساخته شده و هم زیبایی و هم دوام طولانی‌مدت را تضمین می‌کند. ترکیبی از راحتی بی‌همتا، طراحی مدرن، فضای زندگی شما را به یک پناهگاه لوکس و دلپذیر تبدیل می‌کند.\r\n\r\nمبل دو‌نفره جنوا (Genova 2 Seater+Corner) با شزلون متصل، ترکیبی از فضای نشیمن گسترده و راحتی لوکس ارائه می‌دهد و فضایی شیک و دلپذیر برای استراحت و آرامش ایجاد می‌کند.', 'ارتفاع: ۹۰ سانتی‌متر\r\nعرض: ۲۴۸ سانتی‌متر\r\nعمق: ۹۳ سانتی‌متر\r\nارتفاع نشیمن: ۴۸ سانتی‌متر\r\nعمق نشیمن: ۵۸ سانتی‌متر\r\nوزن محصول: ۱۲۴ کیلوگرم', 'assets/images/collection/product/genova-full-plus-corner-dimension-2.webp');

-- ----------------------------
-- Table structure for product_faq
-- ----------------------------
DROP TABLE IF EXISTS `product_faq`;
CREATE TABLE `product_faq`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int UNSIGNED NOT NULL,
  `question` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_id`(`product_id` ASC) USING BTREE,
  CONSTRAINT `product_faq_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_faq
-- ----------------------------
INSERT INTO `product_faq` VALUES (1, 1, 'دستورالعمل نگهداری', 'برای حفظ کیفیت چرم طبیعی، از پاک‌کننده‌های مخصوص چرم استفاده کنید و از قرار دادن مبل در معرض مستقیم نور خورشید یا حرارت زیاد خودداری نمایید.\n\nاز مواد شیمیایی قوی یا پاک‌کننده‌های دارای الکل برای تمیز کردن سطح چرم استفاده نکنید.\n\nبالشتک‌ها را به‌صورت منظم جابه‌جا کنید تا فرم فوم و الیاف داخلی حفظ شود.\n\nپایه‌های فلزی کروم‌کاری‌شده را با دستمال نرم و مرطوب تمیز کنید تا براقیت آن‌ها باقی بماند.', 1, 1781485200, 1781485200);
INSERT INTO `product_faq` VALUES (2, 1, 'ضمانت‌نامه', 'تمامی محصولات مارکزا هوم دارای ۳ سال ضمانت مکانیزم برقی و اسکلت داخلی هستند.\n\nروکش چرمی نیز شامل ۳ سال ضمانت در برابر عیوب تولیدی می‌باشد.\n\nتوجه داشته باشید که آسیب‌های ناشی از استفاده نادرست، تماس با مواد شیمیایی، ضربه یا پارگی فیزیکی، شامل گارانتی نمی‌شود.', 2, 1781485200, 1781485200);
INSERT INTO `product_faq` VALUES (3, 1, 'جنوا یک نفره چه کاربردی دارد؟', 'جنوا یک نفره به‌عنوان یک نشیمن مکمل در کنار ست اصلی یا به‌صورت تکی در گوشه‌ای از فضا استفاده می‌شود. طراحی مدرن و فرم استاندارد آن باعث می‌شود هم در نشیمن‌های خانوادگی و هم در فضاهای رسمی جلوه‌ای شیک ایجاد کند.', 3, 1781485200, 1781485200);
INSERT INTO `product_faq` VALUES (4, 1, 'آیا جنوا یک نفره برای استفاده روزانه مناسب است؟', 'بله، این مدل با نشیمن راحت و ساختار مقاوم طراحی شده و برای استفاده روزمره کاملاً مناسب است. متریال با دوام استفاده شده در آن باعث حفظ کیفیت در طول زمان می‌شود.', 4, 1781485200, 1781485200);
INSERT INTO `product_faq` VALUES (5, 1, 'امکان سفارش جنوا یک نفره با متریال دلخواه وجود دارد؟', 'بله، امکان انتخاب رنگ پارچه یا چرم و برخی جزئیات ظاهری فراهم است تا کاملاً با دکوراسیون منزل شما هماهنگ شود.', 5, 1781485200, 1781485200);
INSERT INTO `product_faq` VALUES (6, 2, 'دستورالعمل نگهداری', 'برای حفظ کیفیت چرم طبیعی، از پاک‌کننده‌های مخصوص چرم استفاده کنید و از قرار دادن مبل در معرض مستقیم نور خورشید یا حرارت زیاد خودداری نمایید.\n\nاز مواد شیمیایی قوی یا پاک‌کننده‌های دارای الکل برای تمیز کردن سطح چرم استفاده نکنید.\n\nبالشتک‌ها را به‌صورت منظم جابه‌جا کنید تا فرم فوم و الیاف داخلی حفظ شود.\n\nپایه‌های فلزی کروم‌کاری‌شده را با دستمال نرم و مرطوب تمیز کنید تا براقیت آن‌ها باقی بماند.', 1, 1781486038, 1781486038);
INSERT INTO `product_faq` VALUES (7, 2, 'ضمانت‌نامه', 'تمامی محصولات مارکزا هوم دارای ۳ سال ضمانت مکانیزم برقی و اسکلت داخلی هستند.\n\nروکش چرمی نیز شامل ۳ سال ضمانت در برابر عیوب تولیدی می‌باشد.\n\nتوجه داشته باشید که آسیب‌های ناشی از استفاده نادرست، تماس با مواد شیمیایی، ضربه یا پارگی فیزیکی، شامل گارانتی نمی‌شود.', 2, 1781486038, 1781486038);
INSERT INTO `product_faq` VALUES (8, 2, 'جنوا دو نفره برای چه فضایی مناسب است؟', 'جنوا دو نفره برای نشیمن‌های متوسط، آپارتمان‌های مدرن و حتی فضاهای اداری شیک بسیار کاربردی است. ابعاد استاندارد آن باعث می‌شود بدون اشغال فضای زیاد، راحتی کامل برای دو نفر فراهم شود.', 3, 1781486038, 1781486038);
INSERT INTO `product_faq` VALUES (9, 2, 'کیفیت نشیمن جنوا دو نفره چگونه است؟', 'در ساخت این مدل از فوم با دوام و اسکلت مقاوم استفاده شده که مانع از افت نشیمن در طول زمان می‌شود و راحتی ماندگاری را فراهم می‌کند.', 4, 1781486038, 1781486038);
INSERT INTO `product_faq` VALUES (10, 2, 'چه عواملی بر قیمت جنوا دو نفره تاثیر دارد؟', 'نوع روکش انتخابی، کیفیت متریال داخلی و هرگونه سفارشی‌سازی در ابعاد یا جزئیات طراحی از عوامل موثر بر قیمت این مدل هستند.', 5, 1781486038, 1781486038);
INSERT INTO `product_faq` VALUES (11, 3, 'دستورالعمل نگهداری', 'برای حفظ کیفیت چرم طبیعی، از پاک‌کننده‌های مخصوص چرم استفاده کنید و از قرار دادن مبل در معرض مستقیم نور خورشید یا حرارت زیاد خودداری نمایید.\n\nاز مواد شیمیایی قوی یا پاک‌کننده‌های دارای الکل برای تمیز کردن سطح چرم استفاده نکنید.\n\nبالشتک‌ها را به‌صورت منظم جابه‌جا کنید تا فرم فوم و الیاف داخلی حفظ شود.\n\nپایه‌های فلزی کروم‌کاری‌شده را با دستمال نرم و مرطوب تمیز کنید تا براقیت آن‌ها باقی بماند.', 1, 1781486332, 1781486332);
INSERT INTO `product_faq` VALUES (12, 3, 'ضمانت‌نامه', 'تمامی محصولات مارکزا هوم دارای ۳ سال ضمانت مکانیزم برقی و اسکلت داخلی هستند.\n\nروکش چرمی نیز شامل ۳ سال ضمانت در برابر عیوب تولیدی می‌باشد.\n\nتوجه داشته باشید که آسیب‌های ناشی از استفاده نادرست، تماس با مواد شیمیایی، ضربه یا پارگی فیزیکی، شامل گارانتی نمی‌شود.', 2, 1781486332, 1781486332);
INSERT INTO `product_faq` VALUES (13, 3, 'جنوا سه نفره چه ویژگی‌هایی دارد؟', 'جنوا سه نفره با نشیمن عمیق، طراحی مدرن و فرم متعادل، گزینه‌ای ایده‌آل برای خانواده‌هاست. این مدل فضای نشیمن گسترده‌ای فراهم می‌کند و برای استفاده روزمره بسیار مناسب است.', 3, 1781486332, 1781486332);
INSERT INTO `product_faq` VALUES (14, 3, 'آیا جنوا سه نفره برای فضاهای بزرگ پیشنهاد می‌شود؟', 'بله، این مدل به دلیل ابعاد مناسب و طراحی شاخص، برای نشیمن‌های بزرگ و خانه‌هایی با چیدمان مدرن بسیار مناسب است.', 4, 1781486332, 1781486332);
INSERT INTO `product_faq` VALUES (15, 3, 'دوام جنوا سه نفره در چه سطحی است؟', 'استفاده از ساختار مقاوم و متریال با کیفیت باعث می‌شود این مدل در برابر استفاده مداوم، افت کیفیت یا تغییر فرم نداشته باشد.', 5, 1781486332, 1781486332);
INSERT INTO `product_faq` VALUES (16, 4, 'دستورالعمل نگهداری', 'برای حفظ کیفیت چرم طبیعی، از پاک‌کننده‌های مخصوص چرم استفاده کنید و از قرار دادن مبل در معرض مستقیم نور خورشید یا حرارت زیاد خودداری نمایید.\n\nاز مواد شیمیایی قوی یا پاک‌کننده‌های دارای الکل برای تمیز کردن سطح چرم استفاده نکنید.\n\nبالشتک‌ها را به‌صورت منظم جابه‌جا کنید تا فرم فوم و الیاف داخلی حفظ شود.\n\nپایه‌های فلزی کروم‌کاری‌شده را با دستمال نرم و مرطوب تمیز کنید تا براقیت آن‌ها باقی بماند.', 1, 1781486517, 1781486517);
INSERT INTO `product_faq` VALUES (17, 4, 'ضمانت‌نامه', 'تمامی محصولات مارکزا هوم دارای ۳ سال ضمانت مکانیزم برقی و اسکلت داخلی هستند.\n\nروکش چرمی نیز شامل ۳ سال ضمانت در برابر عیوب تولیدی می‌باشد.\n\nتوجه داشته باشید که آسیب‌های ناشی از استفاده نادرست، تماس با مواد شیمیایی، ضربه یا پارگی فیزیکی، شامل گارانتی نمی‌شود.', 2, 1781486517, 1781486517);
INSERT INTO `product_faq` VALUES (18, 4, 'جنوا دو نفره به همراه کرنر چه مزیتی دارد؟', 'این ترکیب فضای نشیمن بیشتری نسبت به مدل‌های معمولی ایجاد می‌کند و گوشه فضا را به بهترین شکل به محل استراحت تبدیل می‌کند. برای خانواده‌های پرجمعیت یا فضاهای بزرگ بسیار کاربردی است.', 3, 1781486517, 1781486517);
INSERT INTO `product_faq` VALUES (19, 4, 'آیا امکان تغییر جهت کرنر در این مدل وجود دارد؟', 'بله، امکان انتخاب جهت کرنر (چپ یا راست) و برخی تغییرات ابعادی وجود دارد تا متناسب با فضای منزل شما تولید شود.', 4, 1781486517, 1781486517);
INSERT INTO `product_faq` VALUES (20, 4, 'چه عواملی روی قیمت جنوا دو نفره به همراه کرنر تاثیر دارد؟', 'نوع پارچه یا چرم، ابعاد سفارشی، کیفیت متریال داخلی و جزئیات طراحی از عوامل تاثیرگذار بر قیمت این مدل هستند.', 5, 1781486517, 1781486517);

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
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_image
-- ----------------------------
INSERT INTO `product_image` VALUES (7, 1, 'assets/images/collection/product/genova-1-seater.webp', 'مبل تک نفره جنوا - نمای جلو', 1, 1781481544, 1781481544);
INSERT INTO `product_image` VALUES (8, 1, 'assets/images/collection/product/genova-1-seater-2.webp', 'مبل تک نفره جنوا - نمای کنار', 2, 1781481544, 1781481544);
INSERT INTO `product_image` VALUES (9, 1, 'assets/images/collection/product/genova-1-seater-3.webp', 'مبل تک نفره جنوا - نمای عقب', 3, 1781481544, 1781481544);
INSERT INTO `product_image` VALUES (10, 1, 'assets/images/collection/product/genova-1-seater-4.webp', 'مبل تک نفره جنوا - جزئیات دسته', 4, 1781481544, 1781481544);
INSERT INTO `product_image` VALUES (11, 1, 'assets/images/collection/product/genova-1-seater-5.webp', 'مبل تک نفره جنوا - جزئیات چرم', 5, 1781481544, 1781481544);
INSERT INTO `product_image` VALUES (12, 1, 'assets/images/collection/product/genova-1-seater-6.webp', 'مبل تک نفره جنوا - نمای بالا', 6, 1781481544, 1781481544);
INSERT INTO `product_image` VALUES (13, 1, 'assets/images/collection/product/genova-1-seater-dimension-1.webp', 'ابعاد مبل تک نفره جنوا - نمای روبرو', 7, 1781481544, 1781481544);
INSERT INTO `product_image` VALUES (14, 1, 'assets/images/collection/product/genova-1-seater-dimension-2.webp', 'ابعاد مبل تک نفره جنوا - نمای کنار', 8, 1781481544, 1781481544);
INSERT INTO `product_image` VALUES (15, 2, 'assets/images/collection/product/genova-2-seater.webp', 'مبل دو نفره جنوا - نمای جلو', 1, 1781481758, 1781481758);
INSERT INTO `product_image` VALUES (16, 2, 'assets/images/collection/product/genova-2-seater-2.webp', 'مبل دو نفره جنوا - نمای کنار', 2, 1781481758, 1781481758);
INSERT INTO `product_image` VALUES (17, 2, 'assets/images/collection/product/genova-2-seater-3.webp', 'مبل دو نفره جنوا - نمای عقب', 3, 1781481758, 1781481758);
INSERT INTO `product_image` VALUES (18, 2, 'assets/images/collection/product/genova-2-seater-4.webp', 'مبل دو نفره جنوا - جزئیات دسته', 4, 1781481758, 1781481758);
INSERT INTO `product_image` VALUES (19, 2, 'assets/images/collection/product/genova-2-seater-5.webp', 'مبل دو نفره جنوا - جزئیات چرم', 5, 1781481758, 1781481758);
INSERT INTO `product_image` VALUES (20, 2, 'assets/images/collection/product/genova-2-seater-6.webp', 'مبل دو نفره جنوا - نمای بالا', 6, 1781481758, 1781481758);
INSERT INTO `product_image` VALUES (21, 2, 'assets/images/collection/product/genova-2-seater-dimension-1.webp', 'ابعاد مبل دو نفره جنوا - نمای روبرو', 7, 1781481758, 1781481758);
INSERT INTO `product_image` VALUES (22, 2, 'assets/images/collection/product/genova-2-seater-dimension-2.webp', 'ابعاد مبل دو نفره جنوا - نمای کنار', 8, 1781481758, 1781481758);
INSERT INTO `product_image` VALUES (23, 3, 'assets/images/collection/product/genova-3-seater.webp', 'مبل سه نفره جنوا - نمای جلو', 1, 1781482003, 1781482003);
INSERT INTO `product_image` VALUES (24, 3, 'assets/images/collection/product/genova-3-seater-2.webp', 'مبل سه نفره جنوا - نمای کنار', 2, 1781482003, 1781482003);
INSERT INTO `product_image` VALUES (25, 3, 'assets/images/collection/product/genova-3-seater-3.webp', 'مبل سه نفره جنوا - نمای عقب', 3, 1781482003, 1781482003);
INSERT INTO `product_image` VALUES (26, 3, 'assets/images/collection/product/genova-3-seater-4.webp', 'مبل سه نفره جنوا - جزئیات دسته', 4, 1781482003, 1781482003);
INSERT INTO `product_image` VALUES (27, 3, 'assets/images/collection/product/genova-3-seater-5.webp', 'مبل سه نفره جنوا - جزئیات چرم', 5, 1781482003, 1781482003);
INSERT INTO `product_image` VALUES (28, 3, 'assets/images/collection/product/genova-3-seater-6.webp', 'مبل سه نفره جنوا - نمای بالا', 6, 1781482003, 1781482003);
INSERT INTO `product_image` VALUES (29, 3, 'assets/images/collection/product/genova-3-seater-dimension-1.webp', 'ابعاد مبل سه نفره جنوا - نمای روبرو', 7, 1781482003, 1781482003);
INSERT INTO `product_image` VALUES (30, 3, 'assets/images/collection/product/genova-3-seater-dimension-2.webp', 'ابعاد مبل سه نفره جنوا - نمای کنار', 8, 1781482003, 1781482003);
INSERT INTO `product_image` VALUES (31, 4, 'assets/images/collection/product/genova-full-plus-corner.webp', 'ست کامل جنوا - نمای جلو', 1, 1781482169, 1781482169);
INSERT INTO `product_image` VALUES (32, 4, 'assets/images/collection/product/genova-full-plus-corner-2.webp', 'ست کامل جنوا - نمای کنار', 2, 1781482169, 1781482169);
INSERT INTO `product_image` VALUES (33, 4, 'assets/images/collection/product/genova-full-plus-corner-3.webp', 'ست کامل جنوا - نمای بالا', 3, 1781482169, 1781482169);
INSERT INTO `product_image` VALUES (34, 4, 'assets/images/collection/product/genova-full-plus-corner-dimension-1.webp', 'ابعاد ست کامل جنوا - نمای روبرو', 4, 1781482169, 1781482169);
INSERT INTO `product_image` VALUES (35, 4, 'assets/images/collection/product/genova-full-plus-corner-dimension-2.webp', 'ابعاد ست کامل جنوا - نمای کنار', 5, 1781482169, 1781482169);

-- ----------------------------
-- Table structure for product_material
-- ----------------------------
DROP TABLE IF EXISTS `product_material`;
CREATE TABLE `product_material`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` bigint UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_id`(`product_id` ASC) USING BTREE,
  CONSTRAINT `product_material_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_material
-- ----------------------------
INSERT INTO `product_material` VALUES (1, 1, 'روکش', 'چرم طبیعی', 1, 1781485194, 1781485194);
INSERT INTO `product_material` VALUES (2, 1, 'بدنه', 'تخته چندلایه (پلی‌وود) با ضخامت ۱۸ میلی‌متر', 2, 1781485194, 1781485194);
INSERT INTO `product_material` VALUES (3, 1, 'چوب', 'چوب طبیعی و سخت', 3, 1781485194, 1781485194);
INSERT INTO `product_material` VALUES (4, 1, 'فوم', 'دانسیته ۳۵ کیلوگرم بر متر مکعب', 4, 1781485194, 1781485194);
INSERT INTO `product_material` VALUES (5, 1, 'الیاف داخلی', 'ترکیبی از فایبر توخالی', 5, 1781485194, 1781485194);
INSERT INTO `product_material` VALUES (6, 1, 'لایه داخلی', 'MDF با ضخامت ۳ میلی‌متر', 6, 1781485194, 1781485194);
INSERT INTO `product_material` VALUES (7, 1, 'پایه‌ها', 'فلز آبکاری کروم با ضخامت ۱۰ میلی‌متر', 7, 1781485194, 1781485194);
INSERT INTO `product_material` VALUES (8, 2, 'روکش', 'چرم طبیعی ایتالیایی', 1, 1781486029, 1781486029);
INSERT INTO `product_material` VALUES (9, 2, 'فوم پشتی', 'فوم استفاده شده در پشتی مبلمان', 2, 1781486029, 1781486029);
INSERT INTO `product_material` VALUES (10, 2, 'بدنه', 'پلای وود', 3, 1781486029, 1781486029);
INSERT INTO `product_material` VALUES (11, 2, 'چوب', 'چوب استفاده شده در مبلمان مارکزا هوم', 4, 1781486029, 1781486029);
INSERT INTO `product_material` VALUES (12, 2, 'تسمه کشی', 'تسمه کشی استفاده شده در مبلمان', 5, 1781486029, 1781486029);
INSERT INTO `product_material` VALUES (13, 3, 'روکش', 'چرم طبیعی', 1, 1781486327, 1781486327);
INSERT INTO `product_material` VALUES (14, 3, 'بدنه', 'تخته چندلایه (پلی‌وود) با ضخامت ۱۸ میلی‌متر', 2, 1781486327, 1781486327);
INSERT INTO `product_material` VALUES (15, 3, 'چوب', 'چوب طبیعی و سخت', 3, 1781486327, 1781486327);
INSERT INTO `product_material` VALUES (16, 3, 'فوم', 'دانسیته ۳۵ کیلوگرم بر متر مکعب', 4, 1781486327, 1781486327);
INSERT INTO `product_material` VALUES (17, 3, 'الیاف داخلی', 'ترکیبی از فایبر توخالی', 5, 1781486327, 1781486327);
INSERT INTO `product_material` VALUES (18, 3, 'لایه داخلی', 'MDF با ضخامت ۳ میلی‌متر', 6, 1781486327, 1781486327);
INSERT INTO `product_material` VALUES (19, 3, 'پایه‌ها', 'فلز آبکاری کروم با ضخامت ۱۰ میلی‌متر', 7, 1781486327, 1781486327);
INSERT INTO `product_material` VALUES (20, 4, 'روکش', 'چرم طبیعی', 1, 1781486511, 1781486511);
INSERT INTO `product_material` VALUES (21, 4, 'بدنه', 'پلای وود', 2, 1781486511, 1781486511);
INSERT INTO `product_material` VALUES (22, 4, 'چوب', 'چوب استفاده شده در مبلمان مارکزا هوم', 3, 1781486511, 1781486511);
INSERT INTO `product_material` VALUES (23, 4, 'تسمه کشی', 'تسمه کشی استفاده شده در مبلمان', 4, 1781486511, 1781486511);
INSERT INTO `product_material` VALUES (24, 4, 'فوم پشتی', 'فوم استفاده شده در پشتی مبلمان', 5, 1781486511, 1781486511);
INSERT INTO `product_material` VALUES (25, 4, 'الیاف داخلی', 'ترکیبی از فایبر توخالی', 6, 1781486511, 1781486511);
INSERT INTO `product_material` VALUES (26, 4, 'لایه داخلی', 'MDF با ضخامت ۳ میلی‌متر', 7, 1781486511, 1781486511);
INSERT INTO `product_material` VALUES (27, 4, 'پایه‌ها', 'فلز آبکاری کروم با ضخامت ۱۰ میلی‌متر', 8, 1781486511, 1781486511);

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
