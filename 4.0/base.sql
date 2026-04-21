-- =============================================
-- CRM AI Consultant — Структура бази даних
-- Version: 4.5 — Повна структура 2026
-- =============================================

-- Таблиця адміністраторів
CREATE TABLE IF NOT EXISTS `admins` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(100) NULL DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `last_login` DATETIME NULL DEFAULT NULL,
    INDEX `idx_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблиця сайтів (основна)
CREATE TABLE IF NOT EXISTS `sites` (
    `id` VARCHAR(100) PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `domain` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `enable_chat` TINYINT(1) DEFAULT 1,
    
    -- Канал за замовчуванням
    `default_channel` ENUM('telegram','grok','openai','whatsapp','viber') DEFAULT 'telegram',
    
    -- Дизайн чату
    `chat_title` VARCHAR(100) DEFAULT 'AI Consultant',
    `chat_subtitle` VARCHAR(150) DEFAULT 'Швидка допомога',
    `bot_icon` VARCHAR(20) DEFAULT '🤖',
    `position` ENUM('right','left') DEFAULT 'right',
    
    `widget_color` VARCHAR(7) DEFAULT '#22d3ee',
    `chat_bg_color` VARCHAR(7) DEFAULT '#0f172a',
    `header_bg_color` VARCHAR(7) DEFAULT '#1e2937',
    `user_bubble_color` VARCHAR(7) DEFAULT '#22d3ee',
    `bot_bubble_color` VARCHAR(7) DEFAULT '#334155',
    
    -- Окремі системні промпти для кожного каналу
    `telegram_system_prompt` TEXT NULL,
    `grok_system_prompt` TEXT NULL,
    `openai_system_prompt` TEXT NULL,
    `whatsapp_system_prompt` TEXT NULL,
    `viber_system_prompt` TEXT NULL,
    
    -- Налаштування каналів
    `telegram_token` VARCHAR(255) NULL,
    `telegram_chat_id` VARCHAR(100) NULL,
    `grok_api_key` VARCHAR(255) NULL,
    `openai_api_key` VARCHAR(255) NULL,
    `whatsapp_number` VARCHAR(20) NULL,
    `viber_number` VARCHAR(20) NULL,
    
    -- Додаткові налаштування
    `welcome_text` TEXT NULL,
    `auto_open` TINYINT(1) DEFAULT 0,
    `auto_open_delay` INT DEFAULT 7000,
    
    -- Статус підключення
    `is_connected` TINYINT(1) DEFAULT 0,
    `last_check` DATETIME NULL,
    
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX `idx_domain` (`domain`),
    INDEX `idx_enable_chat` (`enable_chat`),
    INDEX `idx_default_channel` (`default_channel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблиця історії розмов
CREATE TABLE IF NOT EXISTS `conversations` (
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `site_id` VARCHAR(100) NOT NULL,
    `session_id` VARCHAR(100) NOT NULL,
    `sender` ENUM('client','bot') NOT NULL,
    `message` TEXT NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX `idx_site_session` (`site_id`, `session_id`),
    INDEX `idx_site_id` (`site_id`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Початкові дані (адміністратор)
-- =============================================
INSERT INTO `admins` (`username`, `password_hash`, `full_name`) 
VALUES (
    'admin',
    '$2y$12$8Q7z9vK5mL3pN8xR7tY6uV4wQ2aZ9xB8cD5eF7gH9iJ0kL2mN4oP6', 
    'Ruslan Bilohash'
)
ON DUPLICATE KEY UPDATE 
    password_hash = VALUES(password_hash);