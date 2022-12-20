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

insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1000, 'Rikki', 'Balthasar', 'rbalthasar0@xinhuanet.com', 'icojbDbFH1T', null, null, null, 'Admin');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1001, 'Fey', 'Grimes', 'fgrimes1@usatoday.com', 'hMoCJKOPav7', 'Female', null, null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1002, 'Faustina', 'Hedger', 'fhedger2@surveymonkey.com', 'TFI5eeqAC', 'Female', 'Russia', null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1003, 'Brigham', 'Ranger', 'branger3@shareasale.com', 'yYINwhzx', 'Male', null, null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1004, 'Matty', 'Munning', 'mmunning4@nymag.com', 'VixavgM0xcE', 'Male', 'Indonesia', null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1005, 'Tobe', 'Radcliffe', 'tradcliffe5@imageshack.us', 'IzY9jAqrFfs', null, 'Sweden', null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1006, 'Pet', 'Tamplin', 'ptamplin6@google.com', 'LCDlL5', 'Female', null, null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1007, 'Lorena', 'Jiru', 'ljiru7@bigcartel.com', 'MEO6qdUSEcT', 'Female', 'Russia', null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1008, 'Gussi', 'Giacaponi', 'ggiacaponi8@canalblog.com', '01JfqzOcyN', 'Female', null, null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1009, 'Erma', 'Manning', 'emanning9@furl.net', '6LyMVuQdcU', null, null, null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1010, 'Vinny', 'Drezzer', 'vdrezzera@webeden.co.uk', '33HM6WrXPVg', null, 'Indonesia', null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1011, 'Gregory', 'Vertey', 'gverteyb@hp.com', '16Sdce43', 'Male', null, null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1012, 'Linnet', 'Eloy', 'leloyc@tuttocitta.it', '7ASLKpOfyniU', 'Female', null, null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1013, 'Trix', 'Po', 'tpod@i2i.jp', 'MGRfnGEe', null, null, null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1014, 'Karen', 'Trim', 'ktrime@list-manage.com', 'fUJ3L3c', null, null, null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1015, 'Dominga', 'Elliker', 'dellikerf@yale.edu', 'n8QiM7BPM1c', null, null, null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1016, 'Hyacintha', 'MacAllen', 'hmacalleng@shutterfly.com', 'O8uvjy0SqwHZ', 'Female', null, null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1017, 'Carree', 'Daice', 'cdaiceh@dell.com', 'LrJKG7EDE', null, 'Guadeloupe', null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1018, 'Culver', 'Lots', 'clotsi@freewebs.com', 'mpNUZWXh6gP', null, 'Czech Republic', null, 'User');
insert into user_table (id, first_name, last_name, email, password, gender, country, image_path, role) values (1019, 'Arch', 'Tandey', 'atandeyj@ning.com', 'BnN5xI', null, null, null, 'User');

insert into genre_table (id, genre) values (1, 'hrakestraw0');
insert into genre_table (id, genre) values (2, 'skhoter1');
insert into genre_table (id, genre) values (3, 'bpischoff2');
insert into genre_table (id, genre) values (4, 'varbon3');
insert into genre_table (id, genre) values (5, 'lfenney4');
insert into genre_table (id, genre) values (6, 'dmaypes5');
insert into genre_table (id, genre) values (7, 'bgerbl6');
insert into genre_table (id, genre) values (8, 'rraynton7');
insert into genre_table (id, genre) values (9, 'ublonfield8');
insert into genre_table (id, genre) values (10, 'dyaneev9');
insert into genre_table (id, genre) values (11, 'sbrickstocka');
insert into genre_table (id, genre) values (12, 'tchessunb');
insert into genre_table (id, genre) values (13, 'hocaheyc');
insert into genre_table (id, genre) values (14, 'thaylesd');
insert into genre_table (id, genre) values (15, 'cmcqueene');
insert into genre_table (id, genre) values (16, 'bhunnaballf');
insert into genre_table (id, genre) values (17, 'lkordasg');
insert into genre_table (id, genre) values (18, 'cleggotth');
insert into genre_table (id, genre) values (19, 'jbedminsteri');
insert into genre_table (id, genre) values (20, 'jrussej');

insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (1, 1010, 'path/to/file', 20, 16, 1, 23, 49, '2022-07-31 21:43:16');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (2, 1003, 'path/to/file', 17, 15, 6, 89, 90, '2022-05-09 21:57:00');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (3, 1005, 'path/to/file', 6, 14, 5, 98, 22, '2022-09-07 14:32:42');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (4, 1003, 'path/to/file', 16, 10, 11, 66, 12, '2021-12-02 09:28:22');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (5, 1001, 'path/to/file', 14, 11, 10, 6, 76, '2022-10-01 20:46:50');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (6, 1010, 'path/to/file', 12, 10, 11, 25, 77, '2022-12-11 03:22:14');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (7, 1008, 'path/to/file', 13, 12, 14, 88, 79, '2022-02-10 08:30:44');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (8, 1010, 'path/to/file', 14, 12, 18, 91, 46, '2022-09-02 19:58:47');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (9, 1007, 'path/to/file', 7, 8, 2, 3, 80, '2022-08-21 02:08:53');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (10, 1009, 'path/to/file', 4, 14, 18, 81, 48, '2021-12-07 07:26:32');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (11, 1011, 'path/to/file', 3, 8, 6, 15, 58, '2022-10-23 04:55:27');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (12, 1011, 'path/to/file', 3, 5, 1, 65, 30, '2022-09-09 10:53:42');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (13, 1013, 'path/to/file', 17, 12, 11, 61, 77, '2022-09-23 16:12:23');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (14, 1016, 'path/to/file', 9, 11, 7, 34, 96, '2022-04-27 19:31:02');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (15, 1003, 'path/to/file', 15, 11, 7, 10, 50, '2022-06-24 22:22:18');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (16, 1008, 'path/to/file', 17, 3, 14, 15, 48, '2022-01-22 23:50:38');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (17, 1000, 'path/to/file', 18, 7, 2, 61, 82, '2022-03-17 03:49:59');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (18, 1009, 'path/to/file', 15, 2, 20, 89, 95, '2022-11-23 18:40:43');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (19, 1017, 'path/to/file', 9, 11, 20, 83, 50, '2022-06-03 21:54:03');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (20, 1002, 'path/to/file', 17, 14, 20, 20, 58, '2022-12-20 08:23:35');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (21, 1019, 'path/to/file', 9, 19, 14, 12, 40, '2022-06-06 12:21:40');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (22, 1006, 'path/to/file', 3, 9, 16, 87, 35, '2022-07-26 08:16:55');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (23, 1016, 'path/to/file', 7, 9, 12, 58, 56, '2021-12-27 08:04:50');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (24, 1004, 'path/to/file', 2, 12, 20, 19, 64, '2021-12-14 20:37:06');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (25, 1010, 'path/to/file', 5, 3, 1, 58, 40, '2022-11-10 13:01:13');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (26, 1009, 'path/to/file', 4, 16, 2, 36, 11, '2022-09-13 10:14:42');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (27, 1019, 'path/to/file', 4, 6, 3, 75, 71, '2022-10-31 09:34:49');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (28, 1011, 'path/to/file', 2, 6, 20, 83, 27, '2022-09-14 22:52:07');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (29, 1014, 'path/to/file', 8, 2, 10, 52, 18, '2022-10-02 07:24:16');
insert into article_table (id, user_id, content_path, genre_id_01, genre_id_02, genre_id_03, likes, stores, datetime) values (30, 1012, 'path/to/file', 9, 11, 2, 42, 70, '2022-10-15 08:34:52');

