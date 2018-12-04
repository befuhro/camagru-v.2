<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <script src="./js/webcam.js"></script>
    <title>Camagru - Snap</title>
</head>
<?php include_once "views/header.php"; ?>
<body>
<section>

    <div class="webcam">
        <div class="main" id="main">
            <div class="main_title">
                <h1>Snap</h1>
            </div>

            <div id="montage">
                <video autoplay="true" class="video" id="video"></video>
                <canvas class="canvas" id="image"></canvas>
            </div>

            <div id="buttons"></div>

            <div id="icons">
                <img src="/miniature/big-brain.png" class="icon" onclick="addIcon(this)">
                <img src="/miniature/dinosaur.png" class="icon" onclick="addIcon(this)">
                <img src="/miniature/dog.png" class="icon" onclick="addIcon(this)">
                <img src="/miniature/laughing-meme.png" class="icon" onclick="addIcon(this)">
                <img src="/miniature/thug-life.png" class="icon" onclick="addIcon(this)">
                <img src="/miniature/salt.png" class="icon" onclick="addIcon(this)">
            </div>

        </div>

        <div class="aside" id="aside"></div>
        <div hidden id="hidden"></div>
    </div>

</section>
</body>
</html>