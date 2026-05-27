CREATE DATABASE IF NOT EXISTS ulpiana_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ulpiana_db;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  google_id VARCHAR(191) NULL UNIQUE,
  password_hash VARCHAR(255) NULL,
  role ENUM('admin','teacher','parent','student') NOT NULL,
  teacher_id VARCHAR(20) NULL,
  teacher_subject VARCHAR(120) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS bookings (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  teacher_id VARCHAR(20) NOT NULL,
  teacher_name VARCHAR(120) NOT NULL,
  teacher_subject VARCHAR(120) NOT NULL,
  teacher_email VARCHAR(190) NOT NULL,
  slot_time VARCHAR(10) NOT NULL,
  parent_name VARCHAR(120) NOT NULL,
  student_name VARCHAR(120) NOT NULL,
  parent_email VARCHAR(190) NOT NULL,
  topic VARCHAR(255) NULL,
  status ENUM('pending','accepted','rejected') DEFAULT 'pending',
  created_by_user_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_teacher_slot (teacher_id, slot_time),
  INDEX idx_teacher_time (teacher_id, slot_time),
  INDEX idx_status (status)
);

CREATE TABLE IF NOT EXISTS teacher_settings (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE,
  display_name VARCHAR(120) NULL,
  notifications ENUM('on','off') DEFAULT 'on',
  language_code VARCHAR(10) DEFAULT 'sq',
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS grades (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  teacher_user_id INT NOT NULL,
  student_name VARCHAR(120) NOT NULL,
  subject VARCHAR(120) NOT NULL,
  grade_value VARCHAR(10) NOT NULL,
  comment_text VARCHAR(255) NULL,
  is_published TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_student (student_name),
  INDEX idx_published (is_published)
);

CREATE TABLE IF NOT EXISTS announcements (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  content TEXT NOT NULL,
  audience ENUM('all','parents','students','teachers') DEFAULT 'all',
  created_by_user_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_created_at (created_at)
);

CREATE TABLE IF NOT EXISTS safeguarding_reports (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  reporter_name VARCHAR(120) NULL,
  reporter_email VARCHAR(190) NULL,
  is_anonymous TINYINT(1) DEFAULT 1,
  category ENUM('bullying','violence','wellbeing','other') NOT NULL,
  message_text TEXT NOT NULL,
  status ENUM('new','in_review','resolved') DEFAULT 'new',
  assigned_to_user_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_status (status),
  INDEX idx_created_at (created_at)
);

CREATE TABLE IF NOT EXISTS password_resets (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  email VARCHAR(190) NOT NULL,
  token_hash VARCHAR(255) NOT NULL,
  expires_at DATETIME NOT NULL,
  used_at DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_email (email),
  INDEX idx_expires (expires_at)
);

CREATE TABLE IF NOT EXISTS audit_logs (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  actor_user_id INT NULL,
  action_name VARCHAR(120) NOT NULL,
  target_type VARCHAR(80) NULL,
  target_id VARCHAR(80) NULL,
  details_json TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_actor (actor_user_id),
  INDEX idx_action (action_name),
  INDEX idx_created_at (created_at)
);

CREATE TABLE IF NOT EXISTS scheduled_posts (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  source_prompt TEXT NULL,
  title VARCHAR(180) NOT NULL,
  content TEXT NOT NULL,
  audience ENUM('all','parents','students','teachers') DEFAULT 'all',
  status ENUM('scheduled','published','cancelled') DEFAULT 'scheduled',
  publish_at DATETIME NOT NULL,
  published_at DATETIME NULL,
  created_by_user_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_publish_at (publish_at),
  INDEX idx_status (status)
);

CREATE TABLE IF NOT EXISTS resources (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  category VARCHAR(100) NOT NULL DEFAULT 'general',
  file_path VARCHAR(255) NOT NULL,
  uploaded_by_user_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_category (category),
  INDEX idx_uploaded_by (uploaded_by_user_id),
  INDEX idx_created_at (created_at)
);

INSERT IGNORE INTO users (id, full_name, email, password_hash, role, teacher_id)
VALUES

  (1, 'Admin Ulpiana', 'admin@ulpiana.edu', '$2y$10$VQvtnYxE7NwXfqb6lAq2POA.8D7Y6q6vE57IqG74P0mSV8RzWEWVC', 'admin', NULL);
-- Password: 12345


