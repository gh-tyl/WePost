DROP DATABASE IF EXISTS `WePostDB`;
CREATE DATABASE `WePostDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `WePostDB`;
DROP TABLE IF EXISTS `user_table`;
CREATE TABLE `WePostDB`.`user_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `password` VARCHAR(200) NOT NULL,
  `gender` VARCHAR(50),
  `age` INT,
  `country` VARCHAR(50),
  `image_path` VARCHAR(200),
  `role` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
  );

DROP TABLE IF EXISTS `genre_table`;
CREATE TABLE `WePostDB`.`genre_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `genre` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
  );

DROP TABLE IF EXISTS `article_table`;
CREATE TABLE `WePostDB`.`article_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `content_path` VARCHAR(200) NOT NULL,
  `genre_id_01` INT NOT NULL,
  `genre_id_02` INT,
  `genre_id_03` INT,
  `likes` INT NOT NULL,
  `stores` INT NOT NULL,
  `datetime` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`genre_id_01`) REFERENCES `genre_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`genre_id_02`) REFERENCES `genre_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`genre_id_03`) REFERENCES `genre_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
  );

DROP TABLE IF EXISTS `article_pic_table`;
CREATE TABLE `WePostDB`.`article_pic_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `article_id` INT NOT NULL,
  `json_path` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`article_id`) REFERENCES `article_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
  );

DROP TABLE IF EXISTS `comment_table`;
CREATE TABLE `WePostDB`.`comment_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `article_id` INT NOT NULL,
  `comment` VARCHAR(200) NOT NULL,
  `datetime` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`article_id`) REFERENCES `article_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
  );

DROP TABLE IF EXISTS `comment_pic_table`;
CREATE TABLE `WePostDB`.`comment_pic_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `comment_id` INT NOT NULL,
  `json_path` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`comment_id`) REFERENCES `comment_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
  );

DROP TABLE IF EXISTS `like_table`;
CREATE TABLE `WePostDB`.`like_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `article_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`article_id`) REFERENCES `article_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
  );

DROP TABLE IF EXISTS `store_table`;
CREATE TABLE `WePostDB`.`store_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `article_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`article_id`) REFERENCES `article_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
  );

DROP TABLE IF EXISTS `follow_table`;
CREATE TABLE `WePostDB`.`follow_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `follow_user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`follow_user_id`) REFERENCES `user_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
  );

DROP TABLE IF EXISTS `login_table`;
CREATE TABLE `WePostDB`.`login_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `datetime` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user_table`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
  );

-- index
CREATE INDEX `user_id` ON `article_table` (`user_id`);
CREATE INDEX `user_id` ON `article_pic_table` (`article_id`);
CREATE INDEX `user_id` ON `comment_table` (`user_id`);
CREATE INDEX `article_id` ON `comment_table` (`article_id`);
CREATE INDEX `comment_id` ON `comment_pic_table` (`comment_id`);
CREATE INDEX `user_id` ON `like_table` (`user_id`);
CREATE INDEX `article_id` ON `like_table` (`article_id`);
CREATE INDEX `user_id` ON `store_table` (`user_id`);
CREATE INDEX `article_id` ON `store_table` (`article_id`);
CREATE INDEX `user_id` ON `follow_table` (`user_id`);
CREATE INDEX `follow_user_id` ON `follow_table` (`follow_user_id`);
CREATE INDEX `user_id` ON `login_table` (`user_id`);

-- load sql file
source /tmp/user_table.sql
source /tmp/genre_table.sql
source /tmp/article_table.sql
source /tmp/article_pic_table.sql
source /tmp/comment_table.sql
source /tmp/comment_pic_table.sql
source /tmp/like_table.sql
source /tmp/store_table.sql
source /tmp/follow_table.sql
source /tmp/login_table.sql
