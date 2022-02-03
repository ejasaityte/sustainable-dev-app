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

<body>
    <?php
    session_start();
    include("dbconnect.php");
    error_reporting(0);
?>
    <?php include("navbar.php"); ?>
    <script>
        var element = document.getElementById('register');
        element.classList.add("active");
    </script>
    <div class="position-absolute top-50 start-50 translate-middle">
        <form action="" method="post">
            <div class="d-grid gap-2">
                <div class="input-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                        required>
                    <div class="invalid-tooltip"> Please enter an email.</div>
                </div>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        aria-describedby="passwordHelpBlock" required>
                    <div class="invalid-tooltip"> Please enter a password.</div>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
    <?php
    $username = $_POST['username'];
    $password = $_POST['password'];  
    if(($username=="admin")||(!(preg_match("/@/", $username))&&($username!=''))) echo '<div class="alert alert-warning" role="alert">Invalid email!</div>';
    else {
        $sql = "SELECT * FROM users WHERE email='". $username ."'";
        $rows = array();
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) $rows[] = $row;
        if(empty($rows)){
            $hashedPass = password_hash($password,PASSWORD_DEFAULT);
            if(strlen($username)!=0){
                $updateReq = "INSERT INTO users (userID, email, password, admin, leaderboard, eventOrganiser) VALUES (NULL,'".$username."','".$hashedPass."',0,0,0)";
                $updateRes =$db->query($updateReq);
                echo '<div class="alert alert-warning" role="alert">Successfully registered!</div>';
            }
        }
        elseif ($username!="") echo '<div class="alert alert-warning" role="alert">Email already registered!</div>';
    }
?>
</body>

</html>