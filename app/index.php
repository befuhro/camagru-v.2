<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <title>Camagru - Accueil</title>
    <script src="./js/likes.js"></script>
    <script src="./js/comments.js"></script>
    <script src="./js/pictures.js"></script>
    <script src="./js/webcam.js"></script>
</head>

<?php
session_start();

include_once "views/header.php";

require_once "models/Database.php";
require_once "models/Likes.php";
require_once "models/Picture.php";
require_once "models/Router.php";
require_once "models/User.php";
require_once "controllers/userController.php";
require_once "controllers/pictureController.php";
?>

<body>
<section>

    <?php

    $router = new Router($_GET["url"]);

    $router->get("/", function () {
        array_push($_SESSION["messages"], "Bienvenue sur Camagru");
        header("Location: /printmessages");
    });
    $router->get("/signin", function () { include_once "./views/signin.html";});
    $router->get("/signup", function () { include_once "./views/signup.html";});
    $router->get("/update", function () { include_once "./views/update.html";});
    $router->get("/snap", function () { include_once "./views/snap.html"; });

    $router->get("/profile", function () {
        include_once "./views/profile.php";
    });
    $router->get("/confirmation", function () {
        $_SESSION["messages"] = confirmRegistration($_GET["username"], $_GET["key"]);
        header("Location: /printmessages");
    });


    $router->get("/gallery", function () {
        echo paginate();
    });
























    // Data treatment
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

    $router->post("/delete_picture", function () {
        deletePic();
    });












    $router->get("/printmessages/", function () { ?>
        <section> <?php
            foreach ($_SESSION["messages"] as $message) {
                echo "<p>$message</p>";
            }
            $_SESSION["messages"] = []; ?>
        </section>
    <?php });


    $router->get("/logout", function () {
        unset($_SESSION["username"]);
        unset($_SESSION["mail"]);
        header("Location: /");
    });





    $router->lookFor();

    include_once "views/footer.html";
    ?>

</section>
</body>
</html>