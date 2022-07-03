<?php
$link=mysqli_connect("localhost", "root", "root", "test");
mysqli_query($link, "set character_set_client='utf8'");
mysqli_query($link, "set character_set_results='utf8'");
mysqli_query($link, "set collation_connection='utf8_general_ci'");

mysqli_query($link, "CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `variant_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

mysqli_query($link, "CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('single','multi') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

mysqli_query($link, "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `pass_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;");

mysqli_query($link, "INSERT INTO `users` (`id`, `login`, `pass_hash`) VALUES
(1, 'test', '$2y$05$ituXU1nG51I9/F7EIlTExOsOejEOFtSMm1REJWAvWM6W8BsPwC4Ze');");

mysqli_query($link, "CREATE TABLE IF NOT EXISTS `variants` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `question_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
?>