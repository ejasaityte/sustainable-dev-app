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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&family=Roboto&display=swap" rel="stylesheet">
</head>
<?php session_start(); 
    include("dbconnect.php");
    if (!isset($_SESSION['favouriteslist']))
    {
        $_SESSION['favouriteslist'] = array();
    }
?>

<body>
    <!-- Responsive navbar-->
    <?php include("navbar.php"); ?>
    <script>
        var element = document.getElementById('news');
        element.classList.add("active");
    </script>
    <!-- Header-->
    <header class="">
        <img src="https://www.dundeecity.gov.uk/sites/default/files/imagebank/sustainable800.png" class="img-fluid d-block mx-auto">
        <h1 class="fw-bold black text-center">What's New</h1>
    </header>
    <!-- Page Content-->
    <div class="container bg-viridian px-lg-5 p-3 rounded-3" style="max-width: 650px;">
        <a class="twitter-timeline" href="https://twitter.com/sust_dundee?ref_src=twsrc%5Etfw">Tweets by sust_dundee</a>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Sustainable Dundee 2021</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>