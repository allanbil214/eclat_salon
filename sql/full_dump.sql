-- J-MEP Database Dump
-- Generated: 2026-06-24 18:34:38
-- Include Data: Yes

SET FOREIGN_KEY_CHECKS=0;

--
-- Table structure for `admin_users`
--
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `name` varchar(120) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `admin_users`
--
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` (`id`, `username`, `password_hash`, `name`, `created_at`) VALUES ('1', 'admin', '$2y$10$xQ1DmtwN75CKa7.P6vilH.ivCVAtG10pGu0JXyiMiwG/TBKnqde5a', 'Studio Admin', '2026-06-01 09:00:00');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;

--
-- Table structure for `booking_requests`
--
DROP TABLE IF EXISTS `booking_requests`;
CREATE TABLE `booking_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email` varchar(160) NOT NULL,
  `phone` varchar(40) NOT NULL DEFAULT '',
  `service_id` int(11) DEFAULT NULL,
  `preferred_date` date DEFAULT NULL,
  `message` varchar(800) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `booking_requests`
--
/*!40000 ALTER TABLE `booking_requests` DISABLE KEYS */;
INSERT INTO `booking_requests` (`id`, `name`, `email`, `phone`, `service_id`, `preferred_date`, `message`, `created_at`) VALUES ('1', 'Maya Putri', 'maya.putri@example.com', '+62 812-9087-5521', '5', '2026-06-24', 'Would love to go a few shades lighter for summer — open to your recommendation.', '2026-06-15 14:22:00');
INSERT INTO `booking_requests` (`id`, `name`, `email`, `phone`, `service_id`, `preferred_date`, `message`, `created_at`) VALUES ('2', 'Tomi Reza', 'tomi.reza@example.com', '+62 813-4410-2208', '18', '2026-06-21', 'First time — looking for a fresh fade before a wedding.', '2026-06-16 09:05:00');
INSERT INTO `booking_requests` (`id`, `name`, `email`, `phone`, `service_id`, `preferred_date`, `message`, `created_at`) VALUES ('3', 'test', 'test@gmail.com', 'p', '1', '2026-06-22', '', '2026-06-22 21:02:03');
/*!40000 ALTER TABLE `booking_requests` ENABLE KEYS */;

--
-- Table structure for `brands`
--
DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `logo_url` varchar(400) NOT NULL DEFAULT '',
  `website_url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `brands`
