<?php

function signup()
{
    $username = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    $mail = htmlspecialchars($_POST["mail"], ENT_QUOTES, 'UTF-8');
    $password = $_POST["password"];
    $confirmation = $_POST["confirmation"];
    $messages = checkInputValidity($username, $mail, $password, $confirmation);
    $response = [];
    if (empty($messages)) {
        $dataBase = new Database();
        $user = new User($dataBase);
        $key = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $user->signup($username, $mail, $hash, $key);
        sendConfirmationMail($username, $mail, $key);
        array_push($messages, "Your registation has been taken in consideration.");
#        array_push($messages, "A confirmation email has been sent.");
        $response["success"] = true;
    } else {
        $response["success"] = false;
    }
    $response["messages"] = $messages;
    $json = json_encode($response);
    echo $json;
}

function sendConfirmationMail($username, $mail, $key)
{
    $subject = "Confirmation from Camagru";
    $link = "http://localhost:8008/confirmation";
    $url = $link . "?username=" . urlencode($username) . "&key=" . urlencode($key);
    $message = "Your confirmation link is " . $url . " .";
    mail($mail, $subject, $message);
}

function checkInputValidity($username, $mail, $password, $confirmation)
{
    $dataBase = new Database();
    $user = new User($dataBase);
    $messages = array();
    if (empty($username)) {
        array_push($messages, "Username field is empty.");
    } else if (strlen($username) < 3) {
        array_push($messages, "Username should contains at least 3 characters.");
    } else {
        $verifUsername = $user->checkUsername($username);
        if (!empty($verifUsername)) {
            array_push($messages, "Username is already taken.");
        }
    }
    if (empty($mail)) {
        array_push($messages, "Email field is empty.");
    } else if (filter_var($mail, FILTER_VALIDATE_EMAIL) === false) {
        array_push($messages, "Email format is invalid.");
    } else {
        $verifMail = $user->checkMail($mail);
        if (!empty($verifMail)) {
            array_push($messages, "Email is already taken.");
        }
    }
    if (empty($password)) {
        array_push($messages, "Password field is empty.");
    } else if (!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $password) || strlen($password) < 8) {
        array_push($messages, "Password is not strong enough.");
        array_push($messages, "It should contains 8 characters, an uppercase, a lowercase, a special character and a digit.");
    }
    if (empty($confirmation)) {
        array_push($messages, "Password confirmation field is empty.");
    }
    if (!empty($password) && !empty($confirmation) && $password !== $confirmation) {
        array_push($messages, "Passwords don't match.");
    }
    return ($messages);
}

function signin()
{
    $username = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    $password = $_POST["password"];
    $messages = [];
    $response = [];
    if (!empty($username) && !empty($password)) {
        $dataBase = new Database();
        $user = new User($dataBase);
        $data = $user->getIdInfo($username);
        if (password_verify($password, $data["password"]) == true) {
            if ($data["confirmed"] == 1) {
                $_SESSION["username"] = $username;
                $_SESSION["mail"] = $data["mail"];
                $_SESSION["id"] = $data["id"];
                array_push($messages, "Your are now connected.");
                $response["success"] = true;
            } else {
                array_push($messages, "Your account has not been verified, check your email.");
                $response["success"] = false;
            }
        } elseif (empty($data)) {
            array_push($messages, "Username is unknown.");
            $response["success"] = false;
        } else {
            array_push($messages, "Wrong password.");
            $response["success"] = false;
        }
    } elseif (empty($username) && empty($password)) {
        array_push($messages, "Username and password fields are empty.");
        $response["success"] = false;
    } elseif (empty($username)) {
        array_push($messages, "Username field is empty.");
        $response["success"] = false;
    } else {
        array_push($messages, "Password field is empty.");
        $response["success"] = false;
    }
    $response["messages"] = $messages;
    $json = json_encode($response);
    echo $json;
}

