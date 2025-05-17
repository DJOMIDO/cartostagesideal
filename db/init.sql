-- 创建数据库
CREATE DATABASE IF NOT EXISTS cartostages CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 使用数据库
USE cartostages;

-- 创建用户表
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 插入示例用户数据（明文密码）
INSERT INTO users (username, email, password) VALUES 
('admin', 'admin@example.com', 'admin123'),
('user1', 'user1@example.com', 'password1'),
('user2', 'user2@example.com', 'password2');


-- 创建招聘信息表
CREATE TABLE IF NOT EXISTS offres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sujet MEDIUMTEXT NOT NULL,
    organisme VARCHAR(50) NOT NULL,
    duree VARCHAR(200) NOT NULL,
    niveau VARCHAR(30) NOT NULL,
    parcours VARCHAR(50) NOT NULL,
    lieu TEXT NOT NULL,
    fichier VARCHAR(30) NOT NULL,
    description MEDIUMTEXT NOT NULL,
    critere VARCHAR(500) NOT NULL,
    contact VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    gratification VARCHAR(10) DEFAULT NULL,
    date DATE NOT NULL,
    dumas VARCHAR(500) NOT NULL,
    archives TINYINT(1) NOT NULL DEFAULT 0,
    effectue TINYINT(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 插入示例招聘信息数据
INSERT INTO offers (sujet, organisme, duree, niveau, parcours, lieu, fichier, description, critere, contact, email, gratification, date, dumas, archives, effectue) 
VALUES 
('Stage en développement web', 'Tech Corp', '6 mois', 'Master', 'Informatique', 'Paris', 'offre.pdf', 'Développement d\'une application web.', 'Connaissance en React et Node.js', 'Jean Dupont', 'jean@example.com', '600€/mois', '2025-05-01', 'document.pdf', 0, 0),
('Offre de stage en marketing', 'Market Inc', '3 mois', 'Licence', 'Marketing', 'Lyon', 'marketing.pdf', 'Aide à la stratégie marketing.', 'Compétences en communication', 'Marie Durand', 'marie@example.com', NULL, '2025-05-10', 'plan.pdf', 0, 1);
