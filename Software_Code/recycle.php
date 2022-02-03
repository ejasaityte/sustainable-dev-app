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
    <?php session_start(); ?>
    <body>
        <style>
        .mapboxgl-popup {
        max-width: 500px;
        font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
        }
        </style>
        <?php include("navbar.php"); ?>
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
            map.loadImage('https://icons.iconarchive.com/icons/robinweatherall/recycling/256/recycle-2-icon.png',
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
                                echo "
                                    {
                                        'type': 'Feature',
                                        'properties': {
                                        'description':
                                            '<strong> " . $point['NAME'] . " </strong><p>(" . $point['ACCESS_PUBLIC_PRIVATE'] . ")</p><p><strong>Paper</strong>: " . $point['PAPER_CARD'] . "</p><p><strong>Glass</strong>: " . $point['GLASS'] . "</p><p><strong>Plastic</strong>: " . $point['PLASTIC_BOTTLES'] . "</p><p><strong>Books/Music</strong>: " . $point['BOOKS_MUSIC'] . "</p>";
                                        echo "'},
                                        'geometry': {
                                            'type': 'Point',
                                            'coordinates': [" . $point["properties"]["LONGITUDE"] . ", " . $point["properties"]["LATITUDE"] . "]
                                            }
                                        }";
                                        if ($i != count($response['features'])) {
                                            echo ","; 
                                        }
                                    //echo "},";       
                                }
                            //echo ","; 
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
        
        
        
</script>";
php?>
            <!-- Footer-->
        </div>
       
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Sustainable Dundee 2021</p></div>
        </footer>
    
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
