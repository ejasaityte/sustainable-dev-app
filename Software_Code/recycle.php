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
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-lg-5">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link active" href="/map/0">Explore</a></li>
                        <li class="nav-item"><a class="nav-link" href="/news">News</a></li>
                        <li class="nav-item"><a class="nav-link" href="/leaderboard">Leaderboard</a></li>
                        <?php
       if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        ?>
            <li class="nav-item"><a class="nav-link" href="/favouriteslist">Favourites</a></li>
            <li class="nav-item"><a class="nav-link" href="/addfriend">Friends</a></li>
              
              <?php 
              if ($_SESSION['isadmin']==1) { ?>
              <li class="nav-item"><a class="nav-link" href="/addevent">Add Event</a></li>
              <?php } 
                  if ($_SESSION['username']=='admin') { ?>
                  <li class="nav-item"><a class="nav-link" href="/adduser">Add User</a></li>
                  <?php } ?>
              <li class="nav-item"><a class="nav-link" href="/logout">Log out</a></li>
              <?php } 
              else{
              ?>
              <li class="nav-item"><a class="nav-link" href="/login"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
              <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
      <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
            <div class="container-fluid text-center">
                <h1 class="display-5 fw-bold">Find recycling points in Dundee!</h1>
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
                        map.addSource('places', {
                            type: 'geojson',
                            // Use a URL for the value for the `data` property.
                            data: 'http://inspire.dundeecity.gov.uk/geoserver/opendata/wfs?version=2.0.0&service=wfs&request=GetFeature&typeName=opendata:recycling_facilities&outputFormat=json'
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
       
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Sustainable Dundee 2021</p></div>
        </footer>
    
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
