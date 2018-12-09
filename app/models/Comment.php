<?php
/**
 * Created by PhpStorm.
 * User: befuhro
 * Date: 11/30/18
 * Time: 6:26 PM
 */

class Comment extends Model
{
    public $data = null;
    public $comment = null;
    public $userID = null;
    public $pictureID = null;

    public function postComment($ownerID, $pictureID, $comment) {
        $this->_dataBase->handleObject("INSERT INTO comments(pictureid, ownerid, comment) VALUES(:pictureID, :ownerID, :comment)",
            array("pictureID" => $pictureID, ":ownerID" => $ownerID, ":comment" => $comment));
    }

    public function getComments($pictureID) {
        $data = $this->_dataBase->getManyData("SELECT ownerid, comment FROM comments WHERE pictureid = :pictureID", array(":pictureID" => $pictureID));
        return ($data);
    }

    public function getLikesPath($ownerId)
    {
        $likes = array();
        $data = $this->_dataBase->getManyData("SELECT pictureid FROM likes WHERE ownerid = :ownerId",
            array(":ownerId" => $ownerId));
        foreach ($data as $like) {
            array_push($likes, $like["pictureid"]);
        }
        return ($likes);
    }
}