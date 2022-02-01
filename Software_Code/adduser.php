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
    include("dbconnect.php");?>
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
                        <li class="nav-item"><a class="nav-link" href="/leaderboard">Leaderboard</a></li>
<?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
?>
                        <li class="nav-item"><a class="nav-link" href="/favouriteslist">Favourites</a></li>
<?php
        $sql = "SELECT friends.userID FROM `friends` INNER JOIN `users` ON friends.userID = users.userID WHERE friends.friendID = ".$_SESSION['userID']." AND friends.accepted = 0";
        $rows = array();
        $result = $db->query($sql);

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        if (empty($rows)) {
?>
                        <li class="nav-item"><a class="nav-link " href="/addfriend">Friends</a></li>
<?php
        } else {
?>
                        <li class="nav-item"><a class="nav-link viridian" href="/addfriend">Friends</a></li>
<?php
    }
        if ($_SESSION['isadmin']==1) { 
?>
                        <li class="nav-item"><a class="nav-link" href="/addevent">Add Event</a></li>
<?php } 
        if ($_SESSION['username']=='admin') { ?>
                        <li class="nav-item"><a class="nav-link active" href="/adduser">Add User</a></li>
<?php 
        } 

?>

                        <li class="nav-item"><a class="nav-link" href="/logout">Log out</a></li>
<?php 
    } 
    else{
?>
                        <li class="nav-item"><a class="nav-link" href="/login"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
<?php 
    } 
?>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        <div class="container-fluid text-center">
            <h1 class="display-5 fw-bold">Add new user</h1>
        </div>
        <br>
        <div class="position-absolute top-50 start-50 translate-middle">
        <form action="" method="post">
            <div class="d-grid gap-2">
                <div class="input-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" minlength="3" required>
                    <div class="invalid-tooltip"> Please enter a username.</div>
                </div>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" minlength="3" aria-describedby="passwordHelpBlock" required>
                    <div class="invalid-tooltip"> Please enter a password.</div>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="isadmin" name="isadmin">
                    <label class="form-check-label" for="isadmin">Has admin privileges</label>
                </div>
                <button type="submit" class="btn btn-primary">Add User</button>
            </div>
        <?php
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (isset($_POST['isadmin']))
        {
            $isadmin = 1;
        }
        else
        {
            $isadmin = 0;
        }    
        if(($username=="admin")||(!(preg_match("/@/", $username))&&($username!='')))
        {
            ?><div class="alert alert-warning" role="alert">
  Choose another username!
</div> <?php
        }
        else {
            $sql = "SELECT * FROM users WHERE email='". $username ."'";
            $rows = array();
            $result = $db->query($sql);
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;

            }

            if(empty($rows)){
                $hashedPass = password_hash($password,PASSWORD_DEFAULT);
                if(strlen($username)!=0)
                {$updateReq = "INSERT INTO users (userID, email, password, admin, leaderboard) VALUES (NULL,'".$username."','".$hashedPass."',".$isadmin.",0)";
                $updateRes =$db->query($updateReq);
                ?><div class="alert alert-warning" role="alert">
    Success!
    </div> <?php
                }
            }
    }
    ?>

    </div>
    </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
