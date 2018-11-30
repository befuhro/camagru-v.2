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
        $data = $this->_dataBase->getManyData(
            "SELECT id, username, path, positions FROM pictures ORDER BY id DESC LIMIT " . $from . " , " . $to, array());
        return ($data);
    }

    public function getOwner($path)
    {
        $data = $this->_dataBase->getData("SELECT username FROM pictures WHERE path = path", array(":path" => $path));
        return ($data[0]);
    }

    public function deletePicture($path)
    {
        $this->_dataBase->handleObject("DELETE FROM pictures WHERE path = :path", array(":path" => $path));
        $this->_dataBase->handleObject("DELETE FROM likes WHERE path_picture = :path", array(":path" => $path));
        $this->_dataBase->handleObject("DELETE FROM comments WHERE path_picture = :path", array(":path" => $path));
    }
}
