-- ÉCLAT — Hair Atelier · schema (MySQL 8 / utf8mb4)
-- Run this first, then seed.sql.
--   mysql -u root -p -e "CREATE DATABASE eclat_salon CHARACTER SET utf8mb4;"
--   mysql -u root -p eclat_salon < schema.sql
--   mysql -u root -p eclat_salon < seed.sql

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS booking_requests;
DROP TABLE IF EXISTS testimonials;
DROP TABLE IF EXISTS gallery;
DROP TABLE IF EXISTS gallery_categories;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS service_categories;
DROP TABLE IF EXISTS team;
DROP TABLE IF EXISTS brands;
DROP TABLE IF EXISTS stats;
DROP TABLE IF EXISTS opening_hours;
DROP TABLE IF EXISTS settings;

-- =========================================================================
-- LIVE TABLES (wired into the public site)
-- =========================================================================

-- Key/value site settings — name, contact, social, hero copy, etc.
CREATE TABLE settings (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    skey    VARCHAR(80)  NOT NULL UNIQUE,
    svalue  TEXT         NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Opening hours (one row per day).
CREATE TABLE opening_hours (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    day_order  TINYINT      NOT NULL,
    day_name   VARCHAR(12)  NOT NULL,
    open_time  TIME         NULL,
    close_time TIME         NULL,
    is_closed  TINYINT(1)   NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Count-up numbers on the homepage.
CREATE TABLE stats (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    label      VARCHAR(80)  NOT NULL,
    value      INT          NOT NULL,
    prefix     VARCHAR(8)   NOT NULL DEFAULT '',
    suffix     VARCHAR(8)   NOT NULL DEFAULT '',
    sort_order INT          NOT NULL DEFAULT 0,
    is_active  TINYINT(1)   NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Service menu groupings.
CREATE TABLE service_categories (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(80)  NOT NULL,
    slug       VARCHAR(80)  NOT NULL UNIQUE,
    blurb      VARCHAR(255) NOT NULL DEFAULT '',
    sort_order INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Individual menu items.
CREATE TABLE services (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    category_id  INT          NOT NULL,
    name         VARCHAR(120) NOT NULL,
    description  VARCHAR(400) NOT NULL DEFAULT '',
    price_from   DECIMAL(10,2) NULL,
    price_to     DECIMAL(10,2) NULL,
    duration_min INT          NULL,
    is_featured  TINYINT(1)   NOT NULL DEFAULT 0,
    is_active    TINYINT(1)   NOT NULL DEFAULT 1,
    sort_order   INT          NOT NULL DEFAULT 0,
    CONSTRAINT fk_services_category
        FOREIGN KEY (category_id) REFERENCES service_categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Stylists + owner.
CREATE TABLE team (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(120) NOT NULL,
    role         VARCHAR(120) NOT NULL,
    specialty    VARCHAR(160) NOT NULL DEFAULT '',
    bio          VARCHAR(600) NOT NULL DEFAULT '',
    photo_url    VARCHAR(400) NOT NULL DEFAULT '',
    instagram    VARCHAR(120) NOT NULL DEFAULT '',
    years_exp    INT          NULL,
    is_owner     TINYINT(1)   NOT NULL DEFAULT 0,
    is_active    TINYINT(1)   NOT NULL DEFAULT 1,
    sort_order   INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Lookbook categories + images (before_image_url powers the before/after reveal).
CREATE TABLE gallery_categories (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(80) NOT NULL,
    slug       VARCHAR(80) NOT NULL UNIQUE,
    sort_order INT         NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE gallery (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    category_id      INT          NOT NULL,
    title            VARCHAR(160) NOT NULL DEFAULT '',
    image_url        VARCHAR(400) NOT NULL,
    before_image_url VARCHAR(400) NULL,
    stylist_id       INT          NULL,
    is_featured      TINYINT(1)   NOT NULL DEFAULT 0,
    sort_order       INT          NOT NULL DEFAULT 0,
    CONSTRAINT fk_gallery_category
        FOREIGN KEY (category_id) REFERENCES gallery_categories(id) ON DELETE CASCADE,
    CONSTRAINT fk_gallery_stylist
        FOREIGN KEY (stylist_id) REFERENCES team(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Guest reviews.
CREATE TABLE testimonials (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    author     VARCHAR(120) NOT NULL,
    rating     TINYINT      NOT NULL DEFAULT 5,
    quote      VARCHAR(600) NOT NULL,
    service    VARCHAR(120) NOT NULL DEFAULT '',
    source     VARCHAR(40)  NOT NULL DEFAULT 'Google',
    is_active  TINYINT(1)   NOT NULL DEFAULT 1,
    sort_order INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Product brands (marquee).
CREATE TABLE brands (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(80) NOT NULL,
    sort_order INT         NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Booking enquiries captured by the Book form (the future dashboard reads these).
CREATE TABLE booking_requests (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    name           VARCHAR(120) NOT NULL,
    email          VARCHAR(160) NOT NULL,
    phone          VARCHAR(40)  NOT NULL DEFAULT '',
    service_id     INT          NULL,
    preferred_date DATE         NULL,
    message        VARCHAR(800) NOT NULL DEFAULT '',
    created_at     DATETIME     NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =========================================================================
-- TODO / FUTURE TABLES  — defined and seeded, but NOT yet wired to any page.
-- Build controllers + views for these when ready.
-- =========================================================================

DROP TABLE IF EXISTS faq;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS product_images;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS promotions;
DROP TABLE IF EXISTS newsletter_subscribers;
DROP TABLE IF EXISTS gift_vouchers;

-- TODO: FAQ page / accordion.
CREATE TABLE faq (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    question   VARCHAR(300) NOT NULL,
    answer     VARCHAR(800) NOT NULL,
    sort_order INT          NOT NULL DEFAULT 0,
    is_active  TINYINT(1)   NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TODO: blog / news.
CREATE TABLE posts (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(200) NOT NULL,
    slug        VARCHAR(200) NOT NULL UNIQUE,
    excerpt     VARCHAR(400) NOT NULL DEFAULT '',
    body        MEDIUMTEXT   NOT NULL,
    cover_url   VARCHAR(400) NOT NULL DEFAULT '',
    author      VARCHAR(120) NOT NULL DEFAULT '',
    published_at DATETIME    NULL,
    is_published TINYINT(1)  NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TODO: retail products sold in-salon.
CREATE TABLE products (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(160) NOT NULL,
    slug        VARCHAR(200) NOT NULL UNIQUE,
    brand       VARCHAR(80)  NOT NULL DEFAULT '',
    description VARCHAR(500) NOT NULL DEFAULT '',
    price       DECIMAL(10,2) NULL,
    image_url   VARCHAR(400) NOT NULL DEFAULT '',
    in_stock    TINYINT(1)   NOT NULL DEFAULT 1,
    sort_order  INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Extra gallery images for a product (the product-detail thumbnails).
CREATE TABLE product_images (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT          NOT NULL,
    image_url  VARCHAR(400) NOT NULL,
    sort_order INT          NOT NULL DEFAULT 0,
    CONSTRAINT fk_product_images_product
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Shop orders placed via the cart (checkout hands off to WhatsApp).
CREATE TABLE orders (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    ref            VARCHAR(20)  NOT NULL DEFAULT '',
    customer_name  VARCHAR(160) NOT NULL DEFAULT '',
    customer_phone VARCHAR(60)  NOT NULL DEFAULT '',
    customer_email VARCHAR(160) NOT NULL DEFAULT '',
    address        VARCHAR(500) NOT NULL DEFAULT '',
    fulfillment    VARCHAR(20)  NOT NULL DEFAULT 'pickup',   -- pickup | delivery
    note           VARCHAR(500) NOT NULL DEFAULT '',
    item_count     INT          NOT NULL DEFAULT 0,
    total          DECIMAL(12,2) NOT NULL DEFAULT 0,
    status         VARCHAR(20)  NOT NULL DEFAULT 'new',      -- new | contacted | completed
    created_at     DATETIME     NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Line items for an order (price/name snapshotted so history stays accurate).
CREATE TABLE order_items (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    order_id     INT          NOT NULL,
    product_id   INT          NULL,
    product_name VARCHAR(200) NOT NULL,
    brand        VARCHAR(80)  NOT NULL DEFAULT '',
    unit_price   DECIMAL(10,2) NOT NULL DEFAULT 0,
    qty          INT          NOT NULL DEFAULT 1,
    line_total   DECIMAL(12,2) NOT NULL DEFAULT 0,
    CONSTRAINT fk_order_items_order
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TODO: promo banners / seasonal offers.
CREATE TABLE promotions (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    title      VARCHAR(160) NOT NULL,
    detail     VARCHAR(400) NOT NULL DEFAULT '',
    cta_label  VARCHAR(60)  NOT NULL DEFAULT '',
    cta_url    VARCHAR(300) NOT NULL DEFAULT '',
    starts_at  DATE         NULL,
    ends_at    DATE         NULL,
    is_active  TINYINT(1)   NOT NULL DEFAULT 1,
    sort_order INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TODO: footer newsletter capture.
CREATE TABLE newsletter_subscribers (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    email         VARCHAR(160) NOT NULL UNIQUE,
    subscribed_at DATETIME     NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TODO: gift cards / vouchers.
CREATE TABLE gift_vouchers (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    code          VARCHAR(40)  NOT NULL UNIQUE,
    amount        DECIMAL(10,2) NOT NULL,
    purchaser     VARCHAR(120) NOT NULL DEFAULT '',
    recipient     VARCHAR(120) NOT NULL DEFAULT '',
    is_redeemed   TINYINT(1)   NOT NULL DEFAULT 0,
    created_at    DATETIME     NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
