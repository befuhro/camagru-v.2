<?php
session_start();

require_once "models/Database.php";
require_once "models/Comment.php";
require_once "models/Like.php";
require_once "models/Picture.php";
require_once "models/Router.php";
require_once "models/User.php";
require_once "controllers/errorController.php";
require_once "controllers/commentController.php";
require_once "controllers/userController.php";
require_once "controllers/pictureController.php";
require_once "controllers/likeController.php";

$router = new Router($_GET["url"]);

/* Views redirections. */
$router->get(false,"/", function () { include_once "./views/gallery.php"; });
$router->get(false,"/error", function () { include_once "./views/error.php"; });
$router->get(false,"/signin", function () { include_once "./views/signin.php"; });
$router->get(false,"/signup", function () { include_once "./views/signup.php"; });
$router->get(true, "/update", function () { include_once "./views/update.php"; });
$router->get(false,"/confirmation", function () { include_once "./views/confirmation.php"; });
$router->get(false,"/gallery", function () { include_once "./views/gallery.php"; });
$router->get(true,"/snap", function () { include_once "./views/snap.php"; });
$router->get(true,"/profile", function () { include_once "./views/profile.php"; });


/* Users data treatment. */
$router->post(false,"/confirmation", function () { confirmRegistration(); });
$router->get(true,"/logout", function () { logout(); });
$router->post(false,"/reset", function () { resetPassword(); });
$router->post(false,"/signin", function () { signin(); });
$router->post(false,"/signup", function () { signup(); });
$router->post(true,"/update", function () { updateProfile(); });

// Pictures data treatment
$router->post(true,"/delete_picture", function () { deletePicture(); });
$router->get(false,"/paginate", function () { paginate(); });
$router->post(true,"/add_picture", function () { addPicture(); });

// Likes data treatment
$router->post(true,"/like_button", function () { hitLikeButton(); });

// Comments data treatment
$router->post(true,"/post_comment", function () { postComment(); });


try {
    $router->lookFor();
}
catch (Exception $exception) {
    if ($exception->getMessage() === "You are not authorized to access this webpage." || $exception->getCode() === 404) {
        header("Location: /error?code=" . $exception->getCode() . "&message=" . $exception->getMessage());
    }
    else {
        $response = ["code" => $exception->getCode(), "message" => $exception->getMessage()];
        $json = json_encode($response);
        echo $json;
    }
}
