<?php
include_once("./database.php");

$connection = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql = "DROP TABLE IF EXISTS comments";
$connection->exec($sql);

$sql = "DROP TABLE IF EXISTS likes";
$connection->exec($sql);

$sql = "DROP TABLE IF EXISTS pictures";
$connection->exec($sql);

$sql = "DROP TABLE IF EXISTS users";
$connection->exec($sql);

$sql = "CREATE TABLE `comments` (
  id int NOT NULL AUTO_INCREMENT,
  `path_picture` text NOT NULL,
  `username` text NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (id)
)";
$connection->exec($sql);

$sql = "CREATE TABLE `likes` (
  id int NOT NULL AUTO_INCREMENT,
  `path_picture` text NOT NULL,
  `username` text NOT NULL,
  PRIMARY KEY (id)
)";
$connection->exec($sql);

$sql = "CREATE TABLE `pictures` (
  id int NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `path` text NOT NULL,
  `positions` int(11) NOT NULL,
  PRIMARY KEY (id)
) ";
$connection->exec($sql);

$sql = "CREATE TABLE `users` (
  id int NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `mail` text NOT NULL,
  `confirmed` bit(1) NOT NULL,
  `password` text NOT NULL,
  `random_key` text NOT NULL,
  PRIMARY KEY (id)
)";
$connection->exec($sql);

?>