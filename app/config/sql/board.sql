--
-- Create database
--
CREATE DATABASE IF NOT EXISTS board;
GRANT SELECT, INSERT, UPDATE, DELETE ON board.* TO "root@localhost" IDENTIFIED BY "root";
FLUSH PRIVILEGES;

--
-- Create tables
--

USE board;

CREATE TABLE IF NOT EXISTS thread (
id                      INT UNSIGNED NOT NULL AUTO_INCREMENT,
user_id                 INT UNSIGNED NOT NULL,
title                   VARCHAR(255) NOT NULL,
created                 DATETIME NOT NULL,
PRIMARY KEY(id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS comment (
id                      INT UNSIGNED NOT NULL AUTO_INCREMENT,
thread_id               INT UNSIGNED NOT NULL,
user_id                 INT UNSIGNED NOT NULL,
body                    TEXT NOT NULL,
created                 DATETIME NOT NULL,
PRIMARY KEY (id),
INDEX (thread_id, created)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS user (
id                      INT UNSIGNED NOT NULL AUTO_INCREMENT,
username                VARCHAR(25) NOT NULL,
password                VARCHAR(32) NOT NULL,
PRIMARY KEY(id)
)ENGINE=InnoDB;