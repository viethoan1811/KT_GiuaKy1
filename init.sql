CREATE DATABASE IF NOT EXISTS QL_NhanSu;

USE QL_NhanSu;

CREATE TABLE IF NOT EXISTS PHONGBAN (
    Ma_Phong varchar(2) NOT NULL,
    Ten_Phong varchar(30) NOT NULL,
    PRIMARY KEY (Ma_Phong)
);

CREATE TABLE IF NOT EXISTS NHANVIEN (
    Ma_NV varchar(3) NOT NULL,
    Ten_NV varchar(100) NOT NULL,
    Phai varchar(3),
    Noi_Sinh varchar(200),
    Ma_Phong varchar(2),
    Luong int,
    PRIMARY KEY (Ma_NV),
    FOREIGN KEY (Ma_Phong) REFERENCES PHONGBAN(Ma_Phong)
);

CREATE TABLE IF NOT EXISTS user (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    fullname VARCHAR(100),
    email VARCHAR(100),
    role ENUM('admin', 'user') NOT NULL
);

INSERT INTO PHONGBAN (Ma_Phong, Ten_Phong) VALUES
('QT', 'Quản Trị'),
('TC', 'Tài Chính'),
('KT', 'Kỹ Thuật');

INSERT INTO NHANVIEN (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) VALUES
('A01', 'Nguyễn Thị Hải', 'NU', 'Hà Nội', 'TC', 600),
('A02', 'Trần Văn Chính', 'NAM', 'Bình Định', 'QT', 500),
('A03', 'Lê Trần Bạch Yến', 'NU', 'TP HCM', 'TC', 700),
('A04', 'Trần Anh Tuấn', 'NAM', 'Hà Nội', 'KT', 800),
('B01', 'Trần Thanh Mai', 'NU', 'Hải Phòng', 'TC', 800),
('B02', 'Trần Thị Thu Thủy', 'NU', 'TP HCM', 'KT', 700),
('B03', 'Nguyễn Thị Nở', 'NU', 'Ninh Bình', 'KT', 400);

INSERT INTO user (username, password, fullname, email, role) VALUES
('admin', 'adminpassword', 'Administrator', 'admin@example.com', 'admin'),
('user1', 'user1password', 'User One', 'user1@example.com', 'user'),
('user2', 'user2password', 'User Two', 'user2@example.com', 'user');
