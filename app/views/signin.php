<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <title>Camagru - Sign in</title>
</head>
<?php include_once "views/header.php"; ?>
<body>
<section>

    <h1>Connexion</h1>
    <form method="post" action="/signin">
        <input type="text" placeholder="username" name="username" id="username">
        <input type="password" placeholder="password" name="password" id="password">
        <input type="submit" id="sub_button" value="Connexion" name="Connexion">
    </form>

    <h1>reset password</h1>
    <form method="post" action="/reset">
        <input type="text" placeholder="username" name="username" id="username">
        <input type="submit" id="sub_button" value="reset" name="reset">
    </form>

</section>
</body>
</html>