insert into article_pic_table (id, article_id, json_path) values (1, 1, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (2, 2, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (3, 3, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (4, 4, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (5, 5, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (6, 6, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (7, 7, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (8, 8, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (9, 9, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (10, 10, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (11, 11, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (12, 12, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (13, 13, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (14, 14, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (15, 15, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (16, 16, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (17, 17, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (18, 18, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (19, 19, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (20, 20, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (21, 21, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (22, 22, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (23, 23, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (24, 24, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (25, 25, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (26, 26, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (27, 27, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (28, 28, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (29, 29, '/path/to/file');
insert into article_pic_table (id, article_id, json_path) values (30, 30, '/path/to/file');

insert into comment_table (id, user_id, article_id, comment, datetime) values (1000, 1006, 22, 'leo odio porttitor id consequat in consequat ut nulla sed accumsan felis ut at dolor quis odio consequat', '2022-05-09 16:02:54');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1001, 1016, 6, 'congue diam id ornare imperdiet sapien urna pretium nisl ut volutpat sapien arcu sed augue aliquam erat volutpat', '2022-03-30 19:23:48');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1002, 1012, 10, 'quam fringilla rhoncus mauris enim leo rhoncus sed vestibulum sit amet cursus id turpis integer', '2022-06-10 16:03:07');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1003, 1014, 18, 'ut nunc vestibulum ante ipsum primis in faucibus orci luctus et', '2022-02-14 04:15:35');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1004, 1015, 2, 'quam pharetra magna ac consequat metus sapien ut nunc vestibulum ante ipsum', '2022-04-17 14:08:56');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1005, 1015, 7, 'urna ut tellus nulla ut erat id mauris vulputate elementum nullam', '2022-07-30 06:12:53');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1006, 1004, 3, 'tempus vivamus in felis eu sapien cursus vestibulum proin eu', '2022-02-13 21:57:55');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1007, 1013, 27, 'eleifend donec ut dolor morbi vel lectus in quam fringilla', '2022-04-20 01:47:23');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1008, 1003, 9, 'duis faucibus accumsan odio curabitur convallis duis consequat dui nec nisi volutpat eleifend', '2022-04-05 15:39:23');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1009, 1003, 9, 'justo morbi ut odio cras mi pede malesuada in imperdiet et commodo', '2022-10-21 22:16:18');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1010, 1003, 7, 'ligula suspendisse ornare consequat lectus in est risus auctor sed tristique in tempus sit amet', '2022-12-10 21:49:53');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1011, 1014, 10, 'enim blandit mi in porttitor pede justo eu massa donec dapibus duis at velit eu est congue elementum', '2022-03-16 03:47:00');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1012, 1015, 29, 'ut ultrices vel augue vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia', '2022-11-26 15:02:31');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1013, 1004, 29, 'vel nisl duis ac nibh fusce lacus purus aliquet at feugiat non pretium quis lectus suspendisse potenti in eleifend quam', '2022-09-21 01:01:50');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1014, 1005, 26, 'vel lectus in quam fringilla rhoncus mauris enim leo rhoncus sed vestibulum sit', '2022-03-22 09:02:47');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1015, 1013, 15, 'etiam vel augue vestibulum rutrum rutrum neque aenean auctor gravida sem praesent id massa id nisl venenatis lacinia aenean', '2022-04-23 10:20:10');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1016, 1005, 2, 'mi in porttitor pede justo eu massa donec dapibus duis at velit eu est congue', '2022-01-05 22:17:23');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1017, 1007, 6, 'sapien cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus', '2022-11-16 12:22:22');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1018, 1018, 15, 'odio cras mi pede malesuada in imperdiet et commodo vulputate justo in blandit ultrices enim', '2022-10-19 14:26:08');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1019, 1009, 9, 'eget eleifend luctus ultricies eu nibh quisque id justo sit amet sapien dignissim vestibulum', '2022-01-23 23:31:24');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1020, 1007, 5, 'donec vitae nisi nam ultrices libero non mattis pulvinar nulla pede ullamcorper augue a suscipit nulla elit ac', '2022-01-12 15:35:31');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1021, 1006, 27, 'ligula sit amet eleifend pede libero quis orci nullam molestie nibh in lectus pellentesque at nulla suspendisse potenti', '2022-08-07 19:00:09');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1022, 1006, 11, 'maecenas rhoncus aliquam lacus morbi quis tortor id nulla ultrices aliquet maecenas leo odio', '2022-11-01 12:09:47');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1023, 1008, 15, 'vivamus vestibulum sagittis sapien cum sociis natoque penatibus et magnis', '2022-03-26 15:17:31');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1024, 1008, 5, 'dapibus nulla suscipit ligula in lacus curabitur at ipsum ac tellus semper interdum mauris ullamcorper', '2021-12-21 08:49:22');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1025, 1018, 9, 'rutrum neque aenean auctor gravida sem praesent id massa id nisl venenatis lacinia', '2022-05-20 21:50:33');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1026, 1010, 18, 'odio condimentum id luctus nec molestie sed justo pellentesque viverra pede ac diam cras pellentesque volutpat', '2022-09-25 09:37:33');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1027, 1015, 24, 'at turpis donec posuere metus vitae ipsum aliquam non mauris morbi non lectus aliquam sit amet diam in magna bibendum', '2021-12-19 19:25:39');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1028, 1009, 28, 'venenatis tristique fusce congue diam id ornare imperdiet sapien urna pretium', '2022-11-10 00:46:05');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1029, 1003, 3, 'turpis nec euismod scelerisque quam turpis adipiscing lorem vitae mattis nibh ligula nec', '2021-12-23 13:33:14');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1030, 1018, 11, 'morbi sem mauris laoreet ut rhoncus aliquet pulvinar sed nisl', '2022-09-19 15:07:15');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1031, 1005, 22, 'posuere cubilia curae mauris viverra diam vitae quam suspendisse potenti nullam porttitor lacus at turpis donec posuere metus', '2022-06-22 20:18:02');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1032, 1005, 24, 'consectetuer adipiscing elit proin risus praesent lectus vestibulum quam sapien varius', '2022-12-05 19:41:45');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1033, 1010, 6, 'at vulputate vitae nisl aenean lectus pellentesque eget nunc donec quis orci eget orci vehicula condimentum', '2022-07-25 16:33:33');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1034, 1004, 16, 'eu nibh quisque id justo sit amet sapien dignissim vestibulum vestibulum ante ipsum primis in faucibus orci luctus et', '2022-09-04 23:36:29');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1035, 1001, 15, 'nibh in hac habitasse platea dictumst aliquam augue quam sollicitudin vitae consectetuer eget rutrum at', '2022-05-16 01:15:03');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1036, 1000, 14, 'in imperdiet et commodo vulputate justo in blandit ultrices enim lorem', '2022-04-20 06:06:36');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1037, 1014, 17, 'ligula sit amet eleifend pede libero quis orci nullam molestie nibh in lectus pellentesque at nulla suspendisse potenti cras', '2022-12-07 11:49:59');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1038, 1006, 1, 'in hac habitasse platea dictumst aliquam augue quam sollicitudin vitae consectetuer eget', '2022-05-28 22:32:26');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1039, 1018, 12, 'donec quis orci eget orci vehicula condimentum curabitur in libero ut', '2022-02-25 07:22:48');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1040, 1005, 29, 'velit nec nisi vulputate nonummy maecenas tincidunt lacus at velit vivamus vel', '2022-02-09 06:26:50');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1041, 1013, 7, 'in hac habitasse platea dictumst morbi vestibulum velit id pretium iaculis diam erat fermentum', '2022-11-22 19:35:39');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1042, 1015, 18, 'nisi vulputate nonummy maecenas tincidunt lacus at velit vivamus vel nulla eget eros elementum pellentesque quisque porta volutpat erat', '2022-04-25 23:01:58');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1043, 1009, 11, 'turpis elementum ligula vehicula consequat morbi a ipsum integer a nibh in', '2022-02-26 11:51:41');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1044, 1006, 16, 'varius integer ac leo pellentesque ultrices mattis odio donec vitae nisi nam', '2022-12-10 22:01:02');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1045, 1013, 9, 'ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae mauris', '2021-12-27 18:11:37');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1046, 1012, 23, 'justo etiam pretium iaculis justo in hac habitasse platea dictumst etiam faucibus cursus urna ut tellus', '2022-07-22 16:31:43');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1047, 1004, 15, 'in faucibus orci luctus et ultrices posuere cubilia curae mauris viverra diam', '2022-02-13 17:53:38');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1048, 1011, 18, 'nam nulla integer pede justo lacinia eget tincidunt eget tempus vel pede morbi porttitor lorem', '2022-03-09 05:13:54');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1049, 1011, 17, 'accumsan odio curabitur convallis duis consequat dui nec nisi volutpat eleifend donec ut dolor morbi vel lectus in quam fringilla', '2022-05-31 17:39:39');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1050, 1010, 2, 'ut dolor morbi vel lectus in quam fringilla rhoncus mauris enim leo rhoncus sed', '2022-03-23 12:21:46');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1051, 1006, 20, 'eros elementum pellentesque quisque porta volutpat erat quisque erat eros viverra eget congue eget semper rutrum nulla', '2022-11-18 02:01:20');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1052, 1016, 13, 'in sagittis dui vel nisl duis ac nibh fusce lacus purus aliquet at feugiat non pretium quis lectus', '2022-06-12 10:04:48');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1053, 1010, 19, 'lorem ipsum dolor sit amet consectetuer adipiscing elit proin interdum mauris non ligula pellentesque', '2022-11-30 06:46:31');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1054, 1018, 24, 'vitae mattis nibh ligula nec sem duis aliquam convallis nunc proin at turpis a pede', '2022-02-25 00:49:17');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1055, 1008, 8, 'orci mauris lacinia sapien quis libero nullam sit amet turpis elementum ligula vehicula consequat morbi a ipsum', '2022-10-07 12:24:49');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1056, 1016, 30, 'congue elementum in hac habitasse platea dictumst morbi vestibulum velit id pretium iaculis', '2022-05-24 05:24:08');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1057, 1009, 2, 'penatibus et magnis dis parturient montes nascetur ridiculus mus etiam vel', '2022-09-01 11:28:15');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1058, 1019, 7, 'lacinia eget tincidunt eget tempus vel pede morbi porttitor lorem id ligula suspendisse', '2022-03-29 17:30:46');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1059, 1000, 18, 'tincidunt ante vel ipsum praesent blandit lacinia erat vestibulum sed magna at nunc commodo placerat', '2022-03-12 22:17:06');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1060, 1007, 24, 'in eleifend quam a odio in hac habitasse platea dictumst', '2022-07-24 18:20:48');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1061, 1010, 16, 'donec dapibus duis at velit eu est congue elementum in hac', '2022-03-01 07:11:10');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1062, 1014, 11, 'eget eleifend luctus ultricies eu nibh quisque id justo sit amet', '2022-04-05 20:15:40');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1063, 1017, 28, 'ante nulla justo aliquam quis turpis eget elit sodales scelerisque mauris sit amet eros suspendisse accumsan', '2022-12-05 01:03:50');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1064, 1017, 28, 'fusce lacus purus aliquet at feugiat non pretium quis lectus suspendisse potenti in eleifend quam', '2022-03-20 10:08:11');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1065, 1007, 25, 'vitae ipsum aliquam non mauris morbi non lectus aliquam sit amet diam in magna', '2022-06-02 20:17:54');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1066, 1003, 28, 'elit proin interdum mauris non ligula pellentesque ultrices phasellus id sapien in', '2022-08-25 07:15:07');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1067, 1015, 10, 'non velit nec nisi vulputate nonummy maecenas tincidunt lacus at velit vivamus vel nulla eget', '2022-08-16 15:16:24');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1068, 1002, 25, 'pulvinar lobortis est phasellus sit amet erat nulla tempus vivamus in felis eu sapien cursus vestibulum proin eu mi nulla', '2022-06-21 14:48:57');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1069, 1013, 28, 'odio curabitur convallis duis consequat dui nec nisi volutpat eleifend', '2022-01-14 13:32:43');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1070, 1005, 21, 'non mauris morbi non lectus aliquam sit amet diam in magna bibendum imperdiet nullam orci pede venenatis non', '2022-01-13 10:42:24');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1071, 1007, 19, 'consequat in consequat ut nulla sed accumsan felis ut at dolor quis odio consequat varius integer ac leo pellentesque ultrices', '2022-12-01 05:10:04');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1072, 1005, 30, 'in libero ut massa volutpat convallis morbi odio odio elementum eu interdum eu tincidunt in leo', '2022-02-19 12:22:07');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1073, 1000, 28, 'leo maecenas pulvinar lobortis est phasellus sit amet erat nulla tempus vivamus in felis eu sapien cursus vestibulum proin eu', '2022-03-31 19:49:08');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1074, 1006, 27, 'mattis pulvinar nulla pede ullamcorper augue a suscipit nulla elit ac nulla sed vel enim sit amet nunc', '2022-08-26 04:18:36');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1075, 1009, 7, 'non ligula pellentesque ultrices phasellus id sapien in sapien iaculis congue', '2022-05-06 22:29:28');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1076, 1010, 30, 'semper est quam pharetra magna ac consequat metus sapien ut nunc vestibulum', '2022-01-03 12:54:59');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1077, 1014, 29, 'etiam justo etiam pretium iaculis justo in hac habitasse platea dictumst etiam faucibus cursus urna ut tellus nulla', '2022-04-09 23:57:36');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1078, 1000, 7, 'turpis enim blandit mi in porttitor pede justo eu massa donec dapibus duis at', '2022-06-08 22:15:46');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1079, 1009, 12, 'leo rhoncus sed vestibulum sit amet cursus id turpis integer', '2022-05-26 17:44:52');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1080, 1019, 7, 'cubilia curae duis faucibus accumsan odio curabitur convallis duis consequat dui nec nisi volutpat', '2022-05-31 17:57:59');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1081, 1019, 26, 'diam vitae quam suspendisse potenti nullam porttitor lacus at turpis donec posuere metus vitae ipsum aliquam non mauris morbi', '2022-05-03 16:19:29');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1082, 1010, 16, 'praesent blandit nam nulla integer pede justo lacinia eget tincidunt eget tempus vel pede morbi', '2022-05-10 22:00:27');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1083, 1013, 10, 'montes nascetur ridiculus mus vivamus vestibulum sagittis sapien cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus', '2022-07-10 21:26:41');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1084, 1006, 12, 'vitae mattis nibh ligula nec sem duis aliquam convallis nunc', '2022-02-21 08:57:41');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1085, 1007, 9, 'suspendisse ornare consequat lectus in est risus auctor sed tristique in', '2022-02-12 17:02:37');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1086, 1007, 6, 'est lacinia nisi venenatis tristique fusce congue diam id ornare imperdiet sapien urna pretium nisl ut volutpat sapien arcu', '2022-11-24 01:18:17');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1087, 1016, 2, 'tincidunt ante vel ipsum praesent blandit lacinia erat vestibulum sed magna at nunc commodo placerat praesent blandit', '2022-10-01 20:21:22');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1088, 1017, 5, 'felis donec semper sapien a libero nam dui proin leo odio porttitor id', '2022-06-30 07:05:34');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1089, 1005, 21, 'maecenas leo odio condimentum id luctus nec molestie sed justo pellentesque viverra pede ac diam cras pellentesque volutpat dui', '2022-10-03 09:38:03');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1090, 1015, 14, 'commodo vulputate justo in blandit ultrices enim lorem ipsum dolor sit amet consectetuer adipiscing elit proin interdum mauris', '2022-09-16 10:41:37');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1091, 1005, 8, 'penatibus et magnis dis parturient montes nascetur ridiculus mus etiam vel augue vestibulum rutrum rutrum neque aenean auctor gravida', '2022-12-15 23:11:56');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1092, 1017, 28, 'elementum ligula vehicula consequat morbi a ipsum integer a nibh in quis justo maecenas rhoncus aliquam lacus morbi quis tortor', '2022-10-11 17:24:33');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1093, 1011, 5, 'erat id mauris vulputate elementum nullam varius nulla facilisi cras non velit nec nisi vulputate nonummy', '2022-04-03 16:48:51');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1094, 1007, 2, 'neque sapien placerat ante nulla justo aliquam quis turpis eget elit sodales scelerisque mauris sit', '2022-05-31 06:07:18');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1095, 1007, 22, 'non sodales sed tincidunt eu felis fusce posuere felis sed lacus', '2022-08-15 15:44:27');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1096, 1013, 4, 'dui proin leo odio porttitor id consequat in consequat ut nulla sed accumsan felis ut', '2022-07-05 06:14:22');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1097, 1010, 29, 'in felis donec semper sapien a libero nam dui proin leo odio porttitor', '2022-10-20 08:30:15');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1098, 1016, 14, 'tempus vel pede morbi porttitor lorem id ligula suspendisse ornare consequat', '2022-01-19 06:03:36');
insert into comment_table (id, user_id, article_id, comment, datetime) values (1099, 1019, 23, 'odio odio elementum eu interdum eu tincidunt in leo maecenas pulvinar lobortis est phasellus', '2022-02-21 12:12:37');

