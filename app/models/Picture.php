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

    public function getOwner($pictureId)
    {
        $ownerid = $this->_dataBase->getData("SELECT ownerid FROM pictures WHERE id = :id", array(":id" => $pictureId))["ownerid"];
        $username = $this->_dataBase->getData("SELECT username FROM users WHERE id = :id", array(":id" => $ownerid))["username"];
        return ($username);
    }

    public function deletePicture($path)
    {
        $this->_dataBase->handleObject("DELETE FROM pictures WHERE path = :path", array(":path" => $path));
        $this->_dataBase->handleObject("DELETE FROM likes WHERE path_picture = :path", array(":path" => $path));
        $this->_dataBase->handleObject("DELETE FROM comments WHERE path_picture = :path", array(":path" => $path));
    }

    public function addPicture($ownerid)
    {
        $pictureNb = $this->_dataBase->getData("SELECT id FROM pictures WHERE id=(SELECT max(id) FROM pictures)", array())["id"];
        $this->_dataBase->handleObject("INSERT INTO pictures(ownerid, path) VALUES(:ownerid, :path)",
            array(":ownerid" => $ownerid, ":path" => "public/picture" . ++$pictureNb . ".jpeg"));
        return ($pictureNb);
    }


}