--
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` (`id`, `name`, `sort_order`, `logo_url`, `website_url`) VALUES ('1', 'Olaplex', '1', '', '');
INSERT INTO `brands` (`id`, `name`, `sort_order`, `logo_url`, `website_url`) VALUES ('2', 'Kérastase', '2', '', '');
INSERT INTO `brands` (`id`, `name`, `sort_order`, `logo_url`, `website_url`) VALUES ('3', 'Wella Professionals', '3', '', '');
INSERT INTO `brands` (`id`, `name`, `sort_order`, `logo_url`, `website_url`) VALUES ('4', 'L\'Oréal Professionnel', '4', '', '');
INSERT INTO `brands` (`id`, `name`, `sort_order`, `logo_url`, `website_url`) VALUES ('5', 'Davines', '5', '', '');
INSERT INTO `brands` (`id`, `name`, `sort_order`, `logo_url`, `website_url`) VALUES ('6', 'Oribe', '6', '', '');
INSERT INTO `brands` (`id`, `name`, `sort_order`, `logo_url`, `website_url`) VALUES ('7', 'Redken', '7', '', '');
INSERT INTO `brands` (`id`, `name`, `sort_order`, `logo_url`, `website_url`) VALUES ('8', 'K18', '8', '', '');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;

--
-- Table structure for `faq`
--
DROP TABLE IF EXISTS `faq`;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(300) NOT NULL,
  `answer` varchar(800) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `faq`
--
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
INSERT INTO `faq` (`id`, `question`, `answer`, `sort_order`, `is_active`) VALUES ('4', 'Do I need a consultation before a colour appointment?', 'For first-time colour, big changes or corrections, yes — we book a short consultation (often same visit) so your stylist can plan properly. For maintenance, it is built into your appointment.', '1', '1');
INSERT INTO `faq` (`id`, `question`, `answer`, `sort_order`, `is_active`) VALUES ('5', 'What is your cancellation policy?', 'We ask for 48 hours\' notice so we can offer the slot to someone on the waitlist. Late cancellations or no-shows may incur a fee of up to 50% of the booked service.', '2', '1');
INSERT INTO `faq` (`id`, `question`, `answer`, `sort_order`, `is_active`) VALUES ('6', 'Do you take a deposit?', 'For longer colour services and first-time bookings we take a small deposit when you book, which comes straight off your final bill. Everyday cuts and styling do not require one.', '3', '1');
INSERT INTO `faq` (`id`, `question`, `answer`, `sort_order`, `is_active`) VALUES ('7', 'How long does balayage last?', 'Because it is hand-painted and grows out softly, most guests return every 10–14 weeks, with a gloss refresh in between to keep the tone fresh.', '4', '1');
INSERT INTO `faq` (`id`, `question`, `answer`, `sort_order`, `is_active`) VALUES ('8', 'How do I keep my colour looking fresh at home?', 'Wash a little less often and in cooler water, use a sulphate-free colour-safe shampoo, and add a weekly bonding mask. We are happy to build you a simple routine in the chair.', '5', '1');
INSERT INTO `faq` (`id`, `question`, `answer`, `sort_order`, `is_active`) VALUES ('9', 'Can I buy the products you use in the salon?', 'Yes — most of what we reach for in the chair is on our shelf, and you can browse it on our Shop page or ask your stylist on the day. Tap Enquire on any product to ask about availability on WhatsApp.', '6', '1');
INSERT INTO `faq` (`id`, `question`, `answer`, `sort_order`, `is_active`) VALUES ('10', 'What payment methods do you accept?', 'We accept cash, all major debit and credit cards, and QRIS / bank transfer. Payment is taken at the end of your appointment.', '7', '1');
INSERT INTO `faq` (`id`, `question`, `answer`, `sort_order`, `is_active`) VALUES ('11', 'Where are you, and is there parking?', 'We are in Kebayoran Baru, South Jakarta. There is paid parking in the building and street parking nearby; ride-hailing drops you right at the door.', '8', '1');
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;

--
-- Table structure for `gallery`
--
DROP TABLE IF EXISTS `gallery`;
CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` varchar(160) NOT NULL DEFAULT '',
  `image_url` varchar(400) NOT NULL,
  `before_image_url` varchar(400) DEFAULT NULL,
  `stylist_id` int(11) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_category` (`category_id`),
  KEY `fk_gallery_stylist` (`stylist_id`),
  CONSTRAINT `fk_gallery_category` FOREIGN KEY (`category_id`) REFERENCES `gallery_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_gallery_stylist` FOREIGN KEY (`stylist_id`) REFERENCES `team` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `gallery`
--
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('1', '3', 'Lived-in bronde balayage', 'assets/img/gallery/g1.jpg', 'assets/img/gallery/g1b.jpg', '2', '1', '5');
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('2', '1', 'Soft copper melt', 'assets/img/gallery/g2.jpg', NULL, '5', '1', '2');
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('3', '2', 'Blunt collarbone bob', 'assets/img/gallery/g3.jpg', 'assets/img/gallery/g3b.jpg', '3', '1', '3');
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('4', '5', 'Romantic bridal half-up', 'assets/img/gallery/g4.jpg', NULL, '7', '1', '4');
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('5', '1', 'Icy platinum blonde', 'assets/img/gallery/g5.jpg', 'assets/img/gallery/g5b.jpg', '2', '1', '13');
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('6', '4', 'Sculpted evening updo', 'assets/img/gallery/g6.jpg', NULL, '7', '0', '6');
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('7', '6', 'Textured crop & skin fade', 'assets/img/gallery/g7.jpg', NULL, '6', '0', '7');
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('8', '2', 'Long layered restyle', 'assets/img/gallery/g8.jpg', NULL, '3', '0', '8');
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('9', '3', 'Honey-dimensional balayage', 'assets/img/gallery/g9.jpg', NULL, '5', '0', '9');
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('10', '2', 'Natural curl shaping', 'assets/img/gallery/g10.jpg', NULL, '4', '0', '10');
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('11', '1', 'Rich brunette gloss', 'assets/img/gallery/g11.jpg', NULL, '5', '0', '11');
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('12', '6', 'Classic gentleman\'s cut', 'assets/img/gallery/g12.jpg', NULL, '6', '0', '12');
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('13', '2', 'Bob', 'assets/img/uploads/20260624-de2eddee61d1.jpg', 'assets/img/uploads/20260624-dce90eab4847.jpg', '1', '1', '0');
INSERT INTO `gallery` (`id`, `category_id`, `title`, `image_url`, `before_image_url`, `stylist_id`, `is_featured`, `sort_order`) VALUES ('14', '2', 'Pixie', 'assets/img/uploads/20260624-b86e5561d89b.jpg', 'assets/img/uploads/20260624-9a94052e9505.jpg', '2', '0', '1');
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;

--
-- Table structure for `gallery_categories`
--
DROP TABLE IF EXISTS `gallery_categories`;
CREATE TABLE `gallery_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `slug` varchar(80) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `gallery_categories`
--
/*!40000 ALTER TABLE `gallery_categories` DISABLE KEYS */;
INSERT INTO `gallery_categories` (`id`, `name`, `slug`, `sort_order`) VALUES ('1', 'Colour', 'colour', '1');
INSERT INTO `gallery_categories` (`id`, `name`, `slug`, `sort_order`) VALUES ('2', 'Cuts', 'cuts', '2');
INSERT INTO `gallery_categories` (`id`, `name`, `slug`, `sort_order`) VALUES ('3', 'Balayage', 'balayage', '3');
INSERT INTO `gallery_categories` (`id`, `name`, `slug`, `sort_order`) VALUES ('4', 'Updos', 'updos', '4');
INSERT INTO `gallery_categories` (`id`, `name`, `slug`, `sort_order`) VALUES ('5', 'Bridal', 'bridal', '5');
INSERT INTO `gallery_categories` (`id`, `name`, `slug`, `sort_order`) VALUES ('6', 'Men\'s', 'mens', '6');
/*!40000 ALTER TABLE `gallery_categories` ENABLE KEYS */;

--
-- Table structure for `gift_vouchers`
--
DROP TABLE IF EXISTS `gift_vouchers`;
CREATE TABLE `gift_vouchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(40) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `purchaser` varchar(120) NOT NULL DEFAULT '',
  `recipient` varchar(120) NOT NULL DEFAULT '',
  `is_redeemed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `gift_vouchers`
--
/*!40000 ALTER TABLE `gift_vouchers` DISABLE KEYS */;
INSERT INTO `gift_vouchers` (`id`, `code`, `amount`, `purchaser`, `recipient`, `is_redeemed`, `created_at`) VALUES ('1', 'ECLAT-GIFT-DEMO', '500000.00', 'Demo Purchaser', 'Demo Recipient', '0', '2026-06-01 12:00:00');
/*!40000 ALTER TABLE `gift_vouchers` ENABLE KEYS */;

