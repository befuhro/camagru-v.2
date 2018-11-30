<?php

class Likes extends Model
{
    public $data = NULL;
    public $id = NULL;
    public $path_picture = NULL;
    public $username = NULL;

    public function getLikesPath($username)
    {
        $data = $this->_dataBase->getManyData("SELECT path_picture FROM likes
          WHERE username = :username", array(":username" => $username));
        return ($data);
    }
}