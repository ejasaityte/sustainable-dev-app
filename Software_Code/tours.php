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
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            top: 0;
            bottom: 0;
            width: 50%;
            height: 400px;
            float: left;
        }
    </style>
</head>
<?php session_start(); 
    if (!isset($_SESSION['favouriteslist']))
    {
        $_SESSION['favouriteslist'] = array();
    }
    ?>

<body>
    <style>
        #features {
            width: 50%;
            max-height: 400px;
            font-family: sans-serif;
            overflow-y: scroll;
            background-color: #fafafa;
        }

        section {
            padding: 25px 50px;
            line-height: 25px;
            border-bottom: 1px solid #ddd;
            opacity: 0.25;
            font-size: 13px;
        }

        section.active {
            opacity: 1;
        }

        section:last-child {
            border-bottom: none;
            margin-bottom: 200px;
        }
    </style>
    <!-- Responsive navbar-->
    <?php include("navbar.php"); ?>
    <script>
        var element = document.getElementById('tours');
        element.classList.add("active");
    </script>
    <!-- Page Content-->
    <div class="container-fluid text-center">
        <h1 class="display-5 fw-bold">Tours Avaialable</h1>
    </div>
    <div class="container px-lg-5">
        <div style="" class="map-container">
            <!-- Page Features-->
            <?php
                    echo "<div id='map'></div>
                    <div id='features'>
                        <section id='tour1' class='active'>
                            <h3>Tour Destination 1</h3>
                            <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </section>
                        <section id='tour2'>
                            <h3>Tour Destination 2</h3>
                            <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </section>
                        <section id='tour3'>
                            <h3>Tour Destination 3</h3>
                            <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </section>
                        <section id='tour4'>
                            <h3>Tour Destination 4</h3>
                            <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </section>
                        <section id='tour5'>
                            <h3>Tour Destination 5</h3>
                            <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </section>
                    </div>
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
                            
                        const chapters = {
                            'tour1': {
                            bearing: 27,
                            center: [-0.15591514, 51.51830379],
                            zoom: 15.5,
                            pitch: 20
                            },
                            'tour2': {
                            duration: 6000,
                            center: [-0.07571203, 51.51424049],
                            bearing: 150,
                            zoom: 15,
                            pitch: 0
                            },
                            'tour3': {
                            bearing: 90,
                            center: [-0.08533793, 51.50438536],
                            zoom: 13,
                            speed: 0.6,
                            pitch: 40
                            },
                            'tour4': {
                            bearing: 90,
                            center: [0.05991101, 51.48752939],
                            zoom: 12.3
                            },
                            'tour5': {
                            bearing: 45,
                            center: [-0.18335806, 51.49439521],
                            zoom: 15.3,
                            pitch: 20,
                            speed: 0.5
                            }
                        };

                        map.on('load', function () {
                            map.resize();
                        });
                                
                        let activeChapterName = 'tour1';
                        function setActiveChapter(chapterName) {
                            if (chapterName === activeChapterName) return;
                                
                            map.flyTo(chapters[chapterName]);
                                
                            document.getElementById(chapterName).classList.add('active');
                            document.getElementById(activeChapterName).classList.remove('active');
                                
                            activeChapterName = chapterName;
                        }
                                
                        function isElementOnScreen(id) {
                            const element = document.getElementById(id);
                            const bounds = element.getBoundingClientRect();
                            return bounds.top < document.getElementById('features').clientHeight && bounds.bottom > 150;
                        }
                                
                        // On every scroll event, check which element is on screen
                        document.getElementById('features').onscroll = () => {
                            for (const chapterName in chapters) {
                                if (isElementOnScreen(chapterName)) {
                                    setActiveChapter(chapterName);
                                    break;
                                }
                            }
                        };
                            
                    </script>";
                php?>
        </div>
        <div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error, aut suscipit mollitia eaque ipsam,
                aspernatur neque reprehenderit, quasi veritatis ipsum eos? Assumenda odit expedita adipisci earum minima
                distinctio, amet praesentium.</p>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>