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
        $data = $this->_dataBase->getData("SELECT username from users WHERE username = :username", array(":username" => $username));
        return ($data[0]);
    }

    public function checkMail($mail)
    {
        $data = $this->_dataBase->getData("SELECT mail from users WHERE mail = :mail", array(":mail" => $mail));
        return ($data[0]);
    }

    public function getConfirmationKey($username)
    {
        $data = $this->_dataBase->getData("SELECT random_key FROM users WHERE username = :username", array(":username" => $username));
        return ($data[0]);
    }

    public function getMail($username)
    {
        $data = $this->_dataBase->getData("SELECT mail FROM users WHERE username = :username", array(":username" => $username));
        return ($data[0]);
    }

    public function getHash($username)
    {
        $data = $this->_dataBase->getData("SELECT password FROM users WHERE username = :username", array(":username" => $username));
        return ($data[0]);
    }

    public function getIdInfo($username)
    {
        $data = $this->_dataBase->getData("SELECT id, password, confirmed, mail FROM users WHERE username = :username", array(":username" => $username));
        return ($data);
    }

    public function signup($username, $mail, $hash, $confirmationKey)
    {
        $this->_dataBase->handleObject("INSERT INTO users(username, mail, password, random_key)
          VALUES(:username, :mail, :password, :key)",
            array(":username" => $username, ":mail" => $mail, ":password" => $hash, ":key" => $confirmationKey));
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
        $this->_dataBase->handleObject("UPDATE likes set username = :new WHERE username = :old",
            array(":old" => $oldUsername, ":new" => $username));
        $this->_dataBase->handleObject("UPDATE comments set username = :new WHERE username = :old",
            array(":old" => $oldUsername, ":new" => $username));
        $this->_dataBase->handleObject("UPDATE pictures set username = :new WHERE username = :old",
            array(":old" => $oldUsername, ":new" => $username));
        $_SESSION["username"] = $username;
    }


















    public function add_picture($type)
    {
        $this->getData($this->username);
        $dir = "./picture/" . $type . "/";
        $file = $dir . basename($_FILES["path_picture"]["name"]);
        $file_type = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $file = $dir . $this->username . "." . $file_type;
        $ok = true;
        if (isset($_POST["picture"])) {
            $check = getimagesize($_FILES["path_picture"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                $ok = false;
            }
        }
        if (isset($this->data["profil_picture"]) &&
            $this->data["profil_picture"] != "") {
            unlink($this->data["profil_picture"]);
            $request = $this->bdd->prepare("UPDATE users SET profil_picture = NULL WHERE username = :username");
            $request->execute(array(":username" => $this->username));
            $request->closeCursor();
        }
        if ($_FILES["path_picture"]["size"] > 500000) {
            echo "The file is too large to be upload.";
            $ok = false;
        }
        if ($ok == true) {
            if (move_uploaded_file($_FILES["path_picture"]["tmp_name"], $file)) {
                $request = $this->bdd->prepare("UPDATE users SET profil_picture = :link WHERE username = :username");
                $request->execute(array(":link" => $file,
                    ":username" => $this->username));
                $request->closeCursor();
                echo "Your file has been uploaded.";
            } else
                echo "There was an error during the uploading.";
        } else
            echo "Sorry, your file couldn't be uploaded";
    }

    public function get_picture()
    {
        $this->get_data();
        if (isset($this->data["profil_picture"]) &&
            $this->data["profil_picture"] != "")
            $link = $this->data["profil_picture"];
        else
            $link = "";
        return ($link);
    }
}