insert into comment_pic_table (id, comment_id, json_path) values (1000, 1000, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1001, 1001, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1002, 1002, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1003, 1003, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1004, 1004, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1005, 1005, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1006, 1006, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1007, 1007, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1008, 1008, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1009, 1009, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1010, 1010, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1011, 1011, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1012, 1012, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1013, 1013, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1014, 1014, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1015, 1015, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1016, 1016, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1017, 1017, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1018, 1018, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1019, 1019, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1020, 1020, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1021, 1021, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1022, 1022, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1023, 1023, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1024, 1024, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1025, 1025, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1026, 1026, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1027, 1027, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1028, 1028, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1029, 1029, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1030, 1030, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1031, 1031, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1032, 1032, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1033, 1033, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1034, 1034, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1035, 1035, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1036, 1036, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1037, 1037, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1038, 1038, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1039, 1039, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1040, 1040, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1041, 1041, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1042, 1042, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1043, 1043, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1044, 1044, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1045, 1045, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1046, 1046, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1047, 1047, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1048, 1048, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1049, 1049, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1050, 1050, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1051, 1051, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1052, 1052, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1053, 1053, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1054, 1054, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1055, 1055, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1056, 1056, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1057, 1057, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1058, 1058, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1059, 1059, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1060, 1060, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1061, 1061, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1062, 1062, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1063, 1063, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1064, 1064, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1065, 1065, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1066, 1066, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1067, 1067, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1068, 1068, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1069, 1069, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1070, 1070, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1071, 1071, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1072, 1072, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1073, 1073, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1074, 1074, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1075, 1075, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1076, 1076, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1077, 1077, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1078, 1078, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1079, 1079, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1080, 1080, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1081, 1081, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1082, 1082, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1083, 1083, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1084, 1084, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1085, 1085, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1086, 1086, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1087, 1087, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1088, 1088, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1089, 1089, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1090, 1090, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1091, 1091, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1092, 1092, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1093, 1093, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1094, 1094, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1095, 1095, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1096, 1096, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1097, 1097, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1098, 1098, '/path/to/file');
insert into comment_pic_table (id, comment_id, json_path) values (1099, 1099, '/path/to/file');

