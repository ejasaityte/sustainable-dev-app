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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-lg-5">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link"href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/map">Explore</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/login"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>


    <div class="position-absolute top-50 start-50 translate-middle">
        <form action="" method="post">
            <div class="d-grid gap-2">
                <div class="input-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                    <div class="invalid-tooltip"> Please enter a username.</div>
                </div>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" aria-describedby="passwordHelpBlock" required>
                    <div class="invalid-tooltip"> Please enter a password.</div>
                </div>
                <button type="submit" class="btn btn-primary">Log in</button>
            </div>


    </div>
    </div>

    </form>
    <?php
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(($username=="admin")&&($password=="admin"))
        {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: https://sustainabledundeeapp.azurewebsites.net");
        }
        /** 
        $loginQ = "SELECT password FROM LOGIN WHERE username = '$username'";  
        $res = mysql_query($loginQ);
        $res = mysql_fetch_array($res);    
    

        if(password_verify($password, $res[0])){
            if(preg_match("/@/", $username))
            {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                 header("Location: https://sustainabledundeeapp.azurewebsites.net");
            }

        }*/
    ?>
    </div>


</body>

</html>



<!-- https://www.bootstrapdash.com/use-bootstrap-with-php/ -->