<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css">
    <script src="./js/updateProfileInfo.js"></script>
    <title>Camagru - Update</title>
</head>
<?php include_once "views/header.php"; ?>
<body>
<section>

    <h2>Username</h2>
    <input name="username" type="text">
    <button id="username" onclick="update(this)">Update</button>

    <h2>Email</h2>
    <input name="mail" type="text">
    <button id="mail" onclick="update(this)">Update</button>

    <h2>Password</h2>
    <input name="password" type="password">
    <button id="password" onclick="update(this)">Update</button>

</section>
</body>
</html>