<?php
session_start();
include_once("../controllers/init.php");
$bdd = init();
$img = $_POST["img"];
$icon = $_POST["icon"];
$img = str_replace("data:image/png;base64,", '', $img);
$icon = str_replace("data:image/png;base64,", '', $icon);
$img = str_replace(' ', '+', $img);
$icon = str_replace(' ', '+', $icon);
$imgdata = base64_decode($img);
$icondata = base64_decode($icon);
$position = 0;
$src = imagecreatefromstring($imgdata);
$dst = imagecreatefromstring($icondata);

$request = $bdd->prepare("SELECT positions FROM pictures WHERE username = :username");
$request->execute(array(":username" => $_SESSION["username"]));
while ($data = $request->fetch()) {
    $position = $data["positions"];
}
$request->closeCursor();
$position++;
$path = "../public/" . $_SESSION["username"] . (string)$position . ".jpeg";
$request = $bdd->prepare("INSERT INTO pictures(username, path, positions) VALUES(:username, :path, :positions)");
$request->execute(array(":username" => $_SESSION["username"], ":path" => $path, ":positions" => $position));
$request->closeCursor();

imagecopy($src, $dst, 0, 0, 0, 0, 640, 480);
header('Content-type: image/jpeg');
imagejpeg($src, $path);

echo $_SESSION["username"];
?>