insert into like_table (id, user_id, article_id) values (1, 1003, 23);
insert into like_table (id, user_id, article_id) values (2, 1000, 10);
insert into like_table (id, user_id, article_id) values (3, 1005, 16);
insert into like_table (id, user_id, article_id) values (4, 1006, 17);
insert into like_table (id, user_id, article_id) values (5, 1011, 27);
insert into like_table (id, user_id, article_id) values (6, 1003, 18);
insert into like_table (id, user_id, article_id) values (7, 1008, 11);
insert into like_table (id, user_id, article_id) values (8, 1016, 6);
insert into like_table (id, user_id, article_id) values (9, 1016, 22);
insert into like_table (id, user_id, article_id) values (10, 1001, 18);
insert into like_table (id, user_id, article_id) values (11, 1004, 3);
insert into like_table (id, user_id, article_id) values (12, 1015, 6);
insert into like_table (id, user_id, article_id) values (13, 1012, 27);
insert into like_table (id, user_id, article_id) values (14, 1005, 23);
insert into like_table (id, user_id, article_id) values (15, 1017, 7);
insert into like_table (id, user_id, article_id) values (16, 1003, 12);
insert into like_table (id, user_id, article_id) values (17, 1001, 12);
insert into like_table (id, user_id, article_id) values (18, 1015, 3);
insert into like_table (id, user_id, article_id) values (19, 1006, 10);
insert into like_table (id, user_id, article_id) values (20, 1014, 7);
insert into like_table (id, user_id, article_id) values (21, 1018, 17);
insert into like_table (id, user_id, article_id) values (22, 1015, 14);
insert into like_table (id, user_id, article_id) values (23, 1012, 5);
insert into like_table (id, user_id, article_id) values (24, 1012, 10);
insert into like_table (id, user_id, article_id) values (25, 1009, 21);
insert into like_table (id, user_id, article_id) values (26, 1010, 12);
insert into like_table (id, user_id, article_id) values (27, 1009, 10);
insert into like_table (id, user_id, article_id) values (28, 1014, 23);
insert into like_table (id, user_id, article_id) values (29, 1004, 17);
insert into like_table (id, user_id, article_id) values (30, 1004, 11);
insert into like_table (id, user_id, article_id) values (31, 1001, 18);
insert into like_table (id, user_id, article_id) values (32, 1011, 29);
insert into like_table (id, user_id, article_id) values (33, 1001, 26);
insert into like_table (id, user_id, article_id) values (34, 1001, 9);
insert into like_table (id, user_id, article_id) values (35, 1001, 21);
insert into like_table (id, user_id, article_id) values (36, 1016, 5);
insert into like_table (id, user_id, article_id) values (37, 1010, 11);
insert into like_table (id, user_id, article_id) values (38, 1016, 7);
insert into like_table (id, user_id, article_id) values (39, 1010, 4);
insert into like_table (id, user_id, article_id) values (40, 1003, 30);
insert into like_table (id, user_id, article_id) values (41, 1015, 5);
insert into like_table (id, user_id, article_id) values (42, 1012, 27);
insert into like_table (id, user_id, article_id) values (43, 1013, 14);
insert into like_table (id, user_id, article_id) values (44, 1007, 28);
insert into like_table (id, user_id, article_id) values (45, 1018, 13);
insert into like_table (id, user_id, article_id) values (46, 1011, 4);
insert into like_table (id, user_id, article_id) values (47, 1015, 16);
insert into like_table (id, user_id, article_id) values (48, 1017, 16);
insert into like_table (id, user_id, article_id) values (49, 1017, 4);
insert into like_table (id, user_id, article_id) values (50, 1018, 9);
insert into like_table (id, user_id, article_id) values (51, 1011, 14);
insert into like_table (id, user_id, article_id) values (52, 1010, 9);
insert into like_table (id, user_id, article_id) values (53, 1018, 18);
insert into like_table (id, user_id, article_id) values (54, 1011, 24);
insert into like_table (id, user_id, article_id) values (55, 1006, 22);
insert into like_table (id, user_id, article_id) values (56, 1003, 28);
insert into like_table (id, user_id, article_id) values (57, 1018, 18);
insert into like_table (id, user_id, article_id) values (58, 1001, 19);
insert into like_table (id, user_id, article_id) values (59, 1016, 2);
insert into like_table (id, user_id, article_id) values (60, 1008, 27);
insert into like_table (id, user_id, article_id) values (61, 1001, 25);
insert into like_table (id, user_id, article_id) values (62, 1013, 10);
insert into like_table (id, user_id, article_id) values (63, 1011, 11);
insert into like_table (id, user_id, article_id) values (64, 1009, 8);
insert into like_table (id, user_id, article_id) values (65, 1008, 9);
insert into like_table (id, user_id, article_id) values (66, 1018, 8);
insert into like_table (id, user_id, article_id) values (67, 1013, 9);
insert into like_table (id, user_id, article_id) values (68, 1007, 13);
insert into like_table (id, user_id, article_id) values (69, 1012, 11);
insert into like_table (id, user_id, article_id) values (70, 1012, 6);
insert into like_table (id, user_id, article_id) values (71, 1007, 15);
insert into like_table (id, user_id, article_id) values (72, 1012, 21);
insert into like_table (id, user_id, article_id) values (73, 1014, 17);
insert into like_table (id, user_id, article_id) values (74, 1018, 13);
insert into like_table (id, user_id, article_id) values (75, 1005, 30);
insert into like_table (id, user_id, article_id) values (76, 1000, 8);
insert into like_table (id, user_id, article_id) values (77, 1009, 27);
insert into like_table (id, user_id, article_id) values (78, 1013, 12);
insert into like_table (id, user_id, article_id) values (79, 1009, 7);
insert into like_table (id, user_id, article_id) values (80, 1011, 15);
insert into like_table (id, user_id, article_id) values (81, 1006, 18);
insert into like_table (id, user_id, article_id) values (82, 1013, 1);
insert into like_table (id, user_id, article_id) values (83, 1010, 5);
insert into like_table (id, user_id, article_id) values (84, 1003, 9);
insert into like_table (id, user_id, article_id) values (85, 1000, 2);
insert into like_table (id, user_id, article_id) values (86, 1017, 10);
insert into like_table (id, user_id, article_id) values (87, 1005, 8);
insert into like_table (id, user_id, article_id) values (88, 1006, 15);
insert into like_table (id, user_id, article_id) values (89, 1002, 24);
insert into like_table (id, user_id, article_id) values (90, 1004, 11);
insert into like_table (id, user_id, article_id) values (91, 1002, 18);
insert into like_table (id, user_id, article_id) values (92, 1019, 11);
insert into like_table (id, user_id, article_id) values (93, 1001, 7);
insert into like_table (id, user_id, article_id) values (94, 1007, 25);
insert into like_table (id, user_id, article_id) values (95, 1013, 21);
insert into like_table (id, user_id, article_id) values (96, 1005, 1);
insert into like_table (id, user_id, article_id) values (97, 1018, 13);
insert into like_table (id, user_id, article_id) values (98, 1004, 24);
insert into like_table (id, user_id, article_id) values (99, 1001, 6);
insert into like_table (id, user_id, article_id) values (100, 1003, 18);

