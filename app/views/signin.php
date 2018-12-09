<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <script src="./js/signin.js"></script>
    <title>Camagru - Sign in</title>
</head>
<?php include_once "views/header.php"; ?>
<body>
<section>

    <h1>Connexion</h1>
    <input type="text" placeholder="username" name="username" id="username">
    <input type="password" placeholder="password" name="password" id="password">
    <button onclick="signin()">Signin</button>

    <h1>reset password</h1>
    <input type="text" placeholder="username" name="username" id="username_for_reset">
    <button onclick="reset()">Signin</button>

</section>
</body>
</html>