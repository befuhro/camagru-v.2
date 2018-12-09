<script>function logout() { alert("You are now logged out.");}</script>

<header>
    <h1>Camagru</h1>
    <div id="center">
        <a href="/gallery">Gallery</a>
        <?php if (isset($_SESSION["username"])) { ?>
            <a href="/snap">Snap</a>
            <a href='/profile'>Profile</a>
        <?php } ?>
    </div>

    <div id="side">
        <?php if (isset($_SESSION["username"]))
            echo "<a onclick='logout()' href='/logout'>logout</a>";
        else {
            echo "<a href=\"/signin\">signin</a>";
            echo "<a href=\"/signup\">signup</a>";
        }
        ?>
    </div>
</header>
