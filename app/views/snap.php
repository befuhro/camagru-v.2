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
                <img src="/assets/miniatures/big-brain.png" class="icon" onclick="addIcon(this)">
                <img src="/assets/miniatures/dinosaur.png" class="icon" onclick="addIcon(this)">
                <img src="/assets/miniatures/dog.png" class="icon" onclick="addIcon(this)">
                <img src="/assets/miniatures/laughing-meme.png" class="icon" onclick="addIcon(this)">
                <img src="/assets/miniatures/thug-life.png" class="icon" onclick="addIcon(this)">
                <img src="/assets/miniatures/salt.png" class="icon" onclick="addIcon(this)">
            </div>

        </div>

        <div class="aside" id="aside"></div>
        <div hidden id="hidden"></div>
    </div>

</section>
</body>
</html>