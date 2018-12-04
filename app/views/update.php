<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <title>Camagru - Update</title>
</head>
<?php include_once "views/header.php"; ?>
<body>
<section>

    <form action="/update" method="post">
        <h2>Username</h2>
        <input name="username" type="text">
        <h2>Email</h2>
        <input name="mail" type="text">
        <h2>Password</h2>
        <input name="password" type="password">
        <input type="submit" value="update">
    </form>

</section>
</body>
</html>