function confirmRegistration()
{
    $username = $_POST["username"];
    $confirmationKey = $_POST["key"];
    $messages = array();
    $response = array();
    if (!empty($username) && !empty($confirmationKey)) {
        $dataBase = new Database();
        $user = new User($dataBase);
        $databaseKey = $user->getConfirmationKey($username);
        if ($databaseKey === $confirmationKey) {
            $user->confirmAccount($username);
            array_push($messages, "Your account has been activated.");
            $response["success"] = true;
        } else {
            array_push($messages, "Your activation key is not the one that we sent you.");
            $response["success"] = false;
        }
    }
    $response["messages"] = $messages;
    $json = json_encode($response);
    echo $json;
}


function updateProfile()
{
    $dataBase = new Database();
    $user = new User($dataBase);
    $messages = array();
    $response = array();
    if (isset($_SESSION["username"])) {
        if (!empty($_POST["username"])) {
            $username = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
            if (strlen($username) < 3) {
                array_push($messages, "Username should contains at least 3 characters.");
                $response["success"] = false;
            } else {
                $verifUsername = $user->checkUsername($username);
                if (!empty($verifUsername)) {
                    array_push($messages, "Username is already taken.");
                    $response["success"] = false;
                } else {
                    $user->updateUsername($username, $_SESSION["username"]);
                    $_SESSION["username"] = $username;
                    array_push($messages, "Username has been updated.");
                    $response["success"] = true;
                }
            }
        }
        if (!empty($_POST["mail"])) {
            $mail = htmlspecialchars($_POST["mail"], ENT_QUOTES, 'UTF-8');
            if (filter_var($mail, FILTER_VALIDATE_EMAIL) === false) {
                array_push($messages, "Email format is invalid.");
                $response["success"] = false;
            } else {
                $verifMail = $user->checkMail($mail);
                if (!empty($verifMail)) {
                    array_push($messages, "Email is already taken.");
                    $response["success"] = false;
                } else {
                    $user->updateEmail($_SESSION["username"], $mail);
                    $_SESSION["mail"] = $mail;
                    array_push($messages, "Email has been updated.");
                    $response["success"] = true;
                }
            }
        }
        if (!empty($_POST["password"])) {
            if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $_POST["password"]) && strlen($_POST["password"]) >= 8) {
                $hash = password_hash($_POST["password"], PASSWORD_BCRYPT);
                $user->updatePassword($_SESSION["username"], $hash);
                array_push($messages, "Password has been updated.");
                $response["success"] = true;
            } else {
                array_push($messages, "Password is not strong enough.");
                array_push($messages, "It should contains 8 characters, an uppercase, a lowercase, a special character and a digit.");
                $response["success"] = false;
            }
        }
        if (empty($_POST["username"]) && empty($_POST["mail"]) && empty($_POST["password"])) {
            array_push($messages, "Field is empty.");
            $response["success"] = false;
        }
    } else {
        array_push($messages, "You are not authentificated.");
        array_push($response, array("success" => false));
    }
    $response["messages"] = $messages;
    $json = json_encode($response);
    echo $json;
}

function resetPassword()
{
    $username = $_POST["username"];
    $dataBase = new Database();
    $user = new User($dataBase);
    $messages = array();
    $response = array();
    if (!empty($username)) {
        $verifUsername = $user->checkUsername($username);
        if (!empty($verifUsername)) {
            $password = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);;
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $mail = $user->getMail($username);
            $user->updatePassword($username, $hash);
            $message = "Your new password is " . $password . ". Don't forget to update it.";
            $subject = "Password reset - Camagru";
            mail($mail, $subject, $message);
            array_push($messages, "An email has been sent with your new password");
            $response["success"] = true;

        } else {
            array_push($messages, "The username that you entered is not in our database.");
            $response["success"] = false;
        }

    } else {
        array_push($messages, "Username field is empty.");
        $response["success"] = false;
    }
    $response["messages"] = $messages;
    $json = json_encode($response);
    echo $json;
}

function logout()
{
    unset($_SESSION["username"]);
    unset($_SESSION["mail"]);
    header("Location: /gallery");
}
