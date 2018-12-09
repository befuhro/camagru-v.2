<?php

function displayError() {
    if (isset($_GET["code"]) && isset($_GET["message"])) {
        echo "<p><b>" . $_GET["code"] . "</b></p>";
        echo "<p>" . $_GET["message"] . "</p>";
        echo "<img src='/assets/errors/tux-zen.png'>";
    }
}