--
-- Table structure for `newsletter_subscribers`
--
DROP TABLE IF EXISTS `newsletter_subscribers`;
CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(160) NOT NULL,
  `subscribed_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `newsletter_subscribers`
--
/*!40000 ALTER TABLE `newsletter_subscribers` DISABLE KEYS */;
-- No data
/*!40000 ALTER TABLE `newsletter_subscribers` ENABLE KEYS */;

--
-- Table structure for `opening_hours`
--
DROP TABLE IF EXISTS `opening_hours`;
CREATE TABLE `opening_hours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day_order` tinyint(4) NOT NULL,
  `day_name` varchar(12) NOT NULL,
  `open_time` time DEFAULT NULL,
  `close_time` time DEFAULT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `opening_hours`
--
/*!40000 ALTER TABLE `opening_hours` DISABLE KEYS */;
INSERT INTO `opening_hours` (`id`, `day_order`, `day_name`, `open_time`, `close_time`, `is_closed`) VALUES ('1', '1', 'Monday', NULL, NULL, '1');
INSERT INTO `opening_hours` (`id`, `day_order`, `day_name`, `open_time`, `close_time`, `is_closed`) VALUES ('2', '2', 'Tuesday', '10:00:00', '20:00:00', '0');
INSERT INTO `opening_hours` (`id`, `day_order`, `day_name`, `open_time`, `close_time`, `is_closed`) VALUES ('3', '3', 'Wednesday', '10:00:00', '20:00:00', '0');
INSERT INTO `opening_hours` (`id`, `day_order`, `day_name`, `open_time`, `close_time`, `is_closed`) VALUES ('4', '4', 'Thursday', '10:00:00', '21:00:00', '0');
INSERT INTO `opening_hours` (`id`, `day_order`, `day_name`, `open_time`, `close_time`, `is_closed`) VALUES ('5', '5', 'Friday', '10:00:00', '21:00:00', '0');
INSERT INTO `opening_hours` (`id`, `day_order`, `day_name`, `open_time`, `close_time`, `is_closed`) VALUES ('6', '6', 'Saturday', '09:00:00', '18:00:00', '0');
INSERT INTO `opening_hours` (`id`, `day_order`, `day_name`, `open_time`, `close_time`, `is_closed`) VALUES ('7', '7', 'Sunday', '10:00:00', '16:00:00', '0');
/*!40000 ALTER TABLE `opening_hours` ENABLE KEYS */;

--
-- Table structure for `order_items`
--
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(200) NOT NULL,
  `brand` varchar(80) NOT NULL DEFAULT '',
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `qty` int(11) NOT NULL DEFAULT 1,
  `line_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `fk_order_items_order` (`order_id`),
  CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `order_items`
--
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `brand`, `unit_price`, `qty`, `line_total`) VALUES ('1', '1', '3', 'No.3 Hair Perfector', 'Olaplex', '450000.00', '1', '450000.00');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `brand`, `unit_price`, `qty`, `line_total`) VALUES ('2', '1', '4', 'No.4 Bond Maintenance Shampoo', 'Olaplex', '520000.00', '1', '520000.00');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;

--
-- Table structure for `orders`
--
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(20) NOT NULL DEFAULT '',
  `customer_name` varchar(160) NOT NULL DEFAULT '',
  `customer_phone` varchar(60) NOT NULL DEFAULT '',
  `customer_email` varchar(160) NOT NULL DEFAULT '',
  `address` varchar(500) NOT NULL DEFAULT '',
  `fulfillment` varchar(20) NOT NULL DEFAULT 'pickup',
  `note` varchar(500) NOT NULL DEFAULT '',
  `item_count` int(11) NOT NULL DEFAULT 0,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(20) NOT NULL DEFAULT 'new',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `orders`
--
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `ref`, `customer_name`, `customer_phone`, `customer_email`, `address`, `fulfillment`, `note`, `item_count`, `total`, `status`, `created_at`) VALUES ('1', 'ECL-0001', 'Test', '123123213', 'test@test.com', '', 'pickup', 'test', '2', '970000.00', 'new', '2026-06-21 16:23:53');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

--
-- Table structure for `pages`
--
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(120) NOT NULL,
  `title` varchar(200) NOT NULL,
  `body` mediumtext NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `pages`
--
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `slug`, `title`, `body`, `is_active`, `updated_at`) VALUES ('1', 'privacy', 'Privacy Policy', '<p class=\"page-flag\"><strong>Sample text.</strong> This is placeholder wording for demonstration only. Replace it with your own policy and have it reviewed before you launch.</p><p>ÉCLAT (\"we\", \"us\") respects your privacy. This policy explains what we collect when you use our website and book with us.</p><h2>What we collect</h2><p>When you book an appointment or place an order, we collect the details you give us — such as your name, phone number, email and address. We also collect basic, anonymous usage data to keep the site working.</p><h2>How we use it</h2><p>We use your details only to arrange your appointment or order and to contact you about it. We do not sell your information to anyone.</p><h2>Your choices</h2><p>You may ask us to update or delete your details at any time by contacting the studio.</p><p>Questions about this policy? Reach us using the details on our booking page.</p>', '1', '2026-06-01 09:00:00');
INSERT INTO `pages` (`id`, `slug`, `title`, `body`, `is_active`, `updated_at`) VALUES ('2', 'terms', 'Terms of Service', '<p class=\"page-flag\"><strong>Sample text.</strong> This is placeholder wording for demonstration only. Replace it with your own terms and have them reviewed before you launch.</p><p>These terms apply when you use the ÉCLAT website, book an appointment or buy a product from us.</p><h2>Appointments</h2><p>Bookings are requests until confirmed by the studio. We ask for reasonable notice if you need to cancel or reschedule, as set out in our FAQ.</p><h2>Products</h2><p>Prices are shown in Indonesian Rupiah and may change. Orders placed through the site are confirmed with you on WhatsApp before any payment is taken.</p><h2>Liability</h2><p>We take great care with every service, but to the extent permitted by law our liability is limited to the value of the service or product concerned.</p><p>Questions about these terms? Reach us using the details on our booking page.</p>', '1', '2026-06-01 09:00:00');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;

