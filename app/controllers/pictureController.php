<?php

function paginate()
{
    $dataBase = new Database();
    $picture = new Picture($dataBase);
    if (!empty($_SESSION["username"])) {
        $like = new Likes($dataBase);
        $likes = $like->getLikesPath($_SESSION["username"]);
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
        $page .= "<img src=\"" . $item["path"] . "\">";
        if (isset($_SESSION["username"])) {
            $page .= likeButton($likes, $item["path"]);
            $page .= "<p>Comments</p>";
            $page .= "<div class=\"comments\"></div>";
            $page .= "<input type=\"text\" class=\"comment\">";
            $page .= "<button onclick=\"post_comment(this)\">post</button>";
            if ($_SESSION["username"] == $item["username"]) {
                $page .= "<br><br><button onclick=\"delete_picture(this)\">delete picture</button>";
            }
        }
        $page .= "</div>";
    }
    return($page);
}

function likeButton($likes, $path)
{
    if (in_array($path, $likes))
        return("<br><img class=\"like\" onclick=\"like_button(this)\" src=\"../miniature/full_like.png\">");
    else
        return("<br><img class=\"like\" onclick=\"like_button(this)\" src=\"../miniature/empty_like.png\">");
}


function deletePic() {
    $dataBase = new Database();
    $picture = new Picture($dataBase);
    $array = explode('/', $_POST["path"]);
    $path = $array[count($array) - 2] . '/' . $array[count($array) - 1];
    $pictureOwner = $picture->getOwner($_POST["path"]);
    if ($pictureOwner === $_SESSION["username"])
    {
        $picture->deletePicture( "../" . $path);
        unlink($path);
    }
}





//
//function pages_link()
//{
//    $nb_pages = number_pages();
//    echo "<p>";
//    if ($nb_pages > 0) {
//        for ($i = 0; $i <= $nb_pages; $i++) {
//            echo "<a href=\"/views/gallery.php?page=" . $i . "\"> $i </a>";
//        }
//    }
//    echo "</p>";
//}
//
//function number_pages()
//{
//    $nb = 0;
//    $bdd = init();
//    $request = $bdd->prepare("SELECT id FROM pictures");
//    $request->execute();
//    while ($data = $request->fetch())
//        $nb++;
//    if ($nb % 5 != 0)
//        $nb = floor($nb / 5);
//    else
//        $nb = $nb / 5 - 1;
//    return $nb;
//}
//