insert into store_table (id, user_id, article_id) values (1, 1016, 27);
insert into store_table (id, user_id, article_id) values (2, 1003, 24);
insert into store_table (id, user_id, article_id) values (3, 1013, 10);
insert into store_table (id, user_id, article_id) values (4, 1001, 24);
insert into store_table (id, user_id, article_id) values (5, 1014, 16);
insert into store_table (id, user_id, article_id) values (6, 1014, 24);
insert into store_table (id, user_id, article_id) values (7, 1012, 23);
insert into store_table (id, user_id, article_id) values (8, 1008, 3);
insert into store_table (id, user_id, article_id) values (9, 1012, 27);
insert into store_table (id, user_id, article_id) values (10, 1012, 16);
insert into store_table (id, user_id, article_id) values (11, 1017, 11);
insert into store_table (id, user_id, article_id) values (12, 1019, 5);
insert into store_table (id, user_id, article_id) values (13, 1007, 11);
insert into store_table (id, user_id, article_id) values (14, 1014, 24);
insert into store_table (id, user_id, article_id) values (15, 1007, 27);
insert into store_table (id, user_id, article_id) values (16, 1009, 18);
insert into store_table (id, user_id, article_id) values (17, 1010, 25);
insert into store_table (id, user_id, article_id) values (18, 1014, 15);
insert into store_table (id, user_id, article_id) values (19, 1019, 30);
insert into store_table (id, user_id, article_id) values (20, 1016, 17);
insert into store_table (id, user_id, article_id) values (21, 1019, 23);
insert into store_table (id, user_id, article_id) values (22, 1018, 23);
insert into store_table (id, user_id, article_id) values (23, 1005, 24);
insert into store_table (id, user_id, article_id) values (24, 1007, 21);
insert into store_table (id, user_id, article_id) values (25, 1008, 28);
insert into store_table (id, user_id, article_id) values (26, 1009, 20);
insert into store_table (id, user_id, article_id) values (27, 1012, 13);
insert into store_table (id, user_id, article_id) values (28, 1006, 20);
insert into store_table (id, user_id, article_id) values (29, 1018, 20);
insert into store_table (id, user_id, article_id) values (30, 1019, 29);
insert into store_table (id, user_id, article_id) values (31, 1013, 16);
insert into store_table (id, user_id, article_id) values (32, 1013, 16);
insert into store_table (id, user_id, article_id) values (33, 1005, 13);
insert into store_table (id, user_id, article_id) values (34, 1016, 13);
insert into store_table (id, user_id, article_id) values (35, 1012, 11);
insert into store_table (id, user_id, article_id) values (36, 1006, 30);
insert into store_table (id, user_id, article_id) values (37, 1018, 20);
insert into store_table (id, user_id, article_id) values (38, 1006, 23);
insert into store_table (id, user_id, article_id) values (39, 1016, 17);
insert into store_table (id, user_id, article_id) values (40, 1016, 4);
insert into store_table (id, user_id, article_id) values (41, 1009, 13);
insert into store_table (id, user_id, article_id) values (42, 1000, 10);
insert into store_table (id, user_id, article_id) values (43, 1019, 18);
insert into store_table (id, user_id, article_id) values (44, 1007, 26);
insert into store_table (id, user_id, article_id) values (45, 1019, 5);
insert into store_table (id, user_id, article_id) values (46, 1017, 7);
insert into store_table (id, user_id, article_id) values (47, 1005, 25);
insert into store_table (id, user_id, article_id) values (48, 1008, 29);
insert into store_table (id, user_id, article_id) values (49, 1008, 30);
insert into store_table (id, user_id, article_id) values (50, 1013, 21);
insert into store_table (id, user_id, article_id) values (51, 1002, 3);
insert into store_table (id, user_id, article_id) values (52, 1002, 2);
insert into store_table (id, user_id, article_id) values (53, 1010, 25);
insert into store_table (id, user_id, article_id) values (54, 1014, 16);
insert into store_table (id, user_id, article_id) values (55, 1010, 28);
insert into store_table (id, user_id, article_id) values (56, 1012, 26);
insert into store_table (id, user_id, article_id) values (57, 1003, 24);
insert into store_table (id, user_id, article_id) values (58, 1019, 2);
insert into store_table (id, user_id, article_id) values (59, 1014, 5);
insert into store_table (id, user_id, article_id) values (60, 1014, 22);
insert into store_table (id, user_id, article_id) values (61, 1003, 18);
insert into store_table (id, user_id, article_id) values (62, 1007, 26);
insert into store_table (id, user_id, article_id) values (63, 1007, 2);
insert into store_table (id, user_id, article_id) values (64, 1019, 6);
insert into store_table (id, user_id, article_id) values (65, 1011, 11);
insert into store_table (id, user_id, article_id) values (66, 1002, 25);
insert into store_table (id, user_id, article_id) values (67, 1010, 8);
insert into store_table (id, user_id, article_id) values (68, 1019, 16);
insert into store_table (id, user_id, article_id) values (69, 1002, 25);
insert into store_table (id, user_id, article_id) values (70, 1009, 12);
insert into store_table (id, user_id, article_id) values (71, 1011, 4);
insert into store_table (id, user_id, article_id) values (72, 1000, 28);
insert into store_table (id, user_id, article_id) values (73, 1015, 8);
insert into store_table (id, user_id, article_id) values (74, 1015, 5);
insert into store_table (id, user_id, article_id) values (75, 1013, 2);
insert into store_table (id, user_id, article_id) values (76, 1011, 19);
insert into store_table (id, user_id, article_id) values (77, 1004, 12);
insert into store_table (id, user_id, article_id) values (78, 1008, 28);
insert into store_table (id, user_id, article_id) values (79, 1015, 7);
insert into store_table (id, user_id, article_id) values (80, 1007, 24);
insert into store_table (id, user_id, article_id) values (81, 1004, 3);
insert into store_table (id, user_id, article_id) values (82, 1016, 21);
insert into store_table (id, user_id, article_id) values (83, 1005, 13);
insert into store_table (id, user_id, article_id) values (84, 1005, 5);
insert into store_table (id, user_id, article_id) values (85, 1017, 10);
insert into store_table (id, user_id, article_id) values (86, 1019, 5);
insert into store_table (id, user_id, article_id) values (87, 1012, 10);
insert into store_table (id, user_id, article_id) values (88, 1002, 15);
insert into store_table (id, user_id, article_id) values (89, 1001, 8);
insert into store_table (id, user_id, article_id) values (90, 1006, 5);
insert into store_table (id, user_id, article_id) values (91, 1016, 18);
insert into store_table (id, user_id, article_id) values (92, 1011, 23);
insert into store_table (id, user_id, article_id) values (93, 1001, 9);
insert into store_table (id, user_id, article_id) values (94, 1006, 22);
insert into store_table (id, user_id, article_id) values (95, 1007, 26);
insert into store_table (id, user_id, article_id) values (96, 1011, 25);
insert into store_table (id, user_id, article_id) values (97, 1015, 14);
insert into store_table (id, user_id, article_id) values (98, 1017, 10);
insert into store_table (id, user_id, article_id) values (99, 1002, 11);
insert into store_table (id, user_id, article_id) values (100, 1002, 4);

