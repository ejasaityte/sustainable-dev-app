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
    ?>
    <li class="nav-item"><a class="nav-link" href="/addevent">Add Event</a></li><?php
        if ($_SESSION['username']=='admin') { ?>
                        <li class="nav-item"><a class="nav-link" href="/adduser">Add User</a></li>
<?php 
        } 

?>
                        <li class="nav-item"><a class="nav-link active" href="/changepassword">Change Password</a></li>
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
            <h1 class="display-5 fw-bold">Change password</h1>
        </div>
        <br>
        <div class="position-absolute top-50 start-50 translate-middle">
        <form action="" method="post">
            <div class="d-grid gap-2">
                <div class="input-group">
                    <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Current password" minlength="3" aria-describedby="passwordHelpBlock" required>
                    <div class="invalid-tooltip"> Please enter your current password.</div>
                </div>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="New password" minlength="3" aria-describedby="passwordHelpBlock" required>
                    <div class="invalid-tooltip"> Please enter your new password.</div>
                </div>
                <button type="submit" class="btn btn-primary">Change Password</button>
            </div>
        <?php
        $oldpassword = $_POST['oldpassword'];
        $password = $_POST['password'];  

        $sql = "SELECT password FROM users WHERE email='". $_SESSION['username'] ."'";
        $rows = array();
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        foreach($rows as $row)
        {
            $oldHashedPass = password_hash($oldpassword,PASSWORD_DEFAULT);
            if(password_verify($oldpassword, $row['password']))
            {
                $hashedPass = password_hash($password,PASSWORD_DEFAULT);
                $updateReq = "UPDATE users SET password='". $hashedPass ."' WHERE email='". $_SESSION['username'] ."'";
                $updateRes =$db->query($updateReq);
                echo '<div class="alert alert-warning" role="alert">Successfully changed password!</div>';
            }
            elseif($oldpassword!="") {
                echo '<div class="alert alert-warning" role="alert">Wrong current password.</div>'; 
            }
            break;
        }
    ?>

    </div>
    </div>
        
        <!-- footer -->
        <br><br><br><br>
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Sustainable Dundee 2021</p></div>
        </footer>
        </br></br></br></br>
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