--
-- Table structure for `posts`
--
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `excerpt` varchar(400) NOT NULL DEFAULT '',
  `body` mediumtext NOT NULL,
  `cover_url` varchar(400) NOT NULL DEFAULT '',
  `author` varchar(120) NOT NULL DEFAULT '',
  `category` varchar(80) NOT NULL DEFAULT '',
  `published_at` datetime DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `posts`
--
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `title`, `slug`, `excerpt`, `body`, `cover_url`, `author`, `category`, `published_at`, `is_published`) VALUES ('2', 'How to make your balayage last longer', 'make-balayage-last', 'Five habits that keep hand-painted colour looking fresh for months.', '<p>Balayage is hand-painted to grow out softly, but the colour still needs care to stay luminous between visits. With a few simple habits you can keep that sun-kissed finish looking fresh for months.</p><h2>Wash less, and wash cooler</h2><p>Every wash gently lifts colour. Stretching the time between washes, and rinsing in cool rather than hot water, keeps the tone richer for longer. Two to three washes a week is plenty for most hair types.</p><h2>Feed the ends</h2><p>Painted colour sits on the mid-lengths and ends, the most fragile part of the hair. A weekly mask keeps them soft and reflective.</p><ul><li>Use a sulphate-free, colour-safe shampoo.</li><li>Apply a bonding treatment once a week.</li><li>Always use heat protection before styling.</li><li>Book a gloss refresh every eight to ten weeks.</li></ul><p>Caring for balayage is mostly about gentleness. Treat the colour kindly and it will reward you with months of effortless shine.</p>', 'assets/img/blog/c1.jpg', 'Mara Voss', 'Colour', '2026-05-28 10:00:00', '1');
INSERT INTO `posts` (`id`, `title`, `slug`, `excerpt`, `body`, `cover_url`, `author`, `category`, `published_at`, `is_published`) VALUES ('3', 'The five-minute routine for healthier hair', 'five-minute-hair-routine', 'Small daily habits beat expensive products. Here is where to start.', '<p>Healthy hair rarely comes from a single miracle product. It comes from a handful of small habits repeated daily. The good news is that the whole routine takes about five minutes.</p><h2>Start in the shower</h2><p>Focus shampoo on the scalp, not the lengths, and let it rinse through the ends. Follow with conditioner from the mid-lengths down, and comb it through with your fingers before rinsing.</p><h2>Be kind when it is wet</h2><p>Wet hair stretches and snaps easily. Blot with a soft towel rather than rubbing, and detangle gently from the ends upward.</p><ul><li>Always detangle from the bottom up.</li><li>Let hair air-dry to eighty percent before heat styling.</li><li>Sleep on a silk pillowcase to cut friction.</li></ul><p>Consistency is everything. Done daily, these small choices add up to visibly stronger, glossier hair within weeks.</p>', 'assets/img/blog/c2.jpg', 'Sasha Lin', 'Care', '2026-05-14 10:00:00', '1');
INSERT INTO `posts` (`id`, `title`, `slug`, `excerpt`, `body`, `cover_url`, `author`, `category`, `published_at`, `is_published`) VALUES ('4', 'Choosing a fringe for your face shape', 'fringe-for-face-shape', 'Curtain, blunt, or wispy — what actually suits you.', '<p>A fringe can reframe your whole face, but the right shape depends on your features. Here is a quick guide to what tends to flatter each face shape.</p><h2>Round faces</h2><p>Longer, side-swept or curtain fringes add length and structure, drawing the eye downward rather than across.</p><h2>Square and angular faces</h2><p>Soft, wispy fringes soften a strong jaw, while a heavier blunt fringe can emphasise it if that is the look you want.</p><h2>Long faces</h2><p>A fuller, blunt fringe shortens the face and balances the proportions beautifully.</p><p>The most important thing is honest advice in the chair. Bring a photo of what you love and we will adapt it to suit you.</p>', 'assets/img/blog/c3.jpg', 'Theo Park', 'Styling', '2026-04-30 10:00:00', '1');
INSERT INTO `posts` (`id`, `title`, `slug`, `excerpt`, `body`, `cover_url`, `author`, `category`, `published_at`, `is_published`) VALUES ('5', 'This season we are loving warm brunettes', 'warm-brunettes-trend', 'Soft, glossy, low-maintenance brown is the colour of the season.', '<p>After seasons of cool tones, warmth is back. Glossy chestnut, soft chocolate and golden brunette are everywhere, and for good reason: they flatter almost every skin tone and grow out gracefully.</p><h2>Why it works</h2><p>Warm brunette catches the light without the upkeep of high-contrast blonde. A few face-framing highlights add dimension while keeping the maintenance low.</p><p>If you have been colouring cool for years, the shift can be gradual. We can warm the tone over a couple of appointments so it never feels drastic.</p><p>Pair it with a weekly gloss at home and the colour stays rich and reflective right up to your next visit.</p>', 'assets/img/blog/c4.jpg', 'Sasha Lin', 'Trends', '2026-04-12 10:00:00', '1');
INSERT INTO `posts` (`id`, `title`, `slug`, `excerpt`, `body`, `cover_url`, `author`, `category`, `published_at`, `is_published`) VALUES ('6', 'Planning your bridal hair', 'planning-bridal-hair', 'A simple timeline so your wedding-day hair is effortless.', '<p>Wedding hair should feel like you on your best day, not a stranger in the mirror. A little planning makes the morning calm rather than rushed.</p><h2>Three months out</h2><p>Book your trial and any colour you want refreshed. This is the time to experiment, not the week of the wedding.</p><h2>The final weeks</h2><p>Keep colour and cuts subtle and familiar. A bonding treatment in the last fortnight leaves the hair glossy for photographs.</p><ul><li>Bring photos, your veil and any accessories to the trial.</li><li>Tell us about the dress neckline — it shapes the style.</li><li>Plan a gentle wash the day before, not the morning of.</li></ul><p>On the day, we come to you or you come to us, and all you have to do is relax.</p>', 'assets/img/blog/c5.jpg', 'Nadia Reyes', 'Occasions', '2026-03-20 10:00:00', '1');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