insert into follow_table (id, user_id, follow_user_id) values (1, 1001, 1013);
insert into follow_table (id, user_id, follow_user_id) values (2, 1012, 1003);
insert into follow_table (id, user_id, follow_user_id) values (3, 1012, 1018);
insert into follow_table (id, user_id, follow_user_id) values (4, 1005, 1018);
insert into follow_table (id, user_id, follow_user_id) values (5, 1000, 1001);
insert into follow_table (id, user_id, follow_user_id) values (6, 1013, 1002);
insert into follow_table (id, user_id, follow_user_id) values (7, 1017, 1011);
insert into follow_table (id, user_id, follow_user_id) values (8, 1004, 1001);
insert into follow_table (id, user_id, follow_user_id) values (9, 1006, 1006);
insert into follow_table (id, user_id, follow_user_id) values (10, 1008, 1006);
insert into follow_table (id, user_id, follow_user_id) values (11, 1012, 1006);
insert into follow_table (id, user_id, follow_user_id) values (12, 1007, 1017);
insert into follow_table (id, user_id, follow_user_id) values (13, 1002, 1000);
insert into follow_table (id, user_id, follow_user_id) values (14, 1004, 1004);
insert into follow_table (id, user_id, follow_user_id) values (15, 1001, 1019);
insert into follow_table (id, user_id, follow_user_id) values (16, 1019, 1000);
insert into follow_table (id, user_id, follow_user_id) values (17, 1001, 1014);
insert into follow_table (id, user_id, follow_user_id) values (18, 1013, 1002);
insert into follow_table (id, user_id, follow_user_id) values (19, 1000, 1017);
insert into follow_table (id, user_id, follow_user_id) values (20, 1018, 1014);
insert into follow_table (id, user_id, follow_user_id) values (21, 1008, 1009);
insert into follow_table (id, user_id, follow_user_id) values (22, 1001, 1014);
insert into follow_table (id, user_id, follow_user_id) values (23, 1013, 1010);
insert into follow_table (id, user_id, follow_user_id) values (24, 1004, 1012);
insert into follow_table (id, user_id, follow_user_id) values (25, 1005, 1005);
insert into follow_table (id, user_id, follow_user_id) values (26, 1003, 1001);
insert into follow_table (id, user_id, follow_user_id) values (27, 1018, 1019);
insert into follow_table (id, user_id, follow_user_id) values (28, 1018, 1007);
insert into follow_table (id, user_id, follow_user_id) values (29, 1013, 1002);
insert into follow_table (id, user_id, follow_user_id) values (30, 1009, 1011);
insert into follow_table (id, user_id, follow_user_id) values (31, 1015, 1012);
insert into follow_table (id, user_id, follow_user_id) values (32, 1012, 1010);
insert into follow_table (id, user_id, follow_user_id) values (33, 1018, 1003);
insert into follow_table (id, user_id, follow_user_id) values (34, 1007, 1000);
insert into follow_table (id, user_id, follow_user_id) values (35, 1008, 1015);
insert into follow_table (id, user_id, follow_user_id) values (36, 1001, 1004);
insert into follow_table (id, user_id, follow_user_id) values (37, 1012, 1002);
insert into follow_table (id, user_id, follow_user_id) values (38, 1001, 1017);
insert into follow_table (id, user_id, follow_user_id) values (39, 1005, 1003);
insert into follow_table (id, user_id, follow_user_id) values (40, 1018, 1008);
insert into follow_table (id, user_id, follow_user_id) values (41, 1013, 1017);
insert into follow_table (id, user_id, follow_user_id) values (42, 1013, 1006);
insert into follow_table (id, user_id, follow_user_id) values (43, 1019, 1011);
insert into follow_table (id, user_id, follow_user_id) values (44, 1010, 1010);
insert into follow_table (id, user_id, follow_user_id) values (45, 1000, 1011);
insert into follow_table (id, user_id, follow_user_id) values (46, 1009, 1010);
insert into follow_table (id, user_id, follow_user_id) values (47, 1008, 1003);
insert into follow_table (id, user_id, follow_user_id) values (48, 1015, 1010);
insert into follow_table (id, user_id, follow_user_id) values (49, 1003, 1005);
insert into follow_table (id, user_id, follow_user_id) values (50, 1012, 1003);
insert into follow_table (id, user_id, follow_user_id) values (51, 1014, 1007);
insert into follow_table (id, user_id, follow_user_id) values (52, 1010, 1006);
insert into follow_table (id, user_id, follow_user_id) values (53, 1008, 1014);
insert into follow_table (id, user_id, follow_user_id) values (54, 1004, 1015);
insert into follow_table (id, user_id, follow_user_id) values (55, 1018, 1018);
insert into follow_table (id, user_id, follow_user_id) values (56, 1002, 1014);
insert into follow_table (id, user_id, follow_user_id) values (57, 1007, 1015);
insert into follow_table (id, user_id, follow_user_id) values (58, 1010, 1003);
insert into follow_table (id, user_id, follow_user_id) values (59, 1012, 1006);
insert into follow_table (id, user_id, follow_user_id) values (60, 1003, 1003);
insert into follow_table (id, user_id, follow_user_id) values (61, 1002, 1016);
insert into follow_table (id, user_id, follow_user_id) values (62, 1014, 1009);
insert into follow_table (id, user_id, follow_user_id) values (63, 1000, 1013);
insert into follow_table (id, user_id, follow_user_id) values (64, 1016, 1017);
insert into follow_table (id, user_id, follow_user_id) values (65, 1018, 1008);
insert into follow_table (id, user_id, follow_user_id) values (66, 1014, 1018);
insert into follow_table (id, user_id, follow_user_id) values (67, 1018, 1005);
insert into follow_table (id, user_id, follow_user_id) values (68, 1010, 1006);
insert into follow_table (id, user_id, follow_user_id) values (69, 1013, 1001);
insert into follow_table (id, user_id, follow_user_id) values (70, 1001, 1004);
insert into follow_table (id, user_id, follow_user_id) values (71, 1012, 1018);
insert into follow_table (id, user_id, follow_user_id) values (72, 1015, 1009);
insert into follow_table (id, user_id, follow_user_id) values (73, 1010, 1000);
insert into follow_table (id, user_id, follow_user_id) values (74, 1013, 1011);
insert into follow_table (id, user_id, follow_user_id) values (75, 1006, 1013);
insert into follow_table (id, user_id, follow_user_id) values (76, 1001, 1000);
insert into follow_table (id, user_id, follow_user_id) values (77, 1007, 1011);
insert into follow_table (id, user_id, follow_user_id) values (78, 1017, 1006);
insert into follow_table (id, user_id, follow_user_id) values (79, 1006, 1003);
insert into follow_table (id, user_id, follow_user_id) values (80, 1004, 1015);
insert into follow_table (id, user_id, follow_user_id) values (81, 1009, 1012);
insert into follow_table (id, user_id, follow_user_id) values (82, 1008, 1014);
insert into follow_table (id, user_id, follow_user_id) values (83, 1006, 1004);
insert into follow_table (id, user_id, follow_user_id) values (84, 1013, 1002);
insert into follow_table (id, user_id, follow_user_id) values (85, 1009, 1017);
insert into follow_table (id, user_id, follow_user_id) values (86, 1004, 1017);
insert into follow_table (id, user_id, follow_user_id) values (87, 1017, 1012);
insert into follow_table (id, user_id, follow_user_id) values (88, 1001, 1006);
insert into follow_table (id, user_id, follow_user_id) values (89, 1010, 1007);
insert into follow_table (id, user_id, follow_user_id) values (90, 1002, 1000);
insert into follow_table (id, user_id, follow_user_id) values (91, 1006, 1010);
insert into follow_table (id, user_id, follow_user_id) values (92, 1010, 1003);
insert into follow_table (id, user_id, follow_user_id) values (93, 1018, 1011);
insert into follow_table (id, user_id, follow_user_id) values (94, 1014, 1006);
insert into follow_table (id, user_id, follow_user_id) values (95, 1018, 1014);
insert into follow_table (id, user_id, follow_user_id) values (96, 1017, 1012);
insert into follow_table (id, user_id, follow_user_id) values (97, 1000, 1001);
insert into follow_table (id, user_id, follow_user_id) values (98, 1011, 1019);
insert into follow_table (id, user_id, follow_user_id) values (99, 1014, 1008);
insert into follow_table (id, user_id, follow_user_id) values (100, 1006, 1017);

