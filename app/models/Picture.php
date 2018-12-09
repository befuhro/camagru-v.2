<?php

class Picture extends Model
{
    public $data = NULL;
    public $id = NULL;
    public $username = NULL;
    public $path = NULL;
    public $position = NULL;

    public function fetchPictures($from, $to)
    {
        $data = $this->_dataBase->getManyData("SELECT * FROM pictures ORDER BY id DESC LIMIT " . $from . " , " . $to, array());
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]["username"] = $this->getOwner($data[$i]["id"]);
        }
        return ($data);
    }

    public function getOwner($pictureID)
    {
        $ownerID = $this->_dataBase->getData("SELECT ownerid FROM pictures WHERE id = :id", array(":id" => $pictureID))["ownerid"];
        $username = $this->_dataBase->getData("SELECT username FROM users WHERE id = :id", array(":id" => $ownerID))["username"];
        return ($username);
    }


    public function getOwnerAndPath($pictureID)
    {
        $data = $this->_dataBase->getData("SELECT ownerid, path FROM pictures WHERE id = :id", array(":id" => $pictureID));
        $data["owner"] = $this->_dataBase->getData("SELECT username FROM users WHERE id = :id", array(":id" => $data["ownerid"]))["username"];
        return ($data);
    }

    public function deletePicture($pictureID)
    {
        $this->_dataBase->handleObject("DELETE FROM pictures WHERE id = :id", array(":id" => $pictureID));
        $this->_dataBase->handleObject("DELETE FROM likes WHERE pictureid = :id", array(":id" => $pictureID));
        $this->_dataBase->handleObject("DELETE FROM comments WHERE pictureid = :id", array(":id" => $pictureID));
    }

    public function addPicture($ownerid)
    {
        $pictureNb = $this->_dataBase->getData("SELECT id FROM pictures WHERE id=(SELECT max(id) FROM pictures)", array())["id"];
        $this->_dataBase->handleObject("INSERT INTO pictures(ownerid, path) VALUES(:ownerid, :path)",
            array(":ownerid" => $ownerid, ":path" => "public/picture" . ++$pictureNb . ".jpeg"));
        return ($pictureNb);
    }
}