CREATE DATABASE IF NOT EXISTS wifi_db;
USE wifi_db;

CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE,
  password VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  status VARCHAR(20) DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS devices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  device_name VARCHAR(200),
  mac_address VARCHAR(50),
  ip_address VARCHAR(50),
  zone VARCHAR(100),
  status ENUM('active','blocked') DEFAULT 'active',
  bandwidth FLOAT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS zones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  zone_name VARCHAR(200),
  clients INT DEFAULT 0,
  health INT DEFAULT 100
);

CREATE TABLE IF NOT EXISTS logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  action VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- sample zones
INSERT INTO zones (zone_name, clients, health) VALUES
('Main Hall AP', 120, 98),
('Library AP', 85, 95),
('Computer Lab AP', 50, 88),
('Hostels AP', 320, 92);

-- sample devices
INSERT INTO devices (device_name, mac_address, ip_address, zone, status, bandwidth) VALUES
('Amon-Laptop','AC:23:3F:9A:11:22','10.0.0.23','Library AP','active',12.4),
('BBUC-Phone-1','BC:14:4A:8F:44:21','10.0.0.45','Main Hall AP','active',4.1),
('Lab-PC-12','CC:33:AA:23:77:88','10.0.1.12','Computer Lab AP','blocked',0),
('Guest-Phone-4','DD:44:BB:11:55:66','10.0.2.18','Guest AP','active',1.2);