--
-- Table structure for `product_images`
--
DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(400) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_product_images_product` (`product_id`),
  CONSTRAINT `fk_product_images_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `product_images`
--
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('1', '7', 'assets/img/shop/p5-3.jpg', '2');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('2', '7', 'assets/img/shop/p5-2.jpg', '1');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('3', '11', 'assets/img/shop/p9-3.jpg', '2');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('4', '11', 'assets/img/shop/p9-2.jpg', '1');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('5', '5', 'assets/img/shop/p3-3.jpg', '2');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('6', '5', 'assets/img/shop/p3-2.jpg', '1');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('7', '6', 'assets/img/shop/p4-3.jpg', '2');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('8', '6', 'assets/img/shop/p4-2.jpg', '1');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('9', '3', 'assets/img/shop/p1-3.jpg', '2');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('10', '3', 'assets/img/shop/p1-2.jpg', '1');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('11', '4', 'assets/img/shop/p2-3.jpg', '2');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('12', '4', 'assets/img/shop/p2-2.jpg', '1');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('13', '8', 'assets/img/shop/p6-3.jpg', '2');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('14', '8', 'assets/img/shop/p6-2.jpg', '1');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('15', '10', 'assets/img/shop/p8-3.jpg', '2');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('16', '10', 'assets/img/shop/p8-2.jpg', '1');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('17', '9', 'assets/img/shop/p7-3.jpg', '2');
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `sort_order`) VALUES ('18', '9', 'assets/img/shop/p7-2.jpg', '1');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;

--
-- Table structure for `products`
--
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(160) NOT NULL,
  `slug` varchar(200) NOT NULL DEFAULT '',
  `brand` varchar(80) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(400) NOT NULL DEFAULT '',
  `in_stock` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `products`
--
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `slug`, `brand`, `description`, `price`, `image_url`, `in_stock`, `sort_order`) VALUES ('3', 'No.3 Hair Perfector', 'olaplex-no-3-hair-perfector', 'Olaplex', 'At-home bond-building treatment to use weekly between appointments.', '450000.00', 'assets/img/shop/p1.jpg', '1', '1');
INSERT INTO `products` (`id`, `name`, `slug`, `brand`, `description`, `price`, `image_url`, `in_stock`, `sort_order`) VALUES ('4', 'No.4 Bond Maintenance Shampoo', 'olaplex-no-4-bond-maintenance-shampoo', 'Olaplex', 'Reparative, hydrating shampoo that keeps coloured hair strong.', '520000.00', 'assets/img/shop/p2.jpg', '1', '2');
INSERT INTO `products` (`id`, `name`, `slug`, `brand`, `description`, `price`, `image_url`, `in_stock`, `sort_order`) VALUES ('5', 'Bain Satin Shampoo', 'kerastase-bain-satin-shampoo', 'Kérastase', 'Nourishing everyday shampoo for normal to dry hair.', '520000.00', 'assets/img/shop/p3.jpg', '1', '3');
INSERT INTO `products` (`id`, `name`, `slug`, `brand`, `description`, `price`, `image_url`, `in_stock`, `sort_order`) VALUES ('6', 'Nutritive Hair Mask', 'kerastase-nutritive-hair-mask', 'Kérastase', 'Deep-conditioning mask that restores softness and shine.', '680000.00', 'assets/img/shop/p4.jpg', '1', '4');
INSERT INTO `products` (`id`, `name`, `slug`, `brand`, `description`, `price`, `image_url`, `in_stock`, `sort_order`) VALUES ('7', 'OI Oil', 'davines-oi-oil', 'Davines', 'Lightweight, multi-benefit oil for shine, softness and heat protection.', '590000.00', 'assets/img/shop/p5.jpg', '1', '5');
INSERT INTO `products` (`id`, `name`, `slug`, `brand`, `description`, `price`, `image_url`, `in_stock`, `sort_order`) VALUES ('8', 'Gold Lust Repair Shampoo', 'oribe-gold-lust-repair-shampoo', 'Oribe', 'A luxury repairing shampoo that rebalances and revitalises the scalp.', '850000.00', 'assets/img/shop/p6.jpg', '1', '6');
INSERT INTO `products` (`id`, `name`, `slug`, `brand`, `description`, `price`, `image_url`, `in_stock`, `sort_order`) VALUES ('9', 'Oil Reflections Luminous Oil', 'wella-oil-reflections-luminous-oil', 'Wella Professionals', 'Anti-oxidant oil for instant smoothness and mirror shine.', '420000.00', 'assets/img/shop/p7.jpg', '1', '7');
INSERT INTO `products` (`id`, `name`, `slug`, `brand`, `description`, `price`, `image_url`, `in_stock`, `sort_order`) VALUES ('10', 'Acidic Bonding Concentrate', 'redken-acidic-bonding-concentrate', 'Redken', 'Leave-in treatment for severely damaged, over-processed hair.', '480000.00', 'assets/img/shop/p8.jpg', '1', '8');
INSERT INTO `products` (`id`, `name`, `slug`, `brand`, `description`, `price`, `image_url`, `in_stock`, `sort_order`) VALUES ('11', 'Leave-In Molecular Repair Mask', 'k18-leave-in-molecular-repair-mask', 'K18', 'Patented four-minute mask that reverses damage from colour and heat.', '1150000.00', 'assets/img/shop/p9.jpg', '0', '9');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

