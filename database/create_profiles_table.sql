-- Script SQL để tạo bảng profiles
-- Chạy script này trong phpMyAdmin để tạo bảng

USE `vietlance`;

-- Tạo bảng profiles
CREATE TABLE IF NOT EXISTS `profiles` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `talent_id` BIGINT UNSIGNED NOT NULL,
    
    -- Profile Overview
    `profile_overview` TEXT NULL,
    
    -- Basic Information
    `experience_level` ENUM('entry', 'intermediate', 'expert') NULL,
    `hours_per_week` VARCHAR(255) NULL,
    `open_to_contract_to_hire` TINYINT(1) NOT NULL DEFAULT 0,
    `visibility` ENUM('public', 'private') NOT NULL DEFAULT 'public',
    `project_preference` VARCHAR(255) NULL,
    `earnings_privacy` TINYINT(1) NOT NULL DEFAULT 0,
    
    -- Video Introduction
    `video_introduction_url` VARCHAR(500) NULL,
    
    -- Languages (stored as JSON)
    `languages` JSON NULL,
    
    -- Verifications
    `id_verified` TINYINT(1) NOT NULL DEFAULT 0,
    `military_veteran` TINYINT(1) NOT NULL DEFAULT 0,
    
    -- Work History
    `work_history` JSON NULL,
    
    -- Skills
    `skills` JSON NULL,
    
    -- Categories
    `primary_category` VARCHAR(255) NULL,
    `sub_categories` JSON NULL,
    
    -- Specialized Profiles
    `specialized_profiles` JSON NULL,
    `published_profiles_count` INT NOT NULL DEFAULT 0,
    
    -- Linked Accounts
    `github_username` VARCHAR(255) NULL,
    `stackoverflow_username` VARCHAR(255) NULL,
    `linkedin_url` VARCHAR(500) NULL,
    `portfolio_url` VARCHAR(500) NULL,
    
    -- Certifications
    `certifications` JSON NULL,
    
    -- Employment History
    `employment_history` JSON NULL,
    
    -- Other Experiences
    `other_experiences` JSON NULL,
    
    -- Education
    `education` JSON NULL,
    
    -- Licenses
    `licenses` JSON NULL,
    
    -- Project Catalog
    `project_catalog` JSON NULL,
    
    -- Testimonials
    `testimonials` JSON NULL,
    
    -- AI Preference
    `ai_data_training_opt_in` TINYINT(1) NOT NULL DEFAULT 0,
    
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    
    PRIMARY KEY (`id`),
    UNIQUE KEY `profiles_talent_id_unique` (`talent_id`),
    CONSTRAINT `profiles_talent_id_foreign` FOREIGN KEY (`talent_id`) REFERENCES `talent` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

