<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sustainable Dundee</title>
        <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <style>
    body { margin: 0; padding: 0; }
    #map { position: absolute; top: 0; bottom: 0; width: 100%; }
    </style>
    </head>
    <?php session_start(); ?>
    <body>
        <style>
        .mapboxgl-popup {
        max-width: 400px;
        font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
        }
        </style>
        <div class="main">
            <!-- Responsive navbar-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-lg-5">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="/map">Explore</a></li>
                            <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            ?>
                    <li class="nav-item"><a class="nav-link" href="/favouriteslist">Favourites</a></li>
                    <li class="nav-item"><a class="nav-link" href="/additem"><span class="glyphicon glyphicon-pencil"></span>Add Item</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Log out</a></li>
                    <?php } 
                    else{
                    ?>
                    <li class="nav-item"><a class="nav-link" href="/login"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
            <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
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
                center: [-77.04, 38.907],
                zoom: 11.15
                });
                 
                map.on('load', () => {
                map.addSource('places', {
                'type': 'geojson',
                'data': {
                'type': 'FeatureCollection',
                'features': [
                {
                'type': 'Feature',
                'properties': {
                'description':
                '<strong>Make it Mount Pleasant</strong><p>Make it Mount Pleasant is a handmade and vintage market and afternoon of live entertainment and kids activities. 12:00-6:00 p.m.</p>'
                },
                'geometry': {
                'type': 'Point',
                'coordinates': [-77.038659, 38.931567]
                }
                },
                {
                'type': 'Feature',
                'properties': {
                'description':
                '<strong>Mad Men Season Five Finale Watch Party</strong><p>Head to Lounge 201 (201 Massachusetts Avenue NE) Sunday for a Mad Men Season Five Finale Watch Party, complete with 60s costume contest, Mad Men trivia, and retro food and drink. 8:00-11:00 p.m. $10 general admission, $20 admission and two hour open bar.</p>'
                },
                'geometry': {
                'type': 'Point',
                'coordinates': [-77.003168, 38.894651]
                }
                },
                {
                'type': 'Feature',
                'properties': {
                'description':
                '<strong>Big Backyard Beach Bash and Wine Fest</strong><p>EatBar (2761 Washington Boulevard Arlington VA) is throwing a Big Backyard Beach Bash and Wine Fest on Saturday, serving up conch fritters, fish tacos and crab sliders, and Red Apron hot dogs. 12:00-3:00 p.m. $25.</p>'
                },
                'geometry': {
                'type': 'Point',
                'coordinates': [-77.090372, 38.881189]
                }
                },
                {
                'type': 'Feature',
                'properties': {
                'description':'<strong>Ballston Arts & Crafts Market</strong><p>The Ballston Arts & Crafts Market sets up shop next to the Ballston metro this Saturday for the first of five dates this summer. Nearly 35 artists and crafters will be on hand selling their wares. 10:00-4:00 p.m.</p>'
                },
                'geometry': {
                'type': 'Point',
                'coordinates': [-77.111561, 38.882342]
                }
                },
                {
                'type': 'Feature',
                'properties': {
                'description':
                '<strong>Seersucker Bike Ride and Social</strong><p>Feeling dandy? Get fancy, grab your bike, and take part in this year\'s Seersucker Social bike ride from Dandies and Quaintrelles. After the ride enjoy a lawn party at Hillwood with jazz, cocktails, paper hat-making, and more. 11:00-7:00 p.m.</p>'
                },
                'geometry': {
                'type': 'Point',
                'coordinates': [-77.052477, 38.943951]
                }
                },
                {
                'type': 'Feature',
                'properties': {
                'description':
                '<strong>Capital Pride Parade</strong><p>The annual Capital Pride Parade makes its way through Dupont this Saturday. 4:30 p.m. Free.</p>'
                },
                'geometry': {
                'type': 'Point',
                'coordinates': [-77.043444, 38.909664]
                }
                },
                {
                'type': 'Feature',
                'properties': {
                'description':
                '<strong>Muhsinah</strong><p>Jazz-influenced hip hop artist Muhsinah plays the Black Cat (1811 14th Street NW) tonight with Exit Clov and Gods’illa. 9:00 p.m. $12.</p>'
                },
                'geometry': {
                'type': 'Point',
                'coordinates': [-77.031706, 38.914581]
                }
                },
                {
                'type': 'Feature',
                'properties': {
                'description':
                '<strong>A Little Night Music</strong><p>The Arlington Players\' production of Stephen Sondheim\'s <em>A Little Night Music</em> comes to the Kogod Cradle at The Mead Center for American Theater (1101 6th Street SW) this weekend and next. 8:00 p.m.</p>'
                },
                'geometry': {
                'type': 'Point',
                'coordinates': [-77.020945, 38.878241]
                }
                },
                {
                'type': 'Feature',
                'properties': {
                'description':
                '<strong>Truckeroo</strong><p>Truckeroo brings dozens of food trucks, live music, and games to half and M Street SE (across from Navy Yard Metro Station) today from 11:00 a.m. to 11:00 p.m.</p>'
                },
                'geometry': {
                'type': 'Point',
                'coordinates': [-77.007481, 38.876516]
                }
                }
                ]
                }
                });
                // Add a layer showing the places.
                map.addLayer({
                'id': 'places',
                'type': 'circle',
                'source': 'places',
                'paint': {
                'circle-color': '#4264fb',
                'circle-radius': 6,
                'circle-stroke-width': 2,
                'circle-stroke-color': '#ffffff'
                }
                });
                 
                // Create a popup, but don't add it to the map yet.
                const popup = new mapboxgl.Popup({
                closeButton: false,
                closeOnClick: false
                });
                 
                map.on('mouseenter', 'places', (e) => {
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
                popup.remove();
                });
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