--
-- Table structure for `promotions`
--
DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(160) NOT NULL,
  `detail` varchar(400) NOT NULL DEFAULT '',
  `cta_label` varchar(60) NOT NULL DEFAULT '',
  `cta_url` varchar(300) NOT NULL DEFAULT '',
  `starts_at` date DEFAULT NULL,
  `ends_at` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `promotions`
--
/*!40000 ALTER TABLE `promotions` DISABLE KEYS */;
INSERT INTO `promotions` (`id`, `title`, `detail`, `cta_label`, `cta_url`, `starts_at`, `ends_at`, `is_active`, `sort_order`) VALUES ('1', '20% off your first colour', 'New guests save 20% on any colour service with a master colourist this season.', 'Book now', '/book', NULL, NULL, '1', '1');
/*!40000 ALTER TABLE `promotions` ENABLE KEYS */;

--
-- Table structure for `service_categories`
--
DROP TABLE IF EXISTS `service_categories`;
CREATE TABLE `service_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `slug` varchar(80) NOT NULL,
  `blurb` varchar(255) NOT NULL DEFAULT '',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `service_categories`
--
/*!40000 ALTER TABLE `service_categories` DISABLE KEYS */;
INSERT INTO `service_categories` (`id`, `name`, `slug`, `blurb`, `sort_order`) VALUES ('1', 'Cut & Style', 'cut-style', 'Precision shapes and finishes, tailored to how you actually wear your hair.', '1');
INSERT INTO `service_categories` (`id`, `name`, `slug`, `blurb`, `sort_order`) VALUES ('2', 'Colour', 'colour', 'From lived-in balayage to bold creative colour, built by hand.', '2');
INSERT INTO `service_categories` (`id`, `name`, `slug`, `blurb`, `sort_order`) VALUES ('3', 'Treatments', 'treatments', 'Repair, smooth and restore — the health work behind every great look.', '3');
INSERT INTO `service_categories` (`id`, `name`, `slug`, `blurb`, `sort_order`) VALUES ('4', 'Bridal & Events', 'bridal', 'Trials, day-of styling and occasion hair for the moments that matter.', '4');
INSERT INTO `service_categories` (`id`, `name`, `slug`, `blurb`, `sort_order`) VALUES ('5', 'Men\'s Grooming', 'mens', 'Sharp cuts, fades and beard work, with the same care as everything else.', '5');
/*!40000 ALTER TABLE `service_categories` ENABLE KEYS */;

--
-- Table structure for `services`
--
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `description` varchar(400) NOT NULL DEFAULT '',
  `price_from` decimal(10,2) DEFAULT NULL,
  `price_to` decimal(10,2) DEFAULT NULL,
  `duration_min` int(11) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_services_category` (`category_id`),
  CONSTRAINT `fk_services_category` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `services`
--
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('1', '1', 'Precision Cut & Finish', 'A consultation, precision cut and a polished blow-dry finish.', '250000.00', '450000.00', '60', '0', '1', '1');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('2', '1', 'Restyle & Consultation', 'For a real change — extended consultation, restyle and styling lesson.', '350000.00', '600000.00', '90', '0', '1', '2');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('3', '1', 'Blow-Dry & Styling', 'Wash, blow-dry and styling for everyday polish or a night out.', '150000.00', '300000.00', '45', '0', '1', '3');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('4', '1', 'Curl & Wave Styling', 'Heat or set styling that works with your natural texture, not against it.', '200000.00', '350000.00', '60', '0', '1', '4');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('5', '2', 'Full Balayage', 'Hand-painted, lived-in colour with a tailored toner and finish.', '1500000.00', '3500000.00', '180', '1', '1', '1');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('6', '2', 'Signature Highlights', 'Foil work for dimension and brightness, placed to suit your cut.', '1200000.00', '2500000.00', '150', '1', '1', '2');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('7', '2', 'Creative / Fashion Colour', 'Vivids, bold blocking and bespoke colour design.', '1800000.00', '4000000.00', '210', '0', '1', '3');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('8', '2', 'Full-Head Colour', 'Even, glossy single-process colour from root to tip.', '800000.00', '1500000.00', '120', '0', '1', '4');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('9', '2', 'Root & Gloss Refresh', 'A regrowth touch-up and a shine-boosting gloss between full appointments.', '600000.00', '1000000.00', '90', '0', '1', '5');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('10', '3', 'Olaplex Bond Repair', 'Rebuilds broken bonds for stronger, healthier hair. Add to any service.', '350000.00', '600000.00', '45', '0', '1', '1');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('11', '3', 'Keratin Smoothing', 'Tames frizz and cuts styling time for months. Built to your hair type.', '1500000.00', '3500000.00', '150', '1', '1', '2');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('12', '3', 'Scalp & Hydration Ritual', 'A deep-cleansing scalp treatment and intensive moisture mask.', '400000.00', '700000.00', '60', '0', '1', '3');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('13', '3', 'Gloss & Shine Treatment', 'A quick, mirror-shine top-up that refreshes tone and condition.', '300000.00', '500000.00', '30', '0', '1', '4');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('14', '4', 'Bridal Hair — Trial & Day', 'A pre-wedding trial plus styling on the day, start to veil.', '3500000.00', '7500000.00', NULL, '1', '1', '1');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('15', '4', 'Event Updo', 'A bespoke updo for galas, parties and red-carpet moments.', '600000.00', '1200000.00', '75', '0', '1', '2');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('16', '4', 'Occasion Blow-Dry', 'A long-lasting, camera-ready blow-dry for any special event.', '400000.00', '700000.00', '45', '0', '1', '3');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('17', '5', 'Men\'s Cut & Style', 'Consultation, scissor or clipper cut, and a styling finish.', '150000.00', '300000.00', '45', '0', '1', '1');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('18', '5', 'Skin Fade & Detail', 'A crisp, blended fade with precise detailing and a hot-towel finish.', '180000.00', '350000.00', '50', '0', '1', '2');
INSERT INTO `services` (`id`, `category_id`, `name`, `description`, `price_from`, `price_to`, `duration_min`, `is_featured`, `is_active`, `sort_order`) VALUES ('19', '5', 'Beard Sculpt', 'Beard shaping, line-up and conditioning. Pairs well with a cut.', '100000.00', '200000.00', '30', '0', '1', '3');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;

