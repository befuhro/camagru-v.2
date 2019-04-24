<?php

function hitLikeButton()
{
    if (isset($_SESSION["id"])) {
        $pictureId = $_POST["id"];
        $userId = $_SESSION["id"];
        $dataBase = new Database();
        $likes = new Like($dataBase);
        $data = $likes->isLiked($pictureId, $userId);
        if (!empty($data)) {
            echo "Was liked.\nBut not anymore!";
            echo $likes->deleteLike($pictureId, $userId);
        } else {
            echo "Was not liked.\nBut is now!";
            echo $likes->addLike($pictureId, $userId);
        }
    }
}

function likeButton($likes, $pictureID)
{
    if (isset($_SESSION["username"])) {
        if (in_array($pictureID, $likes)) {
            return ("<img class='like' id='on' onclick='like_button(this)' src='/assets/like_buttons/liked.png'>");
        } else {
            return ("<img class='like' id='off' onclick='like_button(this)' src='/assets/like_buttons/disliked.png'>");
        }
    }
}