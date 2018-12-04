<?php
include_once("../models/init.php");
session_start();
$bdd = init();
$path =  $_POST["path"];

$array = explode('/', $path);
$path = $array[count($array) - 2] . '/' . $array[count($array) - 1];

$request = $bdd->prepare("SELECT comment, username from comments WHERE path_picture = :path");
$request->execute(array(":path" => $path));
$comments = array();
while ($data = $request->fetch()) {
    array_push($comments, $data["username"]);
    array_push($comments, $data["comment"]);
}
echo json_encode($comments);