--
-- Table structure for `settings`
--
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skey` varchar(80) NOT NULL,
  `svalue` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `skey` (`skey`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `settings`
--
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('1', 'site_name', 'ÉCLAT');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('2', 'site_name_full', 'ÉCLAT — Hair Atelier');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('3', 'tagline', 'The art of beautiful hair');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('4', 'currency_symbol', 'Rp');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('5', 'founded_year', '2009');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('6', 'phone', '+62 812-1198-8279');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('7', 'whatsapp', '6281211988279');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('8', 'email', 'studio@eclat-atelier.id');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('9', 'address_line1', 'Jl. Senopati Raya No. 72, Kebayoran Baru');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('10', 'address_line2', 'Jakarta Selatan 12190, Indonesia');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('11', 'instagram', 'https://instagram.com/eclat.atelier');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('12', 'facebook', 'https://facebook.com/eclatatelier');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('13', 'tiktok', 'https://tiktok.com/@eclat.atelier');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('14', 'youtube', 'https://youtube.com/@eclatatelier');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('15', 'hero_eyebrow', 'Est. 2009 · Award-winning atelier');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('16', 'hero_title', 'Hair, considered as craft.');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('17', 'hero_lead', 'A Jakarta atelier where master colourists and cutters turn a single appointment into the look you have been picturing for years.');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('18', 'about_eyebrow', 'The house of ÉCLAT');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('19', 'about_title', 'Sixteen years of quiet, deliberate transformation');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('20', 'about_p1', 'ÉCLAT began in 2009 as a two-chair studio with one belief: that great hair is not a service you buy but a craft you commission. Today our atelier brings together colourists, cutters and texture specialists who treat every head of hair as its own brief.');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('21', 'about_p2', 'We keep the room small on purpose. Fewer chairs means longer appointments, undivided attention, and the kind of result that has guests travelling across the city — and occasionally across an ocean — to sit in our chairs.');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('22', 'booking_note', 'Appointments are confirmed within one business day. For same-day requests, call the studio.');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('23', 'address', 'Jl. Senopati No. 1, Kebayoran Baru, Jakarta Selatan');
INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES ('24', 'map_url', '');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

--
-- Table structure for `stats`
--
DROP TABLE IF EXISTS `stats`;
CREATE TABLE `stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(80) NOT NULL,
  `value` int(11) NOT NULL,
  `prefix` varchar(8) NOT NULL DEFAULT '',
  `suffix` varchar(8) NOT NULL DEFAULT '',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `stats`
--
/*!40000 ALTER TABLE `stats` DISABLE KEYS */;
INSERT INTO `stats` (`id`, `label`, `value`, `prefix`, `suffix`, `sort_order`, `is_active`) VALUES ('1', 'Years of artistry', '16', '', '', '1', '1');
INSERT INTO `stats` (`id`, `label`, `value`, `prefix`, `suffix`, `sort_order`, `is_active`) VALUES ('2', 'Guests transformed', '12000', '', '+', '2', '1');
INSERT INTO `stats` (`id`, `label`, `value`, `prefix`, `suffix`, `sort_order`, `is_active`) VALUES ('3', 'Master stylists', '8', '', '', '3', '1');
INSERT INTO `stats` (`id`, `label`, `value`, `prefix`, `suffix`, `sort_order`, `is_active`) VALUES ('4', 'Five-star reviews', '2400', '', '+', '4', '1');
INSERT INTO `stats` (`id`, `label`, `value`, `prefix`, `suffix`, `sort_order`, `is_active`) VALUES ('5', 'Industry awards', '14', '', '', '5', '1');
/*!40000 ALTER TABLE `stats` ENABLE KEYS */;

--
-- Table structure for `team`
--
DROP TABLE IF EXISTS `team`;
CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `role` varchar(120) NOT NULL,
  `specialty` varchar(160) NOT NULL DEFAULT '',
  `bio` varchar(600) NOT NULL DEFAULT '',
  `photo_url` varchar(400) NOT NULL DEFAULT '',
  `instagram` varchar(120) NOT NULL DEFAULT '',
  `years_exp` int(11) DEFAULT NULL,
  `is_owner` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `team`
