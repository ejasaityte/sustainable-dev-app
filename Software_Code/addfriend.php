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
<?php include("navbar.php"); ?>
<script> 
var element = document.getElementById('friends');
element.classList.add("active");
</script>
        <br>
        <div class="container-fluid text-center">
            <h1 class="display-5 fw-bold">Friends</h1>
        </div>
        <br>

        <div class="container-responsive">
            <div class="row justify-content-center" style="margin-right:0px; margin-left:0px;">
                <div class="col-sm-4">
                    <h3>Friends list</h3>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>#</th>
                            <th>Email</th>
                            <th>Remove</th>
                        </thead>
                        <tbody>
                        <?php                            
                                $sql = "SELECT email, friendID FROM `friends` INNER JOIN `users` ON friends.friendID = users.userID WHERE friends.userID = ".$_SESSION['userID']." AND friends.accepted = 1;";
                                $rows = array();
                                $result = $db->query($sql);

                                while ($row = $result->fetch_assoc()) {
                                    $rows[] = $row;
                                }
                                $index = 1;
                                foreach ($rows as $row){
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $index; ?>
                                            </td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td>
                                                <form action="" method="post">
                                                    <?php 
                                                        $userID = $row['friendID'];
                                                        
                                                        echo '<input name="userID" class="d-none" type="hidden" value="'.$userID.'"  />';
                                                        echo "<button type='submit' class='btn btn-primary'>Remove</button>";
                                                    ?>
                                                </form>
                                                <?php
                                                    if (isset($_POST['userID'])) {
                                                        $sql = "DELETE FROM friends WHERE (userID = ".$_SESSION['userID']." AND friendID = ".$_POST['userID'].") OR (userID = ".$_POST['userID']." AND friendID = ".$_SESSION['userID'].");";
                                                        $db->query($sql);
                                                        echo "<script>location.reload()</script>";
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $index ++;
                                    }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-4">
                    <h3>Friend requests</h3>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>#</th>
                            <th>Email</th>
                            <th>Accept</th>
                            <th>Decline</th>
                        </thead>
                        <tbody>
                        <?php                            
                                $sql = "SELECT email, friends.userID FROM `friends` INNER JOIN `users` ON friends.userID = users.userID WHERE friends.friendID = ".$_SESSION['userID']." AND friends.accepted = 0";
                                $rows = array();
                                $result = $db->query($sql);

                                while ($row = $result->fetch_assoc()) {
                                    $rows[] = $row;
                                }
                                $index = 1;
                                foreach ($rows as $row){
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $index; ?>
                                            </td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td>
                                                <form action="" method="post">
                                                    <?php 
                                                        $userID = $row['userID'];
                                                        echo '<input name="friendID" class="d-none" type="hidden" value="'.$userID.'"  />';
                                                        echo "<button type='submit' class='btn btn-primary'>Accept</button>";
                                                    ?>
                                                </form>
                                                <?php
                                                    if (isset($_POST['friendID'])) {
                                                        $sql = "UPDATE `friends` SET accepted = 1 WHERE userID = ".$_POST['friendID']." AND friendID = ".$_SESSION['userID'].";";
                                                        $insertSQL = "INSERT INTO `friends` (userID, friendID, accepted) VALUES (".$_SESSION['userID'].", ".$_POST['friendID'].", 1);";
                                                        $db->query($sql);
                                                        $db->query($insertSQL);
                                                        echo "<script>location.reload()</script>";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <?php 
                                                        $userID = $row['userID'];
                                                        echo '<input name="userID" class="d-none" type="hidden" value="'.$userID.'"  />';
                                                        echo "<button type='submit' class='btn btn-primary'>Decline</button>";
                                                    ?>
                                                </form>
                                                <?php
                                                    if (isset($_POST['userID'])) {
                                                        $sql = "DELETE FROM `friends` WHERE userID = ".$_POST['userID']." AND friendID = ".$_SESSION['userID'].";";
                                                        $db->query($sql);
                                                        echo "<script>location.reload()</script>";
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $index ++;
                                    }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-4">
                    <h3>Add friend</h3>
                    <form action="" method="post">
                        <div class="d-grid gap-2">
                            <div class="input-group">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" minlength="3" required>
                                <div class="invalid-tooltip"> Please enter a email.</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Request friend</button>
                        </div>
                    </form>
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
                            $friendID = $rows[0]['userID'];
                            if (!empty($rows) && $friendID != $_SESSION['userID']) {
                                $sql = "SELECT * FROM `friends` WHERE (userID = ".$_SESSION['userID']." and friendID = ".$friendID.") OR (userID = ".$friendID." and friendID = ".$_SESSION['userID'].");";
                                $result = $db->query($sql); 
                                $rows = array();
                                while ($row = $result->fetch_assoc()) {
                                    $rows[] = $row;
                                }
                                if (!empty($rows)) {
                                    ?>     
                                        <div class="alert alert-warning" role="alert">
                                            Email already requested.
                                        </div>  
                                    <?php
                                    return;
                                }
                                $sql = "INSERT INTO friends (userID, friendID) VALUES (".$_SESSION['userID'].", ".$friendID.");";
                                $db->query($sql); 
                            } else {
                                ?>     
                                    <div class="alert alert-warning" role="alert">
                                        Email invalid.
                                    </div>  
                                <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>

    </div>
    
    <!-- footer -->
        <style>
            .footer {
                height: 100px;
                position: fixed;
                display: flex;
                left: 0;
                bottom: 0;
                width:100%;
                background-color:black;
                color:white;
                justify-content: center;
                align-items: center;
        </style>
        <div class = "footer">
            <p>Copyright &copy; Sustainable Dundee 2021</p>
        </div>
    
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
