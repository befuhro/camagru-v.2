<div id="main">
    <h1>Profile</h1>
    <div id="info">
        <hr/>
        <h2>Username</h2>
        <p><?php echo $_SESSION["username"]; ?></p>
        <br>
        <hr/>
        <h2>Mail</h2>
        <p><?php echo $_SESSION["mail"]; ?></p>
        <br>
        <a id="update_button" href="/update">Update informations</a>
    </div>
</div>