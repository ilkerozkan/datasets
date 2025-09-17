-- Veritabanı şeması: academic_profile
--
-- Bu dosya yönetim panelinin ihtiyaç duyduğu tabloları tanımlar.
-- Çalıştırmadan önce uygun bir kullanıcı oluşturduğunuzdan emin olun.

CREATE DATABASE IF NOT EXISTS academic_profile
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE academic_profile;

CREATE TABLE IF NOT EXISTS profile (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title_prefix VARCHAR(255) DEFAULT NULL,
    full_name VARCHAR(255) NOT NULL,
    hero_tagline VARCHAR(255) DEFAULT NULL,
    biography_primary TEXT,
    biography_secondary TEXT,
    profile_image_url VARCHAR(1024) DEFAULT NULL,
    email VARCHAR(255) DEFAULT NULL,
    office VARCHAR(255) DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    office_hours VARCHAR(255) DEFAULT NULL,
    cv_url VARCHAR(1024) DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS research_interests (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS publications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    authors VARCHAR(512) DEFAULT NULL,
    year VARCHAR(32) DEFAULT NULL,
    title VARCHAR(512) NOT NULL,
    publication VARCHAR(512) DEFAULT NULL,
    details VARCHAR(512) DEFAULT NULL,
    link VARCHAR(1024) DEFAULT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS courses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(64) DEFAULT NULL,
    course_title VARCHAR(255) NOT NULL,
    term VARCHAR(128) DEFAULT NULL,
    description TEXT,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS projects (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    timeframe VARCHAR(128) DEFAULT NULL,
    description TEXT,
    link VARCHAR(1024) DEFAULT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS cv_entries (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    year_label VARCHAR(64) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(512) DEFAULT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
