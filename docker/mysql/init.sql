DROP DATABASE IF EXISTS `cliq-books`;

CREATE DATABASE `cliq-books` CHARACTER SET utf8mb4;

USE `cliq-books`;

CREATE TABLE `books` (id INT PRIMARY KEY AUTO_INCREMENT, title varchar(1024) not null, isbn  varchar(32));

CREATE TABLE `authors`(id INT PRIMARY KEY AUTO_INCREMENT, `name` varchar(255) not null);

CREATE TABLE `books_authors` (book_id INT, author_id INT, FOREIGN KEY (book_id) REFERENCES `books` (id) ON DELETE CASCADE, FOREIGN KEY (author_id) REFERENCES authors (id) ON DELETE CASCADE);

