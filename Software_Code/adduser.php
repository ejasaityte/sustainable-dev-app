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
var element = document.getElementById('adduser');
element.classList.add("active");
</script>
        <br>
        <div class="container-fluid text-center">
            <h1 class="display-5 fw-bold">Add new user</h1>
        
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
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="isorganiser" name="isorganiser">
                    <label class="form-check-label" for="isorganiser">Is event organiser</label>
                </div>
                <button type="submit" class="btn btn-primary">Add User</button>
            </div>
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
        if (isset($_POST['isorganiser']))
        {
            $isorganiser = 1;
        }
        else
        {
            $isorganiser = 0;
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
                {$updateReq = "INSERT INTO users (userID, email, password, admin, leaderboard, eventOrganiser) VALUES (NULL,'".$username."','".$hashedPass."',".$isadmin.",0,".$isorganiser.")";
                $updateRes =$db->query($updateReq);
                ?><div class="alert alert-warning" role="alert">
    Success!
    </div> <?php
                }
            }
    }
    ?>

    </div>
            <!-- footer -->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Sustainable Dundee 2021</p></div>
        </footer>
            
    </div>
        
        
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
