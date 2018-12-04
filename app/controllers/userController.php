<?php

function signup($username, $mail, $password, $confirmation)
{
    $messages = checkInputValidity($username, $mail, $password, $confirmation);
    if (empty($messages)) {
        $dataBase = new Database();
        $user = new User($dataBase);
        $key = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);;
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $user->signup($username, $mail, $hash, $key);
        sendConfirmationMail($username, $mail, $key);
        array_push($messages, "Your registation has been taken in consideration.");
        array_push($messages, "A confirmation email has been sent.");
    }
    return ($messages);
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

function identify($username, $password)
{
    $messages = [];
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
            } else {
                array_push($messages, "Your account has not been verified, check your email.");
            }
        } else {
            array_push($messages, "Wrong password.");
            array_push($messages, $data["password"]);
        }
    } elseif (empty($username) && empty($password)) {
        array_push($messages, "Username and password fields are empty.");
    } elseif (empty($username)) {
        array_push($messages, "Username field is empty.");
    } else {
        array_push($messages, "Password field is empty.");
    }
    return ($messages);
}

function confirmRegistration($username, $confirmationKey)
{
    $messages = [];
    if (!empty($username) && !empty($confirmationKey)) {
        $dataBase = new Database();
        $user = new User($dataBase);
        $databaseKey = $user->getConfirmationKey($username);
        if ($databaseKey === $confirmationKey) {
            $user->confirmAccount($username);
            array_push($messages, "Your account has been activated.");
        } else
            array_push($messages, "Your activation key is not the one that we sent you.");
    }
    return ($messages);
}


function updateProfile()
{
    $dataBase = new Database();
    $user = new User($dataBase);
    $messages = array();
    if (!empty($_POST["username"])) {
        if (strlen($_POST["username"]) < 3) {
            array_push($messages, "Username should contains at least 3 characters.");
        } else {
            $verifUsername = $user->checkUsername($_POST["username"]);
            if (!empty($verifUsername)) {
                array_push($messages, "Username is already taken.");
            } else {
                $user->updateUsername($_POST["username"], $_SESSION["username"]);
                $_SESSION["username"] = $_POST["username"];
                array_push($messages, "Username has been updated.");
            }
        }
    }
    if (!empty($_POST["mail"])) {
        if (filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL) === false) {
            array_push($messages, "Email format is invalid.");
        } else {
            $verifMail = $user->checkMail($_POST["mail"]);
            if (!empty($verifMail)) {
                array_push($messages, "Email is already taken.");
            } else {
                $user->updateEmail($_SESSION["username"], $_POST["mail"]);
                $_SESSION["mail"] = $_POST["mail"];
                array_push($messages, "Email has been updated.");
            }
        }
    }
    if (!empty($_POST["password"])) {
        if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $_POST["password"]) && strlen($_POST["password"]) >= 8) {
            $hash = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $user->updatePassword($_SESSION["username"], $hash);
            array_push($messages, "Password has been updated.");
        } else {
            array_push($messages, "Password is not strong enough.");
            array_push($messages, "It should contains 8 characters, an uppercase, a lowercase, a special character and a digit.");
        }
    }
    if (empty($_POST["username"]) && empty($_POST["mail"]) && empty($_POST["password"])) {
        array_push($messages, "All fields are empty.");
    }
    return ($messages);
}

function resetPassword()
{
    $dataBase = new Database();
    $user = new User($dataBase);
    $messages = array();
    if (!empty($_POST["username"])) {
        $verifUsername = $user->checkUsername($_POST["username"]);
        if (!empty($verifUsername)) {
            $password = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);;
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $mail = $user->getMail($_POST["username"]);
            $user->updatePassword($_POST["username"], $hash);
            $message = "Your new password is " . $password . ". Don't forget to update it.";
            $subject = "Password reset - Camagru";
            mail($mail, $subject, $message);
            array_push($messages, "An email has been sent with your new password");

        } else {
            array_push($messages, "The username that you entered is not in our database.");
        }

    } else {
        array_push($messages, "Username field is empty.");
    }
    return ($messages);
}