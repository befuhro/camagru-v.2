<?php
include_once("./php_functions/init.php");
include_once("./php_functions/pictureController.php");
session_start();
$bdd = init();
$path = $_POST["str"];

$array = explode('/', $path);
$path = $array[count($array) - 2] . '/' . $array[count($array) - 1];

if (is_liked($_SESSION["username"] ,$path) == true)
{
    $request = $bdd->prepare("DELETE FROM likes WHERE username = :username AND path_picture = :path");
    $request->execute(array(":username" => $_SESSION["username"], ":path" => $path));
    $request->closeCursor();
    $ret = "disliked";
}
else
{
    $request = $bdd->prepare("INSERT INTO likes(path_picture, username) VALUES(:path, :username)");
    $request->execute(array(":path" => $path, ":username" => $_SESSION["username"]));
    $request->closeCursor();
    $ret = "liked";
}
echo $ret;
?>