insert into login_table (id, user_id, datetime) values (1000, 1013, '2022-09-10 08:46:07');
insert into login_table (id, user_id, datetime) values (1001, 1016, '2022-10-03 15:12:34');
insert into login_table (id, user_id, datetime) values (1002, 1010, '2022-11-30 17:00:47');
insert into login_table (id, user_id, datetime) values (1003, 1013, '2022-09-02 23:05:49');
insert into login_table (id, user_id, datetime) values (1004, 1000, '2022-01-28 03:03:40');
insert into login_table (id, user_id, datetime) values (1005, 1018, '2022-03-17 11:47:44');
insert into login_table (id, user_id, datetime) values (1006, 1018, '2022-03-19 07:06:44');
insert into login_table (id, user_id, datetime) values (1007, 1008, '2022-11-29 16:01:45');
insert into login_table (id, user_id, datetime) values (1008, 1002, '2022-10-06 11:54:29');
insert into login_table (id, user_id, datetime) values (1009, 1000, '2022-07-28 13:34:44');
insert into login_table (id, user_id, datetime) values (1010, 1019, '2022-02-04 09:02:36');
insert into login_table (id, user_id, datetime) values (1011, 1018, '2022-11-19 07:12:43');
insert into login_table (id, user_id, datetime) values (1012, 1015, '2022-11-10 17:28:57');
insert into login_table (id, user_id, datetime) values (1013, 1008, '2022-05-22 15:01:52');
insert into login_table (id, user_id, datetime) values (1014, 1000, '2022-01-24 15:32:23');
insert into login_table (id, user_id, datetime) values (1015, 1012, '2022-02-27 13:00:28');
insert into login_table (id, user_id, datetime) values (1016, 1000, '2022-12-09 18:33:44');
insert into login_table (id, user_id, datetime) values (1017, 1016, '2022-10-14 16:02:35');
insert into login_table (id, user_id, datetime) values (1018, 1002, '2022-01-29 14:57:10');
insert into login_table (id, user_id, datetime) values (1019, 1005, '2022-06-19 17:20:46');
insert into login_table (id, user_id, datetime) values (1020, 1013, '2022-10-17 09:56:47');
insert into login_table (id, user_id, datetime) values (1021, 1015, '2022-05-07 21:51:52');
insert into login_table (id, user_id, datetime) values (1022, 1010, '2022-10-08 22:41:40');
insert into login_table (id, user_id, datetime) values (1023, 1018, '2022-11-13 18:58:51');
insert into login_table (id, user_id, datetime) values (1024, 1018, '2022-10-25 06:41:58');
insert into login_table (id, user_id, datetime) values (1025, 1012, '2022-03-22 15:12:43');
insert into login_table (id, user_id, datetime) values (1026, 1002, '2022-11-04 14:05:16');
insert into login_table (id, user_id, datetime) values (1027, 1002, '2022-03-24 12:31:00');
insert into login_table (id, user_id, datetime) values (1028, 1013, '2022-02-19 11:37:08');
insert into login_table (id, user_id, datetime) values (1029, 1003, '2022-05-09 05:25:50');
insert into login_table (id, user_id, datetime) values (1030, 1004, '2022-03-02 06:55:50');
insert into login_table (id, user_id, datetime) values (1031, 1016, '2022-01-19 21:28:04');
insert into login_table (id, user_id, datetime) values (1032, 1016, '2022-06-20 03:05:19');
insert into login_table (id, user_id, datetime) values (1033, 1000, '2022-10-15 21:52:59');
insert into login_table (id, user_id, datetime) values (1034, 1001, '2022-06-01 08:25:09');
insert into login_table (id, user_id, datetime) values (1035, 1013, '2022-08-25 15:17:04');
insert into login_table (id, user_id, datetime) values (1036, 1012, '2022-11-21 04:30:21');
insert into login_table (id, user_id, datetime) values (1037, 1018, '2022-02-27 14:40:38');
insert into login_table (id, user_id, datetime) values (1038, 1004, '2022-11-24 16:55:17');
insert into login_table (id, user_id, datetime) values (1039, 1017, '2022-09-21 09:40:16');
insert into login_table (id, user_id, datetime) values (1040, 1012, '2022-01-20 05:42:27');
insert into login_table (id, user_id, datetime) values (1041, 1012, '2022-05-05 16:19:16');
insert into login_table (id, user_id, datetime) values (1042, 1000, '2022-04-02 11:36:46');
insert into login_table (id, user_id, datetime) values (1043, 1009, '2022-01-03 18:44:25');
insert into login_table (id, user_id, datetime) values (1044, 1004, '2022-10-27 01:10:21');
insert into login_table (id, user_id, datetime) values (1045, 1005, '2022-05-05 12:37:57');
insert into login_table (id, user_id, datetime) values (1046, 1007, '2022-10-05 10:48:22');
insert into login_table (id, user_id, datetime) values (1047, 1001, '2022-07-14 08:18:36');
insert into login_table (id, user_id, datetime) values (1048, 1005, '2022-11-19 22:18:27');
insert into login_table (id, user_id, datetime) values (1049, 1006, '2022-06-11 23:56:51');
insert into login_table (id, user_id, datetime) values (1050, 1014, '2022-11-05 14:42:19');
insert into login_table (id, user_id, datetime) values (1051, 1018, '2022-06-26 03:02:06');
insert into login_table (id, user_id, datetime) values (1052, 1013, '2022-09-11 12:39:33');
insert into login_table (id, user_id, datetime) values (1053, 1006, '2022-06-08 01:10:17');
insert into login_table (id, user_id, datetime) values (1054, 1010, '2022-07-23 05:06:48');
insert into login_table (id, user_id, datetime) values (1055, 1008, '2022-07-08 21:34:26');
insert into login_table (id, user_id, datetime) values (1056, 1019, '2022-05-19 12:33:02');
insert into login_table (id, user_id, datetime) values (1057, 1003, '2022-01-18 11:57:46');
insert into login_table (id, user_id, datetime) values (1058, 1002, '2022-10-13 05:39:34');
insert into login_table (id, user_id, datetime) values (1059, 1001, '2022-07-23 22:07:41');
insert into login_table (id, user_id, datetime) values (1060, 1017, '2022-12-09 20:07:46');
insert into login_table (id, user_id, datetime) values (1061, 1012, '2022-05-21 20:33:03');
insert into login_table (id, user_id, datetime) values (1062, 1012, '2022-08-14 01:07:53');
insert into login_table (id, user_id, datetime) values (1063, 1005, '2022-01-19 05:28:53');
insert into login_table (id, user_id, datetime) values (1064, 1004, '2022-09-05 14:31:56');
insert into login_table (id, user_id, datetime) values (1065, 1019, '2021-12-29 05:23:45');
insert into login_table (id, user_id, datetime) values (1066, 1007, '2022-01-05 03:34:47');
insert into login_table (id, user_id, datetime) values (1067, 1007, '2022-07-26 01:01:02');
insert into login_table (id, user_id, datetime) values (1068, 1012, '2022-10-27 11:45:40');
insert into login_table (id, user_id, datetime) values (1069, 1015, '2022-08-25 15:33:09');
insert into login_table (id, user_id, datetime) values (1070, 1019, '2022-07-20 03:37:38');
insert into login_table (id, user_id, datetime) values (1071, 1009, '2022-10-03 04:03:44');
insert into login_table (id, user_id, datetime) values (1072, 1017, '2022-01-01 02:14:15');
insert into login_table (id, user_id, datetime) values (1073, 1016, '2022-10-04 14:46:49');
insert into login_table (id, user_id, datetime) values (1074, 1001, '2022-02-25 06:07:22');
insert into login_table (id, user_id, datetime) values (1075, 1002, '2022-05-11 16:44:12');
insert into login_table (id, user_id, datetime) values (1076, 1008, '2022-07-17 06:41:39');
insert into login_table (id, user_id, datetime) values (1077, 1006, '2022-05-08 07:16:28');
insert into login_table (id, user_id, datetime) values (1078, 1013, '2022-05-28 19:22:09');
insert into login_table (id, user_id, datetime) values (1079, 1007, '2022-03-12 21:13:21');
insert into login_table (id, user_id, datetime) values (1080, 1001, '2022-05-08 03:10:03');
insert into login_table (id, user_id, datetime) values (1081, 1015, '2022-08-05 06:22:14');
insert into login_table (id, user_id, datetime) values (1082, 1005, '2022-06-21 01:43:45');
insert into login_table (id, user_id, datetime) values (1083, 1004, '2022-10-13 04:08:53');
insert into login_table (id, user_id, datetime) values (1084, 1000, '2022-05-14 04:17:40');
insert into login_table (id, user_id, datetime) values (1085, 1011, '2022-01-01 03:19:41');
insert into login_table (id, user_id, datetime) values (1086, 1000, '2022-10-05 19:57:17');
insert into login_table (id, user_id, datetime) values (1087, 1001, '2022-05-10 10:40:37');
insert into login_table (id, user_id, datetime) values (1088, 1009, '2021-12-25 01:32:58');
insert into login_table (id, user_id, datetime) values (1089, 1006, '2022-04-27 05:37:37');
insert into login_table (id, user_id, datetime) values (1090, 1004, '2022-10-17 21:00:20');
insert into login_table (id, user_id, datetime) values (1091, 1002, '2022-03-10 06:05:00');
insert into login_table (id, user_id, datetime) values (1092, 1003, '2022-08-16 04:53:22');
insert into login_table (id, user_id, datetime) values (1093, 1007, '2022-06-03 06:41:52');
insert into login_table (id, user_id, datetime) values (1094, 1005, '2022-04-03 06:02:11');
insert into login_table (id, user_id, datetime) values (1095, 1015, '2022-06-18 03:52:05');
insert into login_table (id, user_id, datetime) values (1096, 1014, '2022-06-04 00:48:50');
insert into login_table (id, user_id, datetime) values (1097, 1008, '2022-11-30 21:48:28');
insert into login_table (id, user_id, datetime) values (1098, 1018, '2022-11-27 11:15:05');
insert into login_table (id, user_id, datetime) values (1099, 1008, '2022-04-25 15:36:20');
