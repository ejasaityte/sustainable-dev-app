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
    if (!isset($_SESSION['favouriteslist'])) $_SESSION['favouriteslist'] = array();
    ?>

<body>
    <!-- Responsive navbar-->
    <?php include("navbar.php"); ?>
    <div class="d-block mx-auto text-center p-3" style="max-width:800px;">
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
    echo '<img alt="'.$response[0]['goalName'].'" src="' . $response[0]['goalPicture'] . '">';
    echo '        
        <div class="bg-mikado rounded-3 mb-3">
            <p class="fs-4">'.$response[0]['goalDescription'].'</p>
        </div>'
    echo '<a class="btn btn-ygreen btn-lg white w-100 mb-3" href="/map/'.$goalID.'"><u>Click here to see events related to this goal on the map!</u></a>';
?>
        <div class="bg-viridian rounded-3">
            <p class="fs-4 white"><u>View events related to this goal in Dundee below.</u></p>
            <div class="d-flex justify-content-center">
                <div class="d-flex flex-wrap justify-content-center p-3">

                    <?php
    $curl = curl_init();
    curl_setopt_array(
        $curl, 
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
    foreach ($response as $event)
        //echo $event['name'].' '. $event['description'] . ' '.$event['website']. ' ' .$event['contacts'];
?>
                </div>
            </div>
        </div>
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