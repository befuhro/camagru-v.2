<?php

function paginate()
{
    $pageNumber = $_GET["page"];
    $dataBase = new Database();
    $picture = new Picture($dataBase);
    $page = "";
    if (!empty($_SESSION["username"])) {
        $like = new Like($dataBase);
        $likes = $like->getLikesPath($_SESSION["id"]);
    }
    $pictures = $picture->fetchPictures($pageNumber * 4, 4);
    foreach ($pictures as $item) {
        $page .= "<div class=\"pagine\">";
        $page .= "<h2>" . $item["id"] . "</h2>";
        $page .= "<h2>" . $item["username"] . "</h2>";
        $page .= "<img src=\"" . $item["path"] . "\" id=\"" . $item["id"] . "\">";
        if (!empty($_SESSION["username"])) {
            $page .= likeButton($likes, $item["id"]);
        }
        $page .= paginateComments($item["id"]);
        $page .= getDeleteButton($item["username"]);
        $page .= "</div>";
    }
    echo $page;
}

function getDeleteButton($ownerName) {
    if (isset($_SESSION["username"]) && $_SESSION["username"] === $ownerName) {
        return ("<br><br><button onclick=\"delete_picture(this)\">delete picture</button>");
    }
}

function addPicture()
{
    if (!empty($_SESSION["id"])) {
        $dataBase = new Database();
        $picture = new Picture($dataBase);
        $img = $_POST["img"];
        $icon = $_POST["icon"];
        $img = str_replace("data:image/png;base64,", '', $img);
        $icon = str_replace("data:image/png;base64,", '', $icon);
        $img = str_replace(' ', '+', $img);
        $icon = str_replace(' ', '+', $icon);
        $imgdata = base64_decode($img);
        $icondata = base64_decode($icon);
        $src = imagecreatefromstring($imgdata);
        $dst = imagecreatefromstring($icondata);
        $path = "./public/picture" . $picture->addPicture($_SESSION["id"]) . ".jpeg";
        imagecopy($src, $dst, 0, 0, 0, 0, 640, 480);
        header('Content-type: image/jpeg');
        imagejpeg($src, $path);
        echo "Your picture has been uploaded.";
    } else {
        echo "Your are not authentificated.";
    }
}

function deletePicture()
{
    $dataBase = new Database();
    $picture = new Picture($dataBase);
    $pictureID = $_POST["pictureID"];
    $data = $picture->getOwnerAndPath($pictureID);
    $pictureOwner = $data["owner"];
    if ($pictureOwner === $_SESSION["username"]) {
        $pathPicture = $data["path"];
        if (file_exists($pathPicture)) {
            $picture->deletePicture($pictureID);
            unlink($pathPicture);
            echo "Your picture has been deleted.";
        } else {
            echo "This file does not exist anymore. Don't make too many request!";
        }
    } else {
        echo "This picture is not yours, you can't delete it.";
    }
}