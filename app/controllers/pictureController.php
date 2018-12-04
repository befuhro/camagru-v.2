<?php

function paginate()
{
    $dataBase = new Database();
    $picture = new Picture($dataBase);
    if (!empty($_SESSION["username"])) {
        $like = new Like($dataBase);
        $likes = $like->getLikesPath($_SESSION["id"]);
    }
    if (!empty($_GET["page"])) {
        $pageNumber = $_GET["page"];
    } else {
        $pageNumber = 0;
    }
    $pictures = $picture->fetchPictures($pageNumber * 5, 5);
    $page = "";
    foreach ($pictures as $item) {
        $page .= "<div class=\"pagine\">";
        $page .= "<h2>" . $item["username"] . "</h2>";
        $page .= "<img src=\"" . $item["path"] . "\" id=\"" . $item["id"] . "\">";
        if (isset($_SESSION["username"])) {
            $page .= likeButton($likes, $item["id"]);
            $page .= "<p>Comment</p>";
            $page .= "<div class=\"comments\"></div>";
            $page .= "<input type=\"text\" class=\"comment\">";
            $page .= "<button onclick=\"post_comment(this)\">post</button>";
            if ($_SESSION["username"] == $item["username"]) {
                $page .= "<br><br><button onclick=\"delete_picture(this)\">delete picture</button>";
            }
        }
        $page .= "</div>";
    }
    return ($page);
}

function likeButton($likes, $pictureid)
{
    if (in_array($pictureid, $likes))
        return ("<br><img class=\"like\" onclick=\"like_button(this)\" src=\"../miniature/full_like.png\">");
    else
        return ("<br><img class=\"like\" onclick=\"like_button(this)\" src=\"../miniature/empty_like.png\">");
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
    $path = "public/" . explode('/', $_POST["path"])[4];
    $pictureOwner = $picture->getOwner($path);
    if ($pictureOwner === $_SESSION["username"]) {
        $picture->deletePicture($path);
        if (file_exists($path)) {
            unlink($path);
            echo "Your picture has been deleted.";
        }
        else {
            echo "This file does not exist anymore. Don't make too many request!";
        }

    } else {
        echo "You are not authentificated.";
    }
}