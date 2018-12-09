<?php

function postComment()
{
    if (isset($_SESSION["username"])) {
        $dataBase = new Database();
        $comments = new Comment($dataBase);
        $comment = htmlspecialchars($_POST["comment"], ENT_QUOTES, 'UTF-8');
        $pictureID = $_POST["pictureID"];
        $userID = $_SESSION["id"];
        $comments->postComment($userID, $pictureID, $comment);
        sendNotifMail($pictureID, $_SESSION["username"], $dataBase);
        $response = array("success" => true, "username" => $_SESSION["username"], "message" => "Your comment has been posted.");
        $json = json_encode($response);
        echo($json);
    } else {
        $response = array("success" => false, "message" => "You are not authentificated, you can not post comment.");
        $json = json_encode($response);
        echo($json);
    }
}

function paginateComments($pictureID)
{
    if (isset($_SESSION["username"])) {
        $dataBase = new Database();
        $users = new User($dataBase);
        $comments = getComments($pictureID, $dataBase);
        $page = "<p>Comments</p>";
        $page .= "<div class='comments'>";
        foreach ($comments as $comment) {
            $page .= "<p><b>" . $users->getUsername($comment["ownerid"]) . "</b><br>";
            $page .= $comment["comment"] . "</p>";
        }
        $page .= "</div>";
        $page .= "<input type='text' class='comment'>";
        $page .= "<button onclick='post_comment(this)'>post</button>";
        return ($page);
    } else {
        return ("");
    }
}

function getComments($pictureID, $dataBase)
{
    $comments = new Comment($dataBase);
    $allComments = $comments->getComments($pictureID);
    return ($allComments);
}

function sendNotifMail($pictureID, $posterName, $dataBase) {
    $pictures = new Picture($dataBase);
    $users = new User($dataBase);
    $ownerName = $pictures->getOwner($pictureID);
    $mail = $users->getMail($ownerName);
    $message = "One of your pictures has been commented by " . $posterName;
    $subject = "New comment on your picture - Camagru";
    mail($mail, $subject, $message);
    return ($mail);
}