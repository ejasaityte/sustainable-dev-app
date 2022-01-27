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
    <?php session_start(); 
    if (!isset($_SESSION['favouriteslist']))
    {
        $_SESSION['favouriteslist'] = array();
    }
    ?>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-lg-5">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/map/0">Explore</a></li>
                        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
          ?>
                <li class="nav-item"><a class="nav-link" href="/favouriteslist">Favourites</a></li>
                <li class="nav-item"><a class="nav-link" href="/addevent">Add Event</a></li>
                <?php 
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
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <div class="main">
        <header class="py-5">
            <div class="container px-lg-5">
                <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
                    <div class="m-4 m-lg-5">
                        <?php
                        $goalID = $params['goal'];

                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://sustainabledundeeapp.azurewebsites.net/api/singleGoal/$goalID",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_TIMEOUT => 29,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_0_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array(
                            "cache-control: no-cache"
                        ),
                        ));

                        $response = curl_exec($curl);
                        $err = curl_error($curl);

                        curl_close($curl);
                        // Decode JSON data into PHP array
                        $response = json_decode($response, true);

                        foreach ($response as $goal) { // TODO refactor
                            echo '<h1 class="display-5 fw-bold">'.$goal['goalName'].'</h1>';
                            echo '<p class="fs-4">'.$goal['goalDescription'].'</p>';
                            break; // This should run once
                        }
                        
                        echo "<a class='btn btn-primary btn-lg' href='/map/" . $goalID . "'>Explore the map!</a>";
                    php?>
                    </div>
                </div>
            </div>
        </header>
        <!-- Page Content-->
        <section class="pt-4">
            <div class="container px-lg-5">
                <!-- Page Features-->
                <div class="row gx-lg-5">

                <?php
                
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://sustainabledundeeapp.azurewebsites.net/api/allEvents/$goalID",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);
                // Decode JSON data into PHP array
                $response = json_decode($response, true);
                
                foreach ($response as $event) {
                    echo '
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <h2 class="fs-4 fw-bold">' . $event['name'] . '</h2></a>
                                <p class="mb-0">' . $event['description'] . '</p>
                                <p class="text-start">For more information visit the <a href=' . $event['website'] . '>website</a></p> 
                                <p class="text-start">Contact: ' . $event['contacts'] . '</p>

                            </div>';
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                        echo '
                        <div class="container" style="padding-bottom:10px;">
                                        <div class="row">
                                            <div class="col text-center">
                                                <a class="btn btn-primary btn-sm mt-auto" href="/additem/' . $event['id'] . '"">Favourite</a>
                                            </div>
                                        </div>
                                    </div>
                        ';
                    } 
                    echo '
                        </div>
                    </div>';
                }
                
                php?>

                </div>
            </div>
        </section>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Sustainable Dundee 2021</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
