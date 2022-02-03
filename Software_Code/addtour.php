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
        var element = document.getElementById('addtour');
        element.classList.add("active");
    </script>
    <br>
    <div class="container-fluid text-center">
        <h1 class="display-5 fw-bold">Add new event</h1>
    </div>
    <br>
    <div class="container-fluid" style="width:30%; min-width:200px;">
        <form action="" method="post">
            <div class="d-grid gap-2">
                <div class="input-group">
                    <input type="text" class="form-control" id="name" minlength="3" name="name" min-length="3"
                        placeholder="Name" required>
                    <div class="invalid-tooltip"> Please enter the tour name.</div>
                </div>
                <div class="input-group">
                    <select class="form-select" aria-label="Pick a goal" id="goal">
                        <option selected>Pick a goal this tour relates to</option>
                        <?php
                            $curl = curl_init();
                            curl_setopt_array(
                                $curl, 
                                array(
                                    CURLOPT_URL => "https://sustainabledundeeapp.azurewebsites.net/api/allGoals",
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
                            $response = json_decode($response, true);

                            for ($i = 0; $i < 17; $i++)
                            {
                                echo '<option value="$i">' . $response[i]["goalName"] . '</option>'
                            }
                        php?>
                    </select>
                </div>
                <div class="input-group">
                    <select class="form-select" aria-label="Pick a destination" id="destination">
                        <option selected>Pick a destination</option>
                        
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add Event</button>
            </div>
        </form>
    </div>


    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>