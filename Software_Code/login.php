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
    <div class="position-absolute top-50 start-50 translate-middle">
        <form action="" method="post">
            <div class="d-grid gap-2">
                <div class="input-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                        required>
                    <div class="invalid-tooltip"> Please enter a username.</div>
                </div>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        aria-describedby="passwordHelpBlock" required>
                    <div class="invalid-tooltip"> Please enter a password.</div>
                </div>
                <button type="submit" class="btn btn-primary">Log in</button>
            </div>
        </form>
    </div>
    <?php
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT password, admin, userID FROM users WHERE email='". $username ."'";
    $rows = array();
    $result = $db->query($sql);
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    $output = '';
    foreach($rows as $item) $output .= implode("\n" , $item);
    foreach ($rows as $row){
        if(password_verify($password, $row['password'])){
            if((preg_match("/@/", $username))||($username=="admin"))
            {
                $_SESSION['loggedin'] = true;
                $_SESSION['userID'] = $row['userID'];
                $_SESSION['username'] = $username;
                $_SESSION['isadmin'] = $row['admin'];
                header("Location: https://sustainabledundeeapp.azurewebsites.net");
            }
        }
        break;
    }
?>
</body>

</html>