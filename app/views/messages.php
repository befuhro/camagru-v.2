<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <title>Camagru</title>
</head>
<?php include_once "views/header.php"; ?>
<body>
<section>

    <?php
    foreach ($_SESSION["messages"] as $message) {
        echo "<p>$message</p>";
    }
    $_SESSION["messages"] = [];
    ?>

</section>
</body>
</html>