--
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` (`id`, `name`, `role`, `specialty`, `bio`, `photo_url`, `instagram`, `years_exp`, `is_owner`, `is_active`, `sort_order`) VALUES ('1', 'Dewi Anggraini', 'Founder & Creative Director', 'Editorial colour & atelier direction', 'Dewi opened ÉCLAT in 2009 after a decade between Paris and Jakarta runway teams. She still takes a handful of colour clients each week.', 'assets/img/team/1.jpg', '@dewi.eclat', '22', '1', '1', '1');
INSERT INTO `team` (`id`, `name`, `role`, `specialty`, `bio`, `photo_url`, `instagram`, `years_exp`, `is_owner`, `is_active`, `sort_order`) VALUES ('2', 'Sari Wijaya', 'Master Colourist', 'Balayage, blonding & colour correction', 'Sari is our go-to for the most delicate blonding and correction work — the appointments other salons turn away.', 'assets/img/team/2.jpg', '@sari.colour', '14', '0', '1', '2');
INSERT INTO `team` (`id`, `name`, `role`, `specialty`, `bio`, `photo_url`, `instagram`, `years_exp`, `is_owner`, `is_active`, `sort_order`) VALUES ('3', 'Reza Pratama', 'Senior Stylist', 'Precision cutting & restyles', 'Reza\'s cuts are architectural — built to grow out beautifully and fall back into shape every morning.', 'assets/img/team/3.jpg', '@reza.cuts', '12', '0', '1', '3');
INSERT INTO `team` (`id`, `name`, `role`, `specialty`, `bio`, `photo_url`, `instagram`, `years_exp`, `is_owner`, `is_active`, `sort_order`) VALUES ('4', 'Putri Maharani', 'Master Stylist', 'Curls, coils & textured hair', 'A texture specialist who shapes curls dry, Putri has a waitlist of guests who finally feel seen.', 'assets/img/team/4.jpg', '@putri.texture', '11', '0', '1', '4');
INSERT INTO `team` (`id`, `name`, `role`, `specialty`, `bio`, `photo_url`, `instagram`, `years_exp`, `is_owner`, `is_active`, `sort_order`) VALUES ('5', 'Nadia Kusuma', 'Colour Specialist', 'Creative & fashion colour', 'From soft money-piece to full vivids, Nadia treats colour as design. Nothing is off the table.', 'assets/img/team/5.jpg', '@nadia.colour', '9', '0', '1', '5');
INSERT INTO `team` (`id`, `name`, `role`, `specialty`, `bio`, `photo_url`, `instagram`, `years_exp`, `is_owner`, `is_active`, `sort_order`) VALUES ('6', 'Bayu Saputra', 'Senior Barber', 'Men\'s grooming, fades & beards', 'Bayu brought barbering precision into the atelier — fades and beard work with a tailor\'s patience.', 'assets/img/team/6.jpg', '@bayu.cuts', '10', '0', '1', '6');
INSERT INTO `team` (`id`, `name`, `role`, `specialty`, `bio`, `photo_url`, `instagram`, `years_exp`, `is_owner`, `is_active`, `sort_order`) VALUES ('7', 'Maya Hartono', 'Bridal Specialist', 'Updos & occasion styling', 'Maya has styled more than four hundred weddings. Calm under pressure, flawless under a veil.', 'assets/img/team/7.jpg', '@maya.bridal', '13', '0', '1', '7');
INSERT INTO `team` (`id`, `name`, `role`, `specialty`, `bio`, `photo_url`, `instagram`, `years_exp`, `is_owner`, `is_active`, `sort_order`) VALUES ('8', 'Arif Setiawan', 'Stylist', 'Cutting & everyday styling', 'Arif trained in-house at ÉCLAT and brings a fresh, modern eye to classic cuts and blow-dries.', 'assets/img/team/8.jpg', '@arif.style', '7', '0', '1', '8');
/*!40000 ALTER TABLE `team` ENABLE KEYS */;

--
-- Table structure for `testimonials`
--
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(120) NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `quote` varchar(600) NOT NULL,
  `service` varchar(120) NOT NULL DEFAULT '',
  `source` varchar(40) NOT NULL DEFAULT 'Google',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for `testimonials`
--
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` (`id`, `author`, `rating`, `quote`, `service`, `source`, `is_active`, `sort_order`) VALUES ('1', 'Priya N.', '5', 'I have spent years and a small fortune trying to get my blonde right. Mara fixed it in one appointment. I actually cried a little.', 'Colour correction', 'Google', '1', '1');
INSERT INTO `testimonials` (`id`, `author`, `rating`, `quote`, `service`, `source`, `is_active`, `sort_order`) VALUES ('2', 'James W.', '5', 'Theo is the first person in a decade who cut my hair and it still looked good a month later. I will not go anywhere else.', 'Precision Cut', 'Google', '1', '2');
INSERT INTO `testimonials` (`id`, `author`, `rating`, `quote`, `service`, `source`, `is_active`, `sort_order`) VALUES ('3', 'Aaliyah R.', '5', 'They understood my curls without me having to explain or apologise. Yuki is a genius and the room feels like a calm little sanctuary.', 'Curl shaping', 'Instagram', '1', '3');
INSERT INTO `testimonials` (`id`, `author`, `rating`, `quote`, `service`, `source`, `is_active`, `sort_order`) VALUES ('4', 'Sofia & Marc', '5', 'Elena did my bridal trial and the day-of styling. It survived rain, tears and a ten-hour party. Flawless from first photo to last.', 'Bridal Hair', 'Google', '1', '4');
INSERT INTO `testimonials` (`id`, `author`, `rating`, `quote`, `service`, `source`, `is_active`, `sort_order`) VALUES ('5', 'Daniel K.', '5', 'Booked on a whim for a fade and a beard tidy. Best grooming experience I have had — proper consultation, no rush, perfect result.', 'Skin Fade', 'Google', '1', '5');
INSERT INTO `testimonials` (`id`, `author`, `rating`, `quote`, `service`, `source`, `is_active`, `sort_order`) VALUES ('6', 'Hana T.', '5', 'The balayage is the most natural I have ever had. Six weeks on and it is still gorgeous. Worth every cent and the trip downtown.', 'Full Balayage', 'Instagram', '1', '6');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;

SET FOREIGN_KEY_CHECKS=1;
