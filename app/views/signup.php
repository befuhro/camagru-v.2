<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <script src="./js/signup.js"></script>
    <title>Camagru - Sign up</title>
</head>
<?php include_once "views/header.php"; ?>
<body>
<section>

    <h1>Inscription</h1>
    <input type="text" placeholder="username" name="username" id="username">
    <input type="text" placeholder="mail" name="mail" id="mail">
    <input type="password" placeholder="password" name="password" id="password">
    <input type="password" placeholder="password" name="confirmation" id="confirmation">
    <button onclick="signup()">Signup</button>


</section>
</body>
</html>