<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <script src="./js/pictures.js"></script>
    <script src="./js/likes.js"></script>
    <title>Camagru - Gallery</title>
</head>
<?php include_once "views/header.php"; ?>
<body>
<section>

    <?php
    echo paginate();
    ?>

</section>
</body>
</html>
