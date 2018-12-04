<?php
session_start();

require_once "models/Database.php";
require_once "models/Like.php";
require_once "models/Picture.php";
require_once "models/Router.php";
require_once "models/User.php";
require_once "controllers/userController.php";
require_once "controllers/pictureController.php";
require_once "controllers/likeController.php";

$router = new Router($_GET["url"]);

// Basic redirection
$router->get("/", function () {
    array_push($_SESSION["messages"], "Bienvenue sur Camagru");
    include_once "./views/messages.php";
});
$router->get("/signin", function () { include_once "./views/signin.php"; });
$router->get("/signup", function () { include_once "./views/signup.php"; });
$router->get("/update", function () { include_once "./views/update.php"; });
$router->get("/snap", function () { include_once "./views/snap.php"; });
$router->get("/profile", function () { include_once "./views/profile.php"; });
$router->get("/printmessages/", function () { include_once "./views/messages.php"; });
$router->get("/gallery", function () { include_once "./views/gallery.php"; });

// Users data treatment
$router->post("/update", function () {
    $_SESSION["messages"] = $messages = updateProfile();
    header("Location: /printmessages");
});
$router->post("/signin", function () {
    $_SESSION["messages"] = identify($_POST["username"], $_POST["password"]);
    header("Location: /printmessages");
});
$router->post("/signup", function () {
    $_SESSION["messages"] = signup($_POST["username"], $_POST["mail"], $_POST["password"], $_POST["confirmation"]);
    header("Location: /printmessages");
});
$router->post("/reset", function () {
    $_SESSION["messages"] = resetPassword();
    header("Location: /printmessages");
});
$router->get("/confirmation", function () {
    $_SESSION["messages"] = confirmRegistration($_GET["username"], $_GET["key"]);
    header("Location: /printmessages");
});
$router->get("/logout", function () {
    unset($_SESSION["username"]);
    unset($_SESSION["mail"]);
    header("Location: /");
});

// Pictures data treatment
$router->post("/delete_picture", function () {
    deletePicture();
});
$router->post("/add_picture", function () {
    addPicture();
});

// Likes data treatment
$router->post("/like_button", function () {
    hitLikeButton();
});



$router->lookFor();