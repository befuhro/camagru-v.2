<?php

class Like extends Model
{
    public $data = NULL;
    public $id = NULL;
    public $path_picture = NULL;
    public $username = NULL;

    public function getLikesPath($ownerId)
    {
        $data = $this->_dataBase->getManyData("SELECT pictureid FROM likes WHERE ownerid = :ownerId",
            array(":ownerId" => $ownerId));
        return ($data);
    }

    public function isLiked($pictureId, $ownerId)
    {
        $data = $this->_dataBase->getManyData("SELECT * FROM likes WHERE pictureid = :pictureId AND ownerId = :ownerId",
            array("pictureId" => $pictureId, ":ownerId" => $ownerId));
        return ($data);
    }

    public function addLike($pictureId, $ownerId)
    {
        $this->_dataBase->handleObject("INSERT INTO likes(pictureid, ownerid) VALUES(:pictureId, :ownerId)",
            array(":pictureId" => $pictureId, ":ownerId" => $ownerId));
    }

    public function deleteLike($pictureId, $ownerId)
    {
        $this->_dataBase->handleObject("DELETE FROM likes WHERE pictureid = :pictureId AND ownerid = :ownerId",
            array(":pictureId" => $pictureId, ":ownerId" => $ownerId));
    }
}