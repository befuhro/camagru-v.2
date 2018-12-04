<?php
function hitLikeButton()
{
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