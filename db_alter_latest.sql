 -- Run this on existing database without full re-import

ALTER TABLE users
  ADD COLUMN IF NOT EXISTS google_id VARCHAR(191) NULL UNIQUE AFTER email,
  MODIFY COLUMN password_hash VARCHAR(255) NULL,
  ADD COLUMN IF NOT EXISTS teacher_subject VARCHAR(120) NULL AFTER teacher_id;

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
