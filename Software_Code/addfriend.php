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
                        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            ?>
                  <li class="nav-item"><a class="nav-link" href="/favouriteslist">Favourites</a></li>
                  <li class="nav-item"><a class="nav-link active" href="/addfriend">Add Friend</a></li>
                  
                  <?php 
                  if ($_SESSION['isadmin']==1) { ?>
                  <li class="nav-item"><a class="nav-link" href="/addevent">Add Event</a></li>
                  <?php } 
                      if ($_SESSION['username']=='admin') { ?>
                      <li class="nav-item"><a class="nav-link" href="/adduser">Add User</a></li>
                      <?php } ?>
                  <li class="nav-item"><a class="nav-link" href="/logout">Log out</a></li>
                  <?php } 
                  else{
                  ?>
                  <li class="nav-item"><a class="nav-link" href="/login"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
          <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        <div class="container-fluid text-center">
            <h1 class="display-5 fw-bold">Add new friend</h1>
        </div>
        <br>
        <div class="position-absolute top-50 start-50 translate-middle">
        <form action="" method="post">
            <div class="d-grid gap-2">
                <div class="input-group">
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" minlength="3" required>
                    <div class="invalid-tooltip"> Please enter a email.</div>
                </div>
                <button type="submit" class="btn btn-primary">Request friend</button>
            </div>
        <?php
            $friend = $_POST['email'];
            if(!(preg_match("/@/", $friend))&&($friend!='')) // Checks it's an email
            {   
                ?>     
                    <div class="alert alert-warning" role="alert">
                        Choose a valid email!
                    </div>  
                <?php
            }
            else if (isset($_POST['email'])) { // This means it is an email *probably*
                $sql = "SELECT userID FROM users WHERE email='". $friend ."'";
                $rows = array();
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
                if (!empty($rows)) {
                    $friendID = $rows[0];
                    $sql = "INSERT INTO friends (userID, friendID) VALUES (".$_SESSION['userID'].", ".$friendID.");";
                    echo "userID: ".$_SESSION['userID'];
                    echo "friendID: ".$_SESSION['friendID'];
                    $result = $db->query($sql);
                } else {
                    ?>     
                        <div class="alert alert-warning" role="alert">
                            Email not found.
                        </div>  
                    <?php
                }
                    //TODO add a check before running to make sure they are not already friends

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
