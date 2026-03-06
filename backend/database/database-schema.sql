-- Active: 1771793694776@@127.0.0.1@3306@wordly
/*
BBDD para el proyecto de vocabulario
*/


CREATE DATABASE IF NOT EXISTS wordly;
USE wordly;

-- ==============================
-- TABLA: usuarios
-- ==============================
CREATE TABLE users (
    id_users BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user',
    is_user_active BOOLEAN DEFAULT TRUE,
    last_access DATETIME NULL,
    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

DROP TABLE password_resets;
CREATE TABLE password_resets (
    id_password_reset BIGINT AUTO_INCREMENT PRIMARY KEY,
    
    user_id BIGINT NOT NULL,
    
    reset_token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    used BOOLEAN DEFAULT FALSE,

    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,


    FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE
);

-- ==============================
-- TABLA: camino de aprendizaje
-- ==============================
CREATE TABLE learning_path (
    id_learning_path BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT NULL,
    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_date DATETIME ON UPDATE CURRENT_TIMESTAMP
);

-- ==============================
-- TABLA: usuario_camino
-- ==============================
CREATE TABLE user_path (
    id_user_path BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    learning_path_id BIGINT NOT NULL,

	which_learning_path_is_active ENUM('general','developer') NOT NULL DEFAULT 'general',
    progress_percentage DECIMAL(5,2) DEFAULT 0.00,
    which_user_path_is_active BOOLEAN DEFAULT TRUE,

    start_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_access_date DATETIME NULL,


    FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE,
    FOREIGN KEY (learning_path_id) REFERENCES learning_path(id_learning_path) ON DELETE CASCADE,


    UNIQUE(user_id, learning_path_id)

);


-- ==============================
-- TABLA: idiomas
-- ==============================
-- DROP TABLE languages;
CREATE TABLE languages (
    id_languages BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(10) NOT NULL UNIQUE,
    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ==============================
-- TABLA: palabras
-- ==============================
CREATE TABLE words (
    id_words BIGINT AUTO_INCREMENT PRIMARY KEY,
    origin_language_id BIGINT NOT NULL,
    text VARCHAR(255) NOT NULL,
    difficult INT DEFAULT 1,
    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    
    FOREIGN KEY (origin_language_id) REFERENCES languages(id_languages) ON DELETE CASCADE
);

-- ==============================
-- TABLA: traducciones
-- ==============================
CREATE TABLE translations (
    id_translations BIGINT AUTO_INCREMENT PRIMARY KEY,
    word_id BIGINT NOT NULL,
    target_language_id BIGINT NOT NULL,
    translation VARCHAR(255) NOT NULL,
    example TEXT NULL,
    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    
    FOREIGN KEY (word_id) REFERENCES words(id_words) ON DELETE CASCADE,
    FOREIGN KEY (target_language_id) REFERENCES languages(id_languages) ON DELETE CASCADE
);

-- ==============================
-- TABLA: usuario_palabras
-- ==============================
CREATE TABLE user_words (
    id_user_words BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    word_id BIGINT NOT NULL,

    times_correct INT DEFAULT 0,
    times_failed INT DEFAULT 0,
    veces_reviewed INT DEFAULT 0,

    days_interval INT DEFAULT 1,
    ease_factor DECIMAL(3,2) DEFAULT 2.50,

    last_review DATETIME NULL,
    next_review DATETIME NULL,

    mastered_level INT DEFAULT 0,

    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    
    FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE,
    FOREIGN KEY (word_id) REFERENCES words(id_words) ON DELETE CASCADE,
    
    
    UNIQUE(user_id, word_id)
);

-- ==============================
-- TABLA: intentos_palabra
-- ==============================
CREATE TABLE word_attempts (
    id_word_attempts BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    word_id BIGINT NOT NULL,

    user_response TEXT NULL,
    is_user_response_correct BOOLEAN NOT NULL,
    response_time_ms INT NULL,
    attempt_date DATETIME NOT NULL,

    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,


    FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE,
    FOREIGN KEY (word_id) REFERENCES words(id_words) ON DELETE CASCADE
);

-- ==============================
-- TABLA: sesiones_estudio
-- ==============================
CREATE TABLE study_sessions (
    id_study_sessions BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,

    start_date DATETIME NOT NULL,
    end_date DATETIME NULL,

    total_words INT DEFAULT 0,
    total_correct INT DEFAULT 0,
    total_failures INT DEFAULT 0,

    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE
);



-- Alter tables






-- Indices
CREATE INDEX idx_password_reset_token ON password_resets(reset_token);