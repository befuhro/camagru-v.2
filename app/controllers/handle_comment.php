<?php
include_once("../models/init.php");
session_start();

$path =  $_POST["path"];
$comment = $_POST["comment"];
$username =  $_SESSION["username"];
$bdd = init();

$array = explode('/', $path);
$path = $array[count($array) - 2] . '/' . $array[count($array) - 1];

$request = $bdd->prepare("INSERT INTO comments(path_picture, username, comment) VALUES(:path, :username, :comment)");
$request->execute(array(":path" => $path, ":username" => $username, ":comment" => $comment));
$request->closeCursor();

$request = $bdd->prepare("SELECT username FROM pictures WHERE path = :path");
$request->execute(array(":path" => $path));
$data = $request->fetch();
$request->closeCursor();

if (isset($data["username"]))
{
    $dest_name = $data["username"];

    $request = $bdd->prepare("SELECT mail FROM users WHERE username = :username");
    $request->execute(array(":username" => $dest_name));
    $data = $request->fetch();
    $request->closeCursor();

    $subject = "Nouveau commentaire sur votre photo.";
    $message = $username . " a commente votre photo";
    mail($data["mail"], $subject, $message);
}
echo $_SESSION["username"];
?>