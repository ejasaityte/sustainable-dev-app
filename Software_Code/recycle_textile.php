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
        body { margin: 0; padding: 0; }
        #map { position: relative; width: 100%; height: 500px; }
        </style>
    </head>
    <?php session_start();
        include("dbconnect.php"); ?>
    <body>
        <style>
            .mapboxgl-popup {
            max-width: 500px;
            font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
            }
        </style>
        <?php include("navbar.php"); ?>
        <script>
        var element = document.getElementById('recycle');
        element.classList.add("active");
        </script>
            <div class="container-fluid text-center">
                <h1 class="display-5 fw-bold">Find recycling points in Dundee!</h1>
            </div>
        <?php
            echo "<div id='map'></div>
            <script>
                mapboxgl.accessToken = 'pk.eyJ1IjoibGF1cmFuYXMiLCJhIjoiY2sybnRqODB5MHE5cjNibnozNnlndGEwcyJ9.oaxzA4cGRd_-3QgjdqKETg';
                const map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: [-2.9707, 56.4620],
                    pitchWithRotate: false,
                    trackResize: true,
                    zoom: 13
                });
                map.on('load', () => {
                    map.loadImage('https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Recycle001.svg/30px-Recycle001.svg.png',
                        (error, image) => {
                            if (error) throw error;
                            map.addImage('custom-marker', image);
                            map.addSource('places', {
                                'type': 'geojson',
                                'data': {
                                    'type': 'FeatureCollection',
                                    'features': [";
                                    $url = "http://inspire.dundeecity.gov.uk/geoserver/opendata/wfs?version=2.0.0&service=wfs&request=GetFeature&typeName=opendata:recycling_facilities&outputFormat=json";
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
                                
                                    foreach ($response['features'] as $point) { // TODO refactor
                                        $i += 1;
                                        if($point["properties"]["TEXTILES"] == "y" )
                                        {
                                            echo "
                                                {
                                                    'type': 'Feature',
                                                    'properties': {
                                                        'icon': 'theatre',
                                                        'description':
                                                            '<p style=\'font-size: 15px;\'><strong> " . str_replace("'","\'",$point["properties"]["NAME"]) . " </strong></p><p>(" . $point["properties"]["ACCESS_PUBLIC_PRIVATE"] . ")</p><hr>";
                                                            if($point["properties"]["PAPER_CARD"] == "y")
                                                            {
                                                                echo "<p><strong>Paper</strong></p>";
                                                            }
                                                            if($point["properties"]["GLASS"] == "y")
                                                            {
                                                                echo "<p><strong>Glass</strong></p>";
                                                            }
                                                            if($point["properties"]["PLASTIC_BOTTLES"] == "y")
                                                            {
                                                                echo "<p><strong>Plastic</strong></p>";
                                                            }
                                                            if($point["properties"]["ALUMINIUM_CANS"] == "y")
                                                            {
                                                                echo "<p><strong>Aluminium cans</strong></p>";
                                                            }
                                                            if($point["properties"]["TEXTILES"] == "y")
                                                            {
                                                                echo "<p style=\'color:red;\'><strong>Textiles</strong></p>";
                                                            }
                                                            echo "'},
                                                        'geometry': {
                                                            'type': 'Point',
                                                            'coordinates': [" . $point["properties"]["LONGITUDE"] . ", " . $point["properties"]["LATITUDE"] . "]
                                                            }
                                                    }";    
                                                    if ($i != count($response['features'])) {
                                                        echo ","; 
                                                    }
                                                }    
                                        else {continue;} 
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
                                    'icon-image': 'custom-marker'
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
        </div>

        <div class="d-flex flex-wrap bg-primary justify-content-center">
            <a class="m-3" href="/recycle" style="text-decoration: none; width: 75px;">
                <h1 class="feature text-white">All</h1>
            </a>
            <a class="m-3"  href="/recycle/recycle_textile" ">
                <img src="https://mapsonline.dundeecity.gov.uk/dcc_gis_root/dcc_gis_config/app_config/recycling/icons/mixed_textiles_p75.png" alt="Textile">
            </a>
            <a class="m-3" href="/recycle/recycle_plastic">
                <img src="https://mapsonline.dundeecity.gov.uk/dcc_gis_root/dcc_gis_config/app_config/recycling/icons/plastic_pack_p75.png" alt="Plastic">
            </a>
            <a class="m-3" href="/recycle/recycle_glass">
            <img src="https://mapsonline.dundeecity.gov.uk/dcc_gis_root/dcc_gis_config/app_config/recycling/icons/mixed_glass_p75.png" alt="Glass">
            </a>
            <a class="m-3" href="/recycle/recycle_paper">
                <img src="https://mapsonline.dundeecity.gov.uk/dcc_gis_root/dcc_gis_config/app_config/recycling/icons/mixed_paper_p75.png" alt="Paper">
            </a>
            <a class="m-3" href="/recycle/recycle_alum">
                <img src="https://mapsonline.dundeecity.gov.uk/dcc_gis_root/dcc_gis_config/app_config/recycling/icons/aluminium_cans_p75.png" alt="Aluminium cans">
            </a>
         
        </div>

    
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
