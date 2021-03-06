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
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            position: relative;
            width: 100%;
            height: 500px;
        }
    </style>
</head>
<?php session_start();
    include("dbconnect.php");
?>

<body>
    <style>
        .mapboxgl-popup {
            max-width: 500px;
            font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
        }
    </style>
    <?php include("navbar.php"); ?>
    <script>
        var element = document.getElementById('explore');
        element.classList.add("active");
    </script>
    <div class="container-fluid text-center">
        <h1 class="display-5 fw-bold">See our locations!</h1>
    </div>
    <?php
                echo "<div id='map'></div>
                <script>
                    mapboxgl.accessToken = 'pk.eyJ1IjoiZXVhbmRvY2tpbmciLCJhIjoiY2t5dmt1aTZvMXpqMTJxcHR2eTF2Z21zOCJ9.yZNbnAG0QP59OzGsTYFX1A';
                    const map = new mapboxgl.Map({
                        container: 'map',
                        style: 'mapbox://styles/mapbox/streets-v11',
                        center: [-2.9707, 56.4620],
                        pitchWithRotate: false,
                        trackResize: true,
                        zoom: 13
                    });
                    
                    map.on('load', () => {
                        map.loadImage('https://i.imgur.com/lz3uxL1.png',
                            (error, image) => {
                                if (error) throw error;
                                map.addImage('custom-marker', image);
                                map.addSource('places', {
                                    'type': 'geojson',
                                    'data': {
                                        'type': 'FeatureCollection',
                                        'features': [";

                                            $url = "https://sustainabledundeeapp.azurewebsites.net/api/allEventsCoords";
                                            $goalID = $params['goalID'];
                                            if ($goalID != 0) {
                                                $url = "https://sustainabledundeeapp.azurewebsites.net/api/EventsFromGoal/" . $goalID;
                                            }

                                            $curl = curl_init();
                                                    curl_setopt_array($curl, array(
                                                    CURLOPT_URL => $url,
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

                                                    $i = 0;
                                                    foreach ($response as $event) { // TODO refactor
                                                        $i += 1;
                                                        echo "
                                                        {
                                                        'type': 'Feature',
                                                        'properties': {
                                                            'description':
                                                            '<strong> " . $event['name'] . " </strong><p>" . $event['description'] . "</p><strong>For more information visit the <a href=" . $event['website'] . ">website</a></strong><p><strong>Contact</strong>: " . $event['contacts'] . "</p><p><strong>Address</strong>: " . $event['address'] . "</p>";

                                                            if($_SESSION['loggedin'] == true){
                                                            echo "<div class=\'col-sm-auto text-center\' style=\'padding-bottom:10px;\'\> <a class=\'btn btn-primary btn-sm mt-auto\' href=\'/checkin/" . $_SESSION['userID'] . "\'>Check in</a></div\>";
                                                            if (str_word_count($event['name']) > 1)
                                                            {
                                                                $str = explode(" ", $event['name']);
                                                                $name = implode("", $str);
                                                            }
                                                            else {
                                                                $name = $event['name'];
                                                            }
                                                            echo 
                                                                "<div class=\'col-sm-auto  text-center\' style=\'padding-bottom:10px;\'\><a data-bs-toggle=\'tooltip\' data-bs-placement=\'right\' title=\'Tweet\' href=\'https://twitter.com/intent/tweet?text=I%20just%20visited%20%23" . $name . "%21%20@DundeeCouncil&hashtags=sustainabledundee\' target=\'_blank\'\><img src=\'https://logos-world.net/wp-content/uploads/2020/04/Twitter-Emblem.png\'  style=\'width:50px;height:28px;\'\></a></div></div></div>";
                                                            }
                                                        echo "'},
                                                        'geometry': {
                                                            'type': 'Point',
                                                            'coordinates': [" . $event['lon'] . ", " . $event['lat'] . "]
                                                        }
                                                        }";
                                                        if ($i != count($response)) {
                                                            echo ","; 
                                                        }
                                                    }
                                            echo "
                                        ]
                                    }
                                });

                                // Add a layer showing the places.
                                map.addLayer({
                                    'id': 'places',
                                    'type': 'symbol',
                                    'source': 'places',
                                    'layout': {
                                        'icon-image': 'custom-marker',
                                    }
                                });
                            }
                        );
                    });
                    
                    // Create a popup, but don't add it to the map yet.
                    const popup = new mapboxgl.Popup({
                        closeButton: false,
                        closeOnClick: true
                    });
                    
                    map.on('click', 'places', (e) => {
                        // Change the cursor style as a UI indicator.
                        map.getCanvas().style.cursor = 'pointer';
                    
                        // Copy coordinates array.
                        const coordinates = e.features[0].geometry.coordinates.slice();
                        const description = e.features[0].properties.description;
                    
                        // Ensure that if the map is zoomed out such that multiple
                        // copies of the feature are visible, the popup appears
                        // over the copy being pointed to.
                        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                        }
                    
                        // Populate the popup and set its coordinates
                        // based on the feature found.
                        popup.setLngLat(coordinates).setHTML(description).addTo(map);
                    });

                    map.on('mouseleave', 'places', () => {
                        map.getCanvas().style.cursor = '';
                    });

                    // Add geolocate control to the map.
                    map.addControl(
                        new mapboxgl.GeolocateControl({
                            positionOptions: {
                                enableHighAccuracy: true
                            },
                            // When active the map will receive updates to the device's location as it changes.
                            trackUserLocation: true,
                            // Draw an arrow next to the location dot to indicate which direction the device is heading.
                            showUserHeading: true
                        })
                    );
                    
                </script>";
            php?>
    <!-- Footer-->
    </div>
    <div class="d-flex flex-wrap bg-primary justify-content-center">
        <a class="m-3" href="/map/0">
            <h1 class="feature bg-primary bg-gradient text-white rounded-3">All</h1>
        </a>
        <?php

                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://sustainabledundeeapp.azurewebsites.net/api/allGoals",
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

                foreach ($response as $goal) {
                    echo '<a class="m-3" href="/map/'.$goal['goalID'].'"><img class="feature bg-primary bg-gradient text-white" src="' . $goal['goalPicture'] . '"></a>';
                }

                php?>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>