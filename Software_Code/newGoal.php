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

            echo '<img style="max-width: 350px;" src="'.$response[0]['goalPicture'].'" class="mx-auto d-block mw-100" alt="'.$response[0]['goalName'].'">';
            echo '<div class="bg-mikado rounded-3 my-3 w-100"><p class="fs-4">'.$response[0]['goalDescription'].'</p></div>';
            echo '<a class="btn btn-ygreen btn-lg white w-100 mb-3" href="/map/'.$goalID.'"><u>Click here to see related events on the map!</u></a>';
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
        echo '
            <div class="bg-rose rounded-3 p-3 m-2 w-100">
                <h1 class="white">'.$event['name'].'</h1> 
                <p class="white">'.$event['description'].'</p> 
                <p class="white">Postcode: '.$event['postcode'].'</p> 
                <p class="white">Contacts: '.$event['contacts'].'</p>
                <a class="btn bg-mikado btn-lgw-100 mb-3" href="'.$event['website'].'"><u>Click here to find out more</u></a>
        ';
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