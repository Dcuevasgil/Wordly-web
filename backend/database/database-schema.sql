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
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,


    FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE
);

-- ==============================
-- TABLA: camino de aprendizaje (catálogo)
-- Catálogo de caminos temáticos que existen en Wordly. Es una tabla de referencia: pocas filas, casi nunca cambia, y nadie la edita desde la aplicación (solo tú desde el panel de admin, cuando lo hagas)
-- ==============================
CREATE TABLE learning_paths (
    id_learning_paths BIGINT AUTO_INCREMENT PRIMARY KEY,

    code VARCHAR(50) NOT NULL UNIQUE, -- identificador de cada camino
    name VARCHAR(100) NOT NULL, -- el nombre bonito del camino
    description TEXT NULL,

    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

);


-- ==============================
-- TABLA: matrícula usuario-camino
-- ==============================
CREATE TABLE user_paths (
    id_user_paths BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    learning_path_id BIGINT NOT NULL,

    level ENUM('basic', 'intermediate', 'advanced') NOT NULL,
    self_assessment VARCHAR(50) NULL,

    is_active BOOLEAN DEFAULT TRUE,
    progress_percentage DECIMAL(5,2) DEFAULT 0.00,

    start_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_access_date DATETIME NULL,

    FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE,
    FOREIGN KEY (learning_path_id) REFERENCES learning_paths(id_learning_paths) ON DELETE CASCADE,

    UNIQUE(user_id, learning_path_id)
);


-- ==============================
-- TABLA: idiomas
-- ==============================
-- DROP TABLE languages;
CREATE TABLE languages (
    id_languages BIGINT AUTO_INCREMENT PRIMARY KEY,
    
    code VARCHAR(10) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    
    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    
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
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    
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
    times_reviewed INT DEFAULT 0,

    days_interval INT DEFAULT 1,
    ease_factor DECIMAL(3,2) DEFAULT 2.50,

    mastered_level INT DEFAULT 0,
    
    last_review DATETIME NULL,
    next_review DATETIME NULL,


    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    
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
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,


    FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE,
    FOREIGN KEY (word_id) REFERENCES words(id_words) ON DELETE CASCADE
);

-- ==============================
-- TABLA: intentos_ejercicios
-- ==============================
CREATE TABLE exercise_attempts (
    id_exercise_attempts BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,
    exercise_id BIGINT NOT NULL,
    exercise_answer_id BIGINT NULL,

    user_response TEXT NOT NULL,
    is_user_response_correct BOOLEAN NOT NULL,
    
    response_time_ms INT NOT NULL,
    attempt_date TIMESTAMP NOT NULL,

    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE,
    FOREIGN KEY (exercise_id) REFERENCES exercises(id_exercises) ON DELETE CASCADE,
    FOREIGN KEY (exercise_answer_id) REFERENCES exercise_answers(id_exercises) ON DELETE CASCADE
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
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE
);


-- ==============================
-- TABLA: ejercicios
-- ==============================
CREATE TABLE exercises (
    id_exercises BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY,

    type_exercise VARCHAR(50) NOT NULL,
    level ENUM('basic', 'intermediate', 'advanced') NOT NULL DEFAULT 'basic',
    topic_exercise VARCHAR(100) NOT NULL,
    question TEXT NOT NULL,
    explanation TEXT NOT NULL,


    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- ==============================
-- TABLA: respuestas_ejercicios
-- ==============================
CREATE TABLE exercise_answers (
    id_exercise_answers BIGINT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    exercise_id BIGINT NOT NULL,

    answer TEXT NOT NULL,
    is_correct_answer BOOLEAN DEFAULT FALSE,

    explanation TEXT NOT NULL,

    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (exercise_id) REFERENCES exercises(id_exercises) ON DELETE CASCADE
);


-- ==============================
-- TABLA: conversaciones del chat
-- ==============================
CREATE TABLE chat_conversations (
    id_chat_conversations BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT NOT NULL,

    title VARCHAR(150) NULL,
    is_active BOOLEAN DEFAULT TRUE,

    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE
);


-- ==============================
-- TABLA: mensajes del chat
-- ==============================
CREATE TABLE chat_messages (
    id_chat_messages BIGINT AUTO_INCREMENT PRIMARY KEY,
    conversation_id BIGINT NOT NULL,

    role ENUM('user', 'assistant') NOT NULL,
    content TEXT NOT NULL,

    model VARCHAR(50) NULL,
    tokens_used INT NULL,
    latency_ms INT NULL,

    register_date DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (conversation_id) REFERENCES chat_conversations(id_chat_conversations) ON DELETE CASCADE
);


-- Alter tables




-- users
ALTER TABLE users ADD streak INT NOT NULL DEFAULT 0;
ALTER TABLE users ADD last_activity_date DATE;
ALTER TABLE wordly.exercises AUTO_INCREMENT = 1;


-- 1. Quitar las tres FK
ALTER TABLE exercise_attempts DROP FOREIGN KEY exercise_attempts_user_id_foreign;
ALTER TABLE user_paths DROP FOREIGN KEY user_paths_ibfk_1;
ALTER TABLE user_words DROP FOREIGN KEY user_words_user_id_foreign;

-- 2. La PK de users a signed
ALTER TABLE users MODIFY id_users BIGINT NOT NULL AUTO_INCREMENT;

-- 3. Las columnas hijas a signed
ALTER TABLE exercise_attempts MODIFY user_id BIGINT NOT NULL;
ALTER TABLE user_paths MODIFY user_id BIGINT NOT NULL;
ALTER TABLE user_words MODIFY user_id BIGINT NOT NULL;

-- 4. Recrear las FK
ALTER TABLE exercise_attempts ADD CONSTRAINT exercise_attempts_user_id_foreign
  FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE;
ALTER TABLE user_paths ADD CONSTRAINT user_paths_user_id_foreign
  FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE;
ALTER TABLE user_words ADD CONSTRAINT user_words_user_id_foreign
  FOREIGN KEY (user_id) REFERENCES users(id_users) ON DELETE CASCADE;



-- Renames
RENAME TABLE exercises_answers TO exercise_answers;


-- Indices
CREATE INDEX idx_password_reset_token ON password_resets(reset_token);
CREATE INDEX idx_chat_messages_conversation ON chat_messages(conversation_id, register_date);