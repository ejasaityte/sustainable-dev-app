<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sustainable Dundee</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
<?php session_start(); 
    include("dbconnect.php");
?>
    <body>
        <!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-lg-5">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/map/0">Explore</a></li>
                <li class="nav-item"><a class="nav-link" href="/news">News</a></li>
                <li class="nav-item"><a class="nav-link active" href="/leaderboard">Leaderboard</a></li>
<?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        $sql = "SELECT friends.userID FROM `friends` INNER JOIN `users` ON friends.userID = users.userID WHERE friends.friendID = ".$_SESSION['userID']." AND friends.accepted = 0";
        $rows = array();
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) $rows[] = $row;
        if (empty($rows)) echo '<li class="nav-item"><a class="nav-link " href="/addfriend">Friends</a></li>';
        } else echo '<li class="nav-item"><a class="nav-link viridian" href="/addfriend">Friends</a></li>';
        if ($_SESSION['username']=='admin') echo '<li class="nav-item"><a class="nav-link" href="/addevent">Add Event</a></li><li class="nav-item"><a class="nav-link" href="/adduser">Add User</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="/favouriteslist">Favourites</a></li><li class="nav-item"><a class="nav-link" href="/logout">Log out</a></li>';
    } 
    else echo '<li class="nav-item"><a class="nav-link" href="/login"><span class="glyphicon glyphicon-log-in"></span>Login</a></li><li class="nav-item"><a class="nav-link" href="/register">Register</a></li>';
?>
            </ul>
        </div>
    </div>
</nav>

<br>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
?>
<div class="container-fluid text-center">
    <h1 class="display-5 fw-bold">Friends' Leaderboard</h1>
</div>
<br>

<div class="container-responsive">
    <div class="row justify-content-center" style="margin-right:0px; margin-left:0px;">
        <div class="col-sm-8 col-sm-offset-2 pb-5">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Score</th>
                    </thead>
                    <tbody>
<?php                            
    $sql = "SELECT email, leaderboard FROM `friends` INNER JOIN `users` ON friends.friendID = users.userID WHERE friends.accepted = 1 and friends.userID = ".$_SESSION['userID']." ORDER BY leaderboard DESC;";
    $rows = array();
    $result = $db->query($sql);

    while ($row = $result->fetch_assoc()) $rows[] = $row;
    $index = 1;
    foreach ($rows as $row){
?>
                        <tr>
                            <td><?php echo $index; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['leaderboard']; ?></td>
                        </tr>
<?php
        $index ++;
    }
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<div class="container-fluid text-center">
    <h1 class="display-5 fw-bold">Global Leaderboard</h1>
</div>
<br>
<div class="container-responsive">
    <div class="row justify-content-center" style="margin-right:0px; margin-left:0px;">
        <div class="col-sm-8 col-sm-offset-2 pb-5">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Score</th>
                    </thead>
                    <tbody>
<?php                            
    $sqlQ1 = "SELECT email, leaderboard FROM users ORDER BY leaderboard DESC";
    $rows = array();
    $result = $db->query($sqlQ1);

    while ($row = $result->fetch_assoc()) $rows[] = $row;
    $index = 1;
    foreach ($rows as $row){
?>
                        <tr>
                            <td><?php echo $index; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['leaderboard']; ?></td>
                        </tr>
<?php
        $index ++;
    }
?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- footer -->
<footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Sustainable Dundee 2021</p></div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>
</html>