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
<?php include("navbar.php"); ?>

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