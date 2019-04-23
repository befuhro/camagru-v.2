<?php

class User extends Model
{
    public $data = NULL;
    public $id = NULL;
    public $username = NULL;
    public $mail = NULL;
    public $confirmed = NULL;
    public $password = NULL;
    public $hash = NULL;
    public $random_key = NULL;


    public function checkUsername($username)
    {
        $username = $this->_dataBase->getData("SELECT username from users WHERE username = :username", array(":username" => $username))["username"];
        return ($username);
    }

    public function checkMail($mail)
    {
        $mail = $this->_dataBase->getData("SELECT mail from users WHERE mail = :mail", array(":mail" => $mail))["mail"];
        return ($mail);
    }

    public function getConfirmationKey($username)
    {
        $confirmationKey = $this->_dataBase->getData("SELECT random_key FROM users WHERE username = :username", array(":username" => $username))["random_key"];
        return ($confirmationKey);
    }

    public function getMail($username)
    {
        $mail = $this->_dataBase->getData("SELECT mail FROM users WHERE username = :username", array(":username" => $username))["mail"];
        return ($mail);
    }

    public function getHash($username)
    {
        $hash = $this->_dataBase->getData("SELECT password FROM users WHERE username = :username", array(":username" => $username))["password"];
        return ($hash);
    }

    public function getIdInfo($username)
    {
        $data = $this->_dataBase->getData("SELECT id, password, confirmed, mail FROM users WHERE username = :username", array(":username" => $username));
        return ($data);
    }

    public function getUsername($userID)
    {
        $username = $this->_dataBase->getData("SELECT username FROM users WHERE id = :id", array(":id" => $userID))["username"];
        return ($username);
    }

    public function signup($username, $mail, $hash, $confirmationKey)
    {
        $this->_dataBase->handleObject("INSERT INTO users(username, mail, password, random_key, confirmed)VALUES(:username, :mail, :password, :key, :confirmed)",
            array(":username" => $username, ":mail" => $mail, ":password" => $hash, ":key" => $confirmationKey, ":confirmed" => 1));
    }

    public function confirmAccount($username)
    {
        $this->_dataBase->handleObject("UPDATE users SET confirmed = 1 WHERE username = :username", array(":username" => $username));

    }

    public function updatePassword($username, $hash)
    {
        $this->_dataBase->handleObject("UPDATE users SET password = :hash WHERE username = :username",
            array(":hash" => $hash, ":username" => $username));
    }

    public function updateEmail($username, $mail)
    {
        $this->_dataBase->handleObject("UPDATE users SET mail = :email WHERE username = :username",
            array(":email" => $mail, ":username" => $username));
    }

    public function updateUsername($username, $oldUsername)
    {
        $this->_dataBase->handleObject("UPDATE users set username = :new WHERE username = :old",
            array(":old" => $oldUsername, ":new" => $username));
        $_SESSION["username"] = $username;
    }
}
