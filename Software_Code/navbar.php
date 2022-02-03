<nav class="navbar navbar-expand-lg navbar-dark bg-rose">
    <div class="container px-lg-5">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" id="home" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" id="explore" href="/map/0">Explore</a></li>
                <li class="nav-item"><a class="nav-link" id="tours" href="/tours">Tours</a></li>
                <li class="nav-item"><a class="nav-link" id="news" href="/news">News</a></li>
                <li class="nav-item"><a class="nav-link" id="leaderboard" href="/leaderboard">Leaderboard</a></li>
<?php
    session_start();
    include("dbconnect.php");
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $sql = "SELECT friends.userID FROM `friends` INNER JOIN `users` ON friends.userID = users.userID WHERE friends.friendID = ".$_SESSION['userID']." AND friends.accepted = 0";
        $rows = array();
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) $rows[] = $row;
        if (empty($rows)) echo '<li class="nav-item"><a class="nav-link"  id="friends" href="/addfriend">Friends</a></li>';
        else echo '<li class="nav-item"><a class="nav-link viridian" id="friends" href="/addfriend">Friends</a></li>';
        if ($_SESSION['username']=='admin') echo '<li class="nav-item"><a class="nav-link" id="addevent" href="/addevent">Add Event</a></li><li class="nav-item"><a class="nav-link" id="addtour" href="/addtour">Add Tour</a></li><li class="nav-item"><a class="nav-link" id="adduser" href="/adduser">Add User</a></li>';
        echo '<li class="nav-item"><a class="nav-link" id="favouriteslist" href="/favouriteslist">Favourites</a></li><li class="nav-item"><a class="nav-link" id="changepassword" href="/changepassword">Change password</a></li><li class="nav-item"><a class="nav-link" id="logout" href="/logout">Log out</a></li>';
    } else echo '<li class="nav-item"><a class="nav-link"  id="login" href="/login"><span class="glyphicon glyphicon-log-in"></span>Login</a></li><li class="nav-item"><a class="nav-link" id="register" href="/register">Register</a></li>';
?>
            </ul>
        </div>
    </div>
</nav>