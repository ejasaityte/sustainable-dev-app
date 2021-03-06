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
    <link href="/css/styles.css" rel="stylesheet" />
</head>
<?php 
    session_start(); 
    include("dbconnect.php");
    if (!isset($_SESSION['favouriteslist'])) $_SESSION['favouriteslist'] = array();
?>

<body>
    <!-- Responsive navbar-->
    <?php include("navbar.php"); ?>
    <!-- Header-->
    <div class="main">
        <header class="py-5">
            <div class="container px-lg-5">
                <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
                    <div class="m-4 m-lg-5">
                        <?php
    $goalID = $params['goal'];
    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => "https://sustainabledundeeapp.azurewebsites.net/api/singleGoal/$goalID",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 29,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_0_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        )
    );
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $response = json_decode($response, true);// Decode JSON data into PHP array
    echo '<h1 class="display-5 fw-bold">'.$response[0]['goalName'].'</h1>';
    echo '<p class="fs-4">'.$response[0]['goalDescription'].'</p>';
    echo "<a class='btn btn-primary btn-lg' href='/map/" . $goalID . "'>Explore the map!</a>";
?>
                    </div>
                </div>
            </div>
        </header>
        <!-- Page Content-->
        <section class="pt-4 bg-viridian">
            <div class="container px-lg-5">
                <!-- Page Features-->
                <div class="row gx-lg-5 pt-3">

                    <?php
    $curl = curl_init();
    curl_setopt_array($curl, 
        array(
            CURLOPT_URL => "https://sustainabledundeeapp.azurewebsites.net/api/allEvents/$goalID",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        )
    );
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $response = json_decode($response, true);// Decode JSON data into PHP array
    foreach ($response as $event) {
        echo '
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <h2 class="fs-4 fw-bold">' . $event['name'] . '</h2></a>
                                <p class="mb-0">' . $event['description'] . '</p>
                                <p> </p>
                                <p class="text-start"><strong>For more information visit the <a href=' . $event['website'] . '>website</a></strong></p> 
                                <p class="text-start"><strong>Contact</strong>: ' . $event['contacts'] . '</p>

                            </div>';
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo '
                            <div class="container" style="padding-bottom:10px;">
                                <div class="row justify-content-center">
                                    <div class="col-sm-auto text-center" style="padding-bottom:10px;">
                                        <a class="btn btn-primary btn-sm mt-auto" href="/additem/' . $event['id'] . '"">Favourite</a>
                                    </div>
                                    <div class="col-sm-auto text-center" style="padding-bottom:10px;">
                                        <a class="btn btn-primary btn-sm mt-auto" href="/checkin/' . $_SESSION['userID'] . '"">Check in</a>
                                    </div>';
            if($_SESSION['isadmin']==1)
                echo '
                                    <div class="col-sm-auto text-center" style="padding-bottom:10px;">
                                        <a class="btn btn-primary btn-sm mt-auto" href="/edititem/' . $event['id'] . '"">Edit</a>
                                    </div>
                                    <div class="col-sm-auto text-center" style="padding-bottom:10px;">
                                        <a class="btn btn-primary btn-sm mt-auto" href="/deleteevent/' . $event['id'] . '"">Delete</a>
                                    </div>
                                    <div class="col-sm-auto text-center" style="padding-bottom:10px;">
                                        <a class="btn btn-primary btn-sm mt-auto" href="/editlocation/' . $event['id'] . '"">Edit location</a>
                                    </div>';
            if (str_word_count($event['name']) > 1){
                $str = explode(" ", $event['name']);
                $name = implode("", $str);
            }
            else $name = $event['name'];
?>
                    <div class="col-sm-auto  text-center" style="padding-bottom:10px;">
                        <a data-bs-toggle="tooltip" data-bs-placement="right" title="Tweet"
                            href="https://twitter.com/intent/tweet?text=I%20just%20visited%20%23<?php echo $name; ?>%21%20@DundeeCouncil&hashtags=sustainabledundee"
                            target="_blank"><img
                                src="https://logos-world.net/wp-content/uploads/2020/04/Twitter-Emblem.png"
                                style="width:50px;height:28px;">
                        </a>
                    </div>
                </div>
            </div>
            <?php
        } 
?>
    </div>
    </div>
    <?php    
    }
?>
    </div>
    </div>